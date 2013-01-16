<?php 	$this->breadcrumbs=array($this->module->id);
	$this->header();
?>
<h3 class="withEventIcon" style="background:transparent url(<?php echo $this->assetPath?>/img/medium.png) center left no-repeat;"><?php echo $this->event_type->name ?></h3>

<div>
	<?php 		$form = $this->beginWidget('BaseEventTypeCActiveForm', array(
			'id'=>'clinical-create',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class'=>'sliding'),
			// 'focus'=>'#procedure_id'
		));
	?>
	<?php  $this->displayErrors($errors)?>
		<div id="elements">
			<div id="active_elements">
				<?php  $this->renderDefaultElements($this->action->id, $form); ?>
			</div>
			<div class="optionals-header clearfix">
				<h4>Optional Elements</h4>
				<div>
					<span class="allButton"><a class="add-all" href="#">Add all</a><img
						src="<?php echo Yii::app()->createUrl('img/_elements/icons/extra-element_added.png')?>"
						alt="extra-element_added" width="30" height="20" /></span> <span
						class="allButton"><a class="remove-all" href="#">Remove all</a><img
						src="<?php echo Yii::app()->createUrl('img/_elements/icons/extra-element_remove.png')?>"
						alt="extra-element_remove" width="30" height="20" /></span>
				</div>
			</div>
			<div id="inactive_elements">
				<?php  $this->renderOptionalElements($this->action->id, $form); ?>
			</div>
		</div>
	<?php  $this->displayErrors($errors)?>
		<div class="cleartall"></div>
		<div class="form_button">
			<img class="loader" style="display: none;" src="/img/ajax-loader.gif" alt="loading..." />&nbsp;
			<button type="submit" class="classy green venti" id="et_save" name="save"><span class="button-span button-span-green">Save</span></button>
			<button type="submit" class="classy red venti" id="et_cancel" name="cancel"><span class="button-span button-span-red">Cancel</span></button>
		</div>
	<?php  $this->endWidget(); ?></div>

<?php  $this->footer(); ?>