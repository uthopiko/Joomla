<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

/**
 * Configuration view for JomSocial
 */
Class CommunityViewSystem extends JViewLegacy
{

	public function display( $tpl = null )
	{
		// Set the titlebar text
		JToolBarHelper::title( JText::_('System Health Check'), 'system' );

		// Add the necessary buttons
		JToolBarHelper::back( JText::_('COM_COMMUNITY_HOME'), 'index.php?option=com_community');

		// Add submenu
		$contents = '';
		ob_start();
		require_once( JPATH_ROOT . '/administrator/components/com_community/views/system/tmpl/submenu.php' );

		$contents = ob_get_contents();
		ob_end_clean();

		$document	= JFactory::getDocument();

		$document->setBuffer($contents, 'modules', 'submenu');

		$xml		= JPATH_COMPONENT . '/community.xml';
		$parser 	= new SimpleXMLElement( $xml , NULL , true );

		$this->assign( 'version'	, $parser->version );

		parent::display( $tpl );
	}
}
?>