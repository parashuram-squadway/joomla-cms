<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('ContentControllerArticles', __DIR__ . '/articles.php');

/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 */
class ContentControllerFeatured extends ContentControllerArticles
{
	/**
	 * The name of the controller
	 *
	 * @var    array
	 * @since  12.2
	 */
	protected $name = 'feature';

	/**
	 * Removes the featured status from an item
	 */
	public function delete()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		$app = JFactory::getApplication();

		// Get items to remove from the request.
		$cid = $app->input->get('cid', array(), 'array');

		if (!is_array($cid) || count($cid) < 1)
		{
			JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
		}
		else
		{
			$user = JFactory::getUser();

			// Access checks.
			foreach ($cid as $i => $id)
			{
				if (!$user->authorise('core.delete', 'com_content.article.' . (int) $id))
				{
					// Prune items that you can't delete.
					unset($cid[$i]);
					JError::raiseNotice(403, JText::_('JERROR_CORE_DELETE_NOT_PERMITTED'));
				}
			}

			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

			// Remove the items.
			if ($model->featured($cid))
			{
				$this->setMessage(JText::plural('COM_CONTENT_FEATURED_N_ITEMS_DELETED', count($cid)));
			}
			else
			{
				$this->setMessage($model->getError());
			}
		}

		// Invoke the postDelete method to allow for the child class to access the model.
		$this->postDeleteHook($model, $cid);

		$this->setRedirect('index.php?option=com_content&view=featured');
	}
}
