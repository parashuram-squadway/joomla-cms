<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  Extension
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/**
 * Helper class with common tasks used in extension processing
 *
 * @package     Joomla.Libraries
 * @subpackage  Extension
 * @since       3.2
 */
abstract class JExtensionHelper
{
	/**
	 * Counts the number of enabled post-install messages for a given extension
	 *
	 * @param   integer  $extensionId  Extension ID to count messages for
	 *
	 * @return  mixed
	 *
	 * @since   3.2
	 */
	public static function countActivePostinstallMessages($extensionId)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery()
			->select('COUNT(*)')
			->from($db->quoteName('#__postinstall_messages'))
			->where($db->quoteName('extension_id') . ' = ' . (int) $extensionId)
			->where($db->quoteName('enabled') . ' = 1');

		return $db->setQuery($query)->execute();
	}
}
