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
<section class="element">
	<header class="element-header">
		<h3 class="element-title"><?php echo $element->elementType->name?></h3>
	</header>
	<div class="element-data">
		<div class="row data-row">
			<div class="large-2 column">
				<div class="data-label"><?php echo $element->getAttributeLabel('site_id')?></div>
			</div>
			<div class="large-10 column">
				<div class="data-value"><?php echo $element->site ? $element->site->name : 'None'?></div>
			</div>
		</div>
		<div class="row data-row">
			<div class="large-2 column">
				<div class="data-label"><?php echo $element->getAttributeLabel('laser_id')?></div>
			</div>
			<div class="large-10 column">
				<div class="data-value"><?php echo $element->laser ? $element->laser->name : 'None'?></div>
			</div>
		</div>
		<div class="row data-row">
			<div class="large-2 column">
				<div class="data-label"><?php echo $element->getAttributeLabel('surgeon_id')?></div>
			</div>
			<div class="large-10 column">
				<div class="data-value"><?php echo $element->surgeon ? $element->surgeon->ReversedFullName : 'None'?></div>
			</div>
		</div>
	</div>
</section>
