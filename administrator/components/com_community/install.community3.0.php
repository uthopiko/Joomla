<?php

/**
 * @category    Core
 * @package     JomSocial
 * @copyright   (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license     GNU/GPL, see LICENSE.php
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of Ola component
 */
class com_communityInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// $parent is the class calling this method
		//$parent->getParent()->setRedirectURL('index.php?option=com_community');
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		//echo '<p>' . JText::_('com_community uninstall script') . '</p>';
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		// $parent is the class calling this method
		//echo '<p>' . JText::_('com_community update script') . '</p>';
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		//echo '<p>' . JText::_('com_community pre flight script') . '</p>';
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		// get the installing com_community version 
		$installer			= JInstaller::getInstance();
		$path				= $installer->getPath('manifest');
		$communityVersion	= $installer->getManifest()->version;

		if (JVERSION < '2.5.6' and $communityVersion >= '2.8.0')
		{
			JError::raiseNotice(1, 'JomSocial 2.8.x require minimum Joomla! CMS 2.5.6');
			return false;
		}

		$lang = JFactory::getLanguage();
		$lang->load('com_community', JPATH_ROOT.'/administrator');
		
		$destination = JPATH_ROOT.'/administrator/components/com_community/';
		$buffer      = "installing";
		
		if( ! JFile::write($destination.'installer.dummy.ini', $buffer))
		{
			ob_start();
			?>
			<table width="100%" border="0">
				<tr>
					<td>				
						There was an error while trying to create an installation file.
						Please ensure that the path <strong><?php echo $destination; ?></strong> has correct permissions and try again.
					</td>
				</tr>
			</table>
			<?php
			$html = ob_get_contents();
			@ob_end_clean();
		}
		else
		{
			$link = rtrim(JURI::root(), '/').'/administrator/index.php?option=com_community';
		
			ob_start();
			?>
			<style type="text/css">
				.adminform {text-align:left;}
				.adminform > tbody > tr > th { font-size:20px;}
				.button-next 
				{
					margin:20px 0px 40px;
					padding:10px 20px;
					color:#fefefe;
					font-size:16px;
					line-height:16px;
					text-align: center;
					font-weight: normal;
					color: #333;
					background: #9c3;
					border: solid 1px #690;
					cursor: pointer;
				}
			</style>
			<table width="100%" border="0">
				<tr>
					<td>				
						Thank you for choosing JomSocial, please click on the following button to complete your installation.
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" class="button-next" onclick="window.location = '<?php echo $link; ?>'" value="<?php echo JText::_('COM_COMMUNITY_INSTALLATION_COMPLETE_YOUR_INSTALLATION');?>"/>
					</td>
				</tr>
			</table>
			<?php
			$html = ob_get_contents();
			@ob_end_clean();
		}
		
		echo $html;
	}
}
