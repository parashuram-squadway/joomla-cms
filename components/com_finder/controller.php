<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JLoader::register('FinderHelperLanguage', JPATH_ADMINISTRATOR . '/components/com_finder/helpers/language.php');

/**
 * Finder Component Controller.
 *
 * @package     Joomla.Site
 * @subpackage  com_finder
 * @since       2.5
 */
class FinderController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached. [optional]
	 * @param   array    $urlparams  An array of safe url parameters and their variable types,
	 *                               for valid values see {@link JFilterInput::clean()}. [optional]
	 *
	 * @return  JControllerLegacy  This object is to support chaining.
	 *
	 * @since   2.5
	 */
	public function display($cachable = false, $urlparams = array())
	{
		$input = JFactory::getApplication()->input;
		$cachable = true;

		// Load plug-in language files.
		FinderHelperLanguage::loadPluginLanguage();

		// Set the default view name and format from the Request.
		$viewName = $input->get('view', 'search', 'word');
		$input->set('view', $viewName);

		// Don't cache view for search queries
		if ($input->get('q') || $input->get('f') || $input->get('t'))
		{
			$cachable = false;
		}

		$safeurlparams = array(
			'f' 	=> 'INT',
			'lang' 	=> 'CMD'
		);

		return parent::display($cachable, $safeurlparams);
	}

	/**
	 * Method to handle routing for a search request
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	public function search()
	{
		$input = $this->input;
		$post  = array();

		// Store the search term
		$post['q'] = $input->request->get('q', '', 'string');

		// Store the language if set
		if ($input->request->get('l', '', 'cmd'))
		{
			$post['l'] = $input->request->get('l', '', 'cmd');
		}

		// Get the static taxonomy filters if set
		if ($input->request->get('f', '', 'int'))
		{
			$post['l'] = $input->request->get('f', '', 'int');
		}

		// Get the dynamic taxonomy filters if set
		if ($input->request->get('t', '', 'array'))
		{
			$post['l'] = $input->request->get('t', '', 'array');
		}

		// Get the start date and start date modifier filters if set
		if ($input->request->get('d1', '', 'string'))
		{
			$post['l'] = $input->request->get('d1', '', 'string');
		}

		if ($input->request->get('w1', '', 'string'))
		{
			$post['l'] = $input->request->get('w1', '', 'string');
		}

		// Get the end date and end date modifier filters.
		if ($input->request->get('d2', '', 'string'))
		{
			$post['l'] = $input->request->get('d2', '', 'string');
		}

		if ($input->request->get('w2', '', 'string'))
		{
			$post['l'] = $input->request->get('w2', '', 'string');
		}

		// Search for a menu item that does not have any predefined search terms or filters
		$items = JFactory::getApplication()->getMenu()->getItems('link', 'index.php?option=com_finder&view=search&q=&f=');

		if (isset($items[0]))
		{
			$post['Itemid'] = $items[0]->id;
		}
		elseif ($this->input->getInt('Itemid') > 0)
		{
			// Use Itemid from requesting page only if there is no existing menu
			$post['Itemid'] = $this->input->getInt('Itemid');
		}

		$uri = JUri::getInstance();
		$uri->setQuery($post);
		$uri->setVar('option', 'com_finder');

		$this->setRedirect(JRoute::_('index.php' . $uri->toString(array('query', 'fragment')), false));
	}
}
