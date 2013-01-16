<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>

<div class="element <?php echo $element->elementType->class_name ?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	
	<?php if (!$element->elementType->required) {?>
	<div class="removeElement">
		<button class="classy blue mini">
			<span class="button-span icon-only"><img
				src="<?php echo Yii::app()->createUrl('img/_elements/btns/mini-cross.png')?>"
				alt="+" width="24" height="22"> </span>
		</button>
	</div>
	<?php }?>
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name; ?>
	</h4>
	
	<?php 
	$this->renderPartial(
		'form_' . get_class($element),
		array('element' => $element, 'data' => $data, 'form' => $form),
		false, false
	); 

	?>
	<?php if ($element->getElementType()->child_element_types) { ?>
		<div class="active_child_elements">
			<?php 
			$this->renderChildDefaultElements($element, $this->action->id, $form, $data);
			?>
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
		<div class="inactive_child_elements">
			<?php
			$this->renderChildOptionalElements($element, $this->action->id, $form, $data);
			?>
		</div>
	<?php } ?>	
</div>
