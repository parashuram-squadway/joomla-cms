<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  Component
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Base component routing class
 *
 * @package     Joomla.Libraries
 * @subpackage  Component
 * @since       3.3
 */
abstract class JComponentRouterBase implements JComponentRouterInterface
{
	/**
	 * Decode route segments
	 *
	 * @param   array  $segments  An array of route segments
	 *
	 * @return  array  Array of decoded route segments
	 *
	 * @since   3.3
	 */
	protected function decodeSegments($segments)
	{
		$total = count($segments);

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = preg_replace('/-/', ':', $segments[$i], 1);
		}

		return $segments;
	}

	/**
	 * Encode route segments
	 *
	 * @param   array  $segments  An array of route segments
	 *
	 * @return  array  Array of encoded route segments
	 *
	 * @since   3.3
	 */
	protected function encodeSegments($segments)
	{
		$total = count($segments);

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = str_replace(':', '-', $segments[$i]);
		}

		return $segments;
	}

	/**
	 * Generic method to preprocess a URL
	 *
	 * @param   array  $query  An associative array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   3.3
	 */
	public function preprocess($query)
	{
		return $query;
	}
}
