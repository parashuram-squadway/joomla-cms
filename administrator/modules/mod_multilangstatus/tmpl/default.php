<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_multilangstatus
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Setup the modal options
$options = array();
$options['url']    = JRoute::_('index.php?option=com_languages&view=multilangstatus&tmpl=component');
$options['height'] = 300;
$options['width']  = 700;
$options['title']  = JText::_('MOD_MULTILANGSTATUS');

?>
<div class="btn-group multilanguage">
	<?php echo JHtml::_('bootstrap.renderModal', 'modal-multilang', $options); ?>
	<a class="modal" data-toggle="modal" data-target="#modal-multilang">
		<i class="icon-comment"></i><?php echo JText::_('MOD_MULTILANGSTATUS');?>
	</a>
</div>
