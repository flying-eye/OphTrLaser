<?php

class DefaultController extends NestedElementsEventTypeController
{
	// This map defines which elements can import eyedraw data from the most recent element type in the current episode
	static $IMPORT_ELEMENTS = array(
			'Element_OphTrLaser_PosteriorPole' => 'Element_OphCiExamination_PosteriorPole',
			'Element_OphTrLaser_AnteriorSegment' => 'Element_OphCiExamination_AnteriorSegment'
			);

	protected function _jsCreate()
	{
		$l_by_s = array();
		foreach (OphTrLaser_Site_Laser::model()->findAll() as $slaser) {
			$l_by_s[$slaser->site_id][] = array('id' => $slaser->id, 'name' => $slaser->name);
		}
		Yii::app()->getClientScript()->registerScript('OphTrLaserJS', 'var lasersBySite = ' . CJavaScript::encode($l_by_s) . ';', CClientScript::POS_HEAD);
	}

	protected function beforeAction($action)
	{
		if (!Yii::app()->getRequest()->getIsAjaxRequest() && !(in_array($action->id,$this->printActions())) ) {
			$this->registerCssFile('spliteventtype.css', Yii::app()->createUrl('css/spliteventtype.css'));
			Yii::app()->getClientScript()->registerScriptFile(Yii::app()->createUrl('js/spliteventtype.js'));
		}

		return parent::beforeAction($action);
	}

	public function actionCreate()
	{
		$this->_jsCreate();
		return parent::actionCreate();
	}

	public function actionUpdate($id)
	{
		$this->_jsCreate();
		return parent::actionUpdate($id);
	}
	/*
	 * look for and import eyedraw values from most recent related element if available
	 */
	protected function importElementEyeDraw($element)
	{
		// because we only do import from examination at this point, we can simply check that the module is installed
		// before proceeding
		if ($this->episode && Yii::app()->hasModule('OphCiExamination') ) {
			if (array_key_exists(get_class($element), self::$IMPORT_ELEMENTS)) {
				$event_type_id = EventType::model()->find('class_name = :name', array(':name' => 'OphCiExamination'))->id;
				$criteria = new CDbCriteria;
				$criteria->compare('event.episode_id',$this->episode->id);
				$criteria->compare('event.event_type_id',$event_type_id);
				$criteria->order = 'event.created_date desc';
				$criteria->limit = 1;
				// try and find the element type we're suppposed to import from
				$import = ElementType::model(self::$IMPORT_ELEMENTS[get_class($element)])->with('event')->find($criteria);

				if ($import) {
					$element->left_eyedraw = $import->left_eyedraw;
					$element->right_eyedraw = $import->right_eyedraw;
					$element->eye_id = $import->eye_id;
				}
			}
		}

	}

	/*
	 * override to call the eyedraw import for loaded elements
	 */
	protected function getElementForElementForm($element_type, $previous_id = 0, $additional)
	{
		$element = parent::getElementForElementForm($element_type, $previous_id, $additional);

		// do eyedraw import
		$this->importElementEyeDraw($element);

		return $element;
	}

	/*
	 * override to call the eyedraw import for loaded elements
	 */
	protected function getCleanDefaultElements($event_type_id)
	{
		$elements = parent::getCleanDefaultElements($event_type_id);
		foreach ($elements as $el) {
			$this->importElementEyeDraw($el);
		}

		return $elements;
	}

	/*
	 * override to call the eyedraw import for loaded elements
	 */
	protected function getCleanChildDefaultElements($parent, $event_type_id)
	{
		$elements = parent::getCleanChildDefaultElements($parent, $event_type_id);
		foreach ($elements as $el) {
			$this->importElementEyeDraw($el);
		}
		return $elements;
	}

	/*
	 * sets values for the many many fields without touching the database (used prior to validation)
	 *
	 */
	protected function setPOSTManyToMany($element)
	{
		if (get_class($element) == 'Element_OphTrLaser_Treatment') {
			if (isset($_POST['treatment_right_procedures'])) {
				foreach ($_POST['treatment_right_procedures'] as $proc_id) {
					$right_procedures[] = Procedure::model()->findByPk($proc_id);
				}
				$element->right_procedures = $right_procedures;
			}
			if (isset($_POST['treatment_left_procedures'])) {
				foreach ($_POST['treatment_left_procedures'] as $proc_id) {
					$left_procedures[] = Procedure::model()->findByPk($proc_id);
				}
				$element->left_procedures = $left_procedures;
			}
		}
	}

	/*
	 * similar to setPOSTManyToMany, but will actually call methods on the elements that will create database entries
	 * should be called on create and update.
	 *
	 */
	protected function storePOSTManyToMany($elements)
	{
		foreach ($elements as $el) {
			if (get_class($el) == 'Element_OphTrLaser_Treatment') {
				$el->updateRightProcedures(isset($_POST['treatment_right_procedures']) ? $_POST['treatment_right_procedures'] : array());
				$el->updateLeftProcedures(isset($_POST['treatment_left_procedures']) ? $_POST['treatment_left_procedures'] : array());
			}
		}
	}

	/*
	 * ensures Many Many fields processed for elements
	 */
	public function createElements($elements, $data, $firm, $patientId, $userId, $eventTypeId)
	{
		if ($id = parent::createElements($elements, $data, $firm, $patientId, $userId, $eventTypeId)) {
			// create has been successful, store many to many values
			$this->storePOSTManyToMany($elements);
		}
		return $id;
	}

	/*
	 * ensures Many Many fields processed for elements
	 */
	public function updateElements($elements, $data, $event)
	{
		if (parent::updateElements($elements, $data, $event)) {
			// update has been successful, now need to deal with many to many changes
			$this->storePOSTManyToMany($elements);
		}
		return true;
	}

}
