<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class AdminController extends ModuleAdminController
{
	public $defaultAction = "manageLasers";

	public function actionManageLasers()
	{
		$model_list = OphTrLaser_Site_Laser::model()->findAll(array('order' => 'display_order asc'));
		//$this->jsVars['OphTrIntravitrealinjection_sort_url'] = $this->createUrl('sortTreatmentDrugs');

		Audit::add('admin','list',null,false,array('module'=>'OphTrLaser','model'=>'OphTrLaser_Site_Laser'));

		$this->render('list_OphTrLaser_Manage_Lasers',array(
			'model_list' => $model_list,
			'title' => 'Manage Lasers',
			'model_class' => 'OphTrLaser_Site_Laser',
		));
	}

	public function actionAddLaser()
	{
		$model = new OphTrLaser_Site_Laser();
		$request = Yii::app()->getRequest();

		if ( $request->getPost('OphTrLaser_Site_Laser') ) {
			$model->attributes = $request->getPost('OphTrLaser_Site_Laser');

			if ($bottom_laser = OphTrLaser_Site_Laser::model()->find(array('order'=>'display_order desc'))) {
				$display_order = $bottom_laser->display_order+1;
			} else {
				$display_order = 1;
			}
			$model->display_order = $display_order;

			if ($model->save()) {
				Audit::add('admin','create',serialize($model->attributes),false,array('module'=>'OphTrLaser','model'=>'OphTrLaser_Site_Laser'));
				Yii::app()->user->setFlash('success', 'Laser created');

				$this->redirect(array('ManageLasers'));
			}
		}

		 $this->render('create', array(
			'model' => $model,
			'title' => 'Laser',
			'cancel_uri' => '/OphTrLaser/admin/manageLasers',
		));
	}

	public function actionEditLaser($action)
	{
		var_dump($action);

		echo "HERE ";

		$model = new OphTrLaser_Site_Laser();
		$request = Yii::app()->getRequest();

		if ( $request->getPost('OphTrLaser_Site_Laser') ) {
			$model->attributes = $request->getPost('OphTrLaser_Site_Laser');

			if ($bottom_laser = OphTrLaser_Site_Laser::model()->find(array('order'=>'display_order desc'))) {
				$display_order = $bottom_laser->display_order+1;
			} else {
				$display_order = 1;
			}
			$model->display_order = $display_order;

			if ($model->save()) {
				Audit::add('admin','create',serialize($model->attributes),false,array('module'=>'OphTrLaser','model'=>'OphTrLaser_Site_Laser'));
				Yii::app()->user->setFlash('success', 'Laser created');

				$this->redirect(array('ManageLasers'));
			}
		}

		$this->render('create', array(
			'model' => $model,
			'title' => 'Laser',
			'cancel_uri' => '/OphTrLaser/admin/manageLasers',
		));
	}


	/* public function actionEditTreatmentDrug($id)
	{
		if (!$model = OphTrIntravitrealinjection_Treatment_Drug::model()->findByPk((int) $id)) {
			throw new Exception('Treatment drug not found with id ' . $id);
		}

		if (isset($_POST['OphTrIntravitrealinjection_Treatment_Drug'])) {
			$model->attributes = $_POST['OphTrIntravitrealinjection_Treatment_Drug'];

			if ($model->save()) {
				Audit::add('admin','update',serialize($model->attributes),false,array('module'=>'OphTrIntravitrealinjection','model'=>'OphTrIntravitrealinjection_Treatment_Drug'));
				Yii::app()->user->setFlash('success', 'Treatment drug updated');

				$this->redirect(array('ViewTreatmentDrugs'));
			}
		}

		$this->render('update', array(
			'model' => $model,
			'title' => 'Treatment Drug',
			'cancel_uri' => '/OphTrIntravitrealinjection/admin/viewTreatmentDrugs',
		));
	}*/

	/*
	 * sorts the drugs into the provided order (NOTE does not support a paginated list of drugs)
	 */
	/* public function actionSortTreatmentDrugs()
	{
		if (!empty($_POST['order'])) {
			foreach ($_POST['order'] as $i => $id) {
				if ($drug = OphTrIntravitrealinjection_Treatment_Drug::model()->findByPk($id)) {
					$drug->display_order = $i+1;
					if (!$drug->save()) {
						throw new Exception("Unable to save drug: ".print_r($drug->getErrors(),true));
					}
				}
			}
		}
	}

	public function actionDeleteTreatmentDrugs()
	{
		$result = 1;

		foreach (OphTrIntravitrealinjection_Treatment_Drug::model()->findAllByPk($_POST['treatment_drugs']) as $drug) {
			if (!$drug->delete()) {
				$result = 0;
			}
		}

		echo $result;
	}*/
}
