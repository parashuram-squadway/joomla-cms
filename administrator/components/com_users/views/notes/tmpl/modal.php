<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var $this UsersViewNotes */

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
?>
<div class="unotes">
<?php if (empty($this->items)) : ?>
	<?php echo JText::_('COM_USERS_NO_NOTES'); ?>
<?php else : ?>
	<dl>
	<?php foreach ($this->items as $item) : ?>
		<dt>
			<?php if ($item->subject) : ?>
				<?php echo JText::sprintf('COM_USERS_NOTE_N_SUBJECT', (int) $item->id, $this->escape($item->subject)); ?>
			<?php else : ?>
				<?php echo JText::sprintf('COM_USERS_NOTE_N_SUBJECT', (int) $item->id, JText::_('COM_USERS_EMPTY_SUBJECT')); ?>
			<?php endif; ?>
		</dt>

		<dd>
			<?php echo JHtml::date($item->created_time, 'D d M Y H:i'); ?>
		</dd>

		<?php $category_image = $item->cparams->get('image'); ?>

		<?php if ($item->catid && isset($category_image)) : ?>
		<dd>
			<?php echo JHtml::_('users.image', $category_image); ?>
		</dd>

		<dd class="fltlft utitle">
			<em><?php echo $this->escape($item->category_title); ?></em>
		</dd>
		<?php endif; ?>

		<dd class="ubody">
			<?php echo $item->body; ?>
		</dd>
	<?php endforeach; ?>
	</dl>
<?php endif; ?>
</div>
