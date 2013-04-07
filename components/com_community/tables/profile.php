<?php
/**
 * @category	Tables
 * @package		JomSocial
 * @subpackage	Activities
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class CTableProfile extends JTable
{
        var $userid                             = null;
	var $status                             = null;
	var $status_access			= null;
	var $point                              = null;
	var $posted_on                          = null;
        var $avatar                             = null;
	var $thumb                              = null;
	var $invite                             = null;
	var $params                             = null;
	var $view                               = null;
	var $friends                            = null;
  	var $groups                             = null;
  	var $friendcount			= null;
  	var $alias                              = null;
  	var $latitude                           = null;
  	var $longtitude                         = null;
  	var $profile_id                         = null;
  	var $storage                            = null;
  	var $watermark_has			= null;
  	var $search_email			= null;

    public function __construct( &$db )
    {
		parent::__construct( '#__community_users', 'userid', $db );

    }

    public function getAvatar()
    {
        // Get the avatar path. Some maintance/cleaning work: We no longer store
	// the default avatar in db. If the default avatar is found, we reset it
	// to empty. In next release, we'll rewrite this portion accordingly.
	// We allow the default avatar to be template specific.

        if ($this->avatar == 'components/com_community/assets/user.png')
        {
            $this->avatar = '';
            $this->store();
	}


	$avatar	= CUrlHelper::avatarURI($this->avatar, 'user.png');

	return $avatar;
    }

    public function removeAvatar(){
		if( JFile::exists( $this->avatar ) )
		{
			JFile::delete($this->avatar);
		}

		if( JFile::exists( $this->thumb ) )
		{
			JFile::delete($this->thumb);
		}

		$this->avatar = '';
		$this->thumb = '';
		$this->store();
	}

    /**
     * Set user profile avatar
     */
    public function setImage(  $path , $type = 'thumb' )
	{
		CError::assert( $path , '' , '!empty' , __FILE__ , __LINE__ );

		$db			=  $this->getDBO();

		// Fix the back quotes
		$path		= JString::str_ireplace( '\\' , '/' , $path );
		$type		= JString::strtolower( $type );

		// Test if the record exists.
		$oldFile	= $this->$type;

		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}

	    if( $oldFile )
		{
			// File exists, try to remove old files first.
			$oldFile	= JString::str_ireplace( '/' , '/' , $oldFile );

			// If old file is default_thumb or default, we should not remove it.
			//
			if(!JString::stristr( $oldFile , 'user.png' ) && !JString::stristr( $oldFile , 'user_thumb.png' ) )
			{
				jimport( 'joomla.filesystem.file' );
				JFile::delete($oldFile);
			}
		}
		$this->$type   = $path;
		$this->store();

        // Trigger profile avatar update event.
        if ($type == 'avatar') {
            $appsLib	= CAppPlugins::getInstance();
            $appsLib->loadApplications();
            $args 	= array();
            $args[]	= $this->userid;			// userid
            $args[]	= $oldFile;	// old path
            $args[]	= $path;		// new path

            $appsLib->triggerEvent( 'onProfileAvatarUpdate' , $args );
        }

	}
}

?>
