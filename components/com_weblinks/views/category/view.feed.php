<?php
/**
 * @version		$Id$
 * @package		Joomla.Site
 * @subpackage	Weblinks
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	Weblinks
 * @since 1.0
 */
class WeblinksViewCategory extends JView
{
	function display($tpl = null)
	{
		$app	= &JFactory::getApplication();
		$document = &JFactory::getDocument();

		$document->link = JRoute::_('index.php?option=com_weblinks&view=category&id='.JRequest::getVar('id',null, '', 'int'));

		JRequest::setVar('limit', $app->getCfg('feed_limit'));
		$siteEmail = $app->getCfg('mailfrom');
		$fromName = $app->getCfg('fromname');
		$document->editor = $fromName;
		$document->editorEmail = $siteEmail;

		// Get some data from the model
		$items		= &$this->get('data');
		$category	= &$this->get('category');

		foreach ($items as $item)
		{
			// strip html from feed item title
			$title = $this->escape($item->title);
			$title = html_entity_decode($title);

			// url link to article
			$link = JRoute::_('index.php?option=com_weblinks&view=weblink&id='. $item->id);

			// strip html from feed item description text
			$description = $item->description;
			$date = ($item->date ? date('r', strtotime($item->date)) : '');

			// load individual item creator class
			$feeditem = new JFeedItem();
			$feeditem->title 		= $title;
			$feeditem->link 		= $link;
			$feeditem->description 	= $description;
			$feeditem->date			= $date;
			$feeditem->category   	= 'Weblinks';

			// loads item info into rss array
			$document->addItem($feeditem);
		}
	}
}
?>
