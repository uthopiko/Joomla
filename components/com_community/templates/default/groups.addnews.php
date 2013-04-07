<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @params	isMine		boolean is this group belong to me
 * @params	members		An array of member objects 
 */
defined('_JEXEC') or die();
?>
<div class="cLayout cGroups-AddNews">
	<form class="cForm" name="addnews" method="post" action="<?php echo CRoute::getURI(); ?>">
		<ul class="cFormList cFormHorizontal cResetList">

			<li>
				<label for="title" class="form-label">*<?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_TITLE'); ?></label>
				<div class="form-field">
					<input type="text" name="title" id="title" size="40" class="input text" style="width: 90%" />
				</div>
			</li>
				
			<?php if ( $config->get( 'htmleditor' ) == 'jce' )  { ?>

			<li>
				<label for="message" class="form-label">*<?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_DESC'); ?></label>
				<div class="form-field">
					<?php
					if( $config->getBool('allowhtml') )
					{
					?>
						<div class="clr"></div>
		   				<div class="htmlTag"><?php echo JText::_('COM_COMMUNITY_HTML_TAGS_ALLOWED');?></div>
					<?php
					}?>
					<?php if( $config->get( 'htmleditor' ) ) : ?>
						<?php echo $editor->displayEditor( 'message',  $message , '95%', '450', '10', '20' , false ); ?>
					<?php else : ?>
						<textarea rows="3" cols="40" name="message" id="message" class="input textarea" style="width: 90%"></textarea>
					<?php endif; ?>
				</div>
			</li>

			<?php } else { ?>

			<li>
				<label for="message" class="form-label">*<?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_DESC'); ?></label>
				<div class="form-field">
		        <script type="text/javascript">
		        function saveContent()
		        {
					<?php echo $editor->saveText( 'message' ); ?>
					return true;
				}
		        </script>
				<?php if( $config->get( 'htmleditor' ) == 'none' && $config->getBool('allowhtml')) { ?>
					<div class="htmlTag"><?php echo JText::_('COM_COMMUNITY_HTML_TAGS_ALLOWED'); ?></div>
				<?php } ?>
					<?php if( $config->get( 'htmleditor' ) ) : ?>
						<?php echo $editor->displayEditor( 'message',  $message , '95%', '450', '10', '20' , false ); ?>
					<?php else : ?>
						<textarea rows="3" cols="40" name="message" id="message" class="textarea" style="width: 90%"></textarea>
					<?php endif; ?>

				</div>
			</li>

			<?php } ?>

			

			<?php if($params->get('groupannouncementfilesharing') > 0) { ?>
			<li class="has-seperator">
				<div class="form-field">
					<label for="filepermission-member" class="label-checkbox">
						<input type="checkbox" name="filepermission-member" value="1" class="input checkbox" />
						<?php echo JText::_('COM_COMMUNITY_FILES_ALLOW_MEMBERS')?>
					</label>
				</div>
			</li>
			<?php } ?>


			
			<li class="has-seperator">
				<div class="form-field">
					<span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span>
				</div>
			</li>
			
			<li class="form-action">
				<div class="form-field">
					<input type="submit" name="submit" value="<?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_ADD'); ?>" class="cButton cButton-Blue" onclick="saveContent();" />
					<input type="button" name="cancel" value="<?php echo JText::_('COM_COMMUNITY_CANCEL_BUTTON'); ?>" onclick="javascript:history.go(-1);return false;" class="cButton" />
					<?php echo JHTML::_( 'form.token' ); ?>
				</div>
			</li>
		</ul>
	</form>
</div>
