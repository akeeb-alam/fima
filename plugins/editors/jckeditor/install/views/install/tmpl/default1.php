<?php 
/*------------------------------------------------------------------------
# Copyright (C) 2005-2012 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 
defined('JPATH_BASE') or die;


?>
<script type="text/javascript">
function submitform(pressbutton){
	if (pressbutton) {
		document.adminForm.task.value=pressbutton;
	}
	if (typeof document.adminForm.onsubmit == "function") {
		document.adminForm.onsubmit();
	}
	document.adminForm.submit();
}

var Joomla = {};

Joomla.submitbutton = function(pressbutton) {
	submitform(pressbutton);
}
</script>

<div class="header">
	<div class="innerHeader">
	<img src="images/headerTitle.png" height="48" width="155" />
	</div>
</div>
 <form name="adminForm" action="index.php" method="post">
<div class="container">	
	<div class="mainBody">
		<h3><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_SYSTEM_HEALTH_CHECK'); ?></h3>
		<fieldset class="adminform">
		<legend><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_EDITOR_FILE_PERMISSIONS'); ?></legend>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><img align="middle" src="images/<?php echo ($this->nonExecutableFilesTotal ? 'warning.png' : 'tick.png'); ?>"/></td>
			<td colspan="2"><?php echo $this->nonExecutableFilesTotal .' '. JText::_('PLG_JCK_INSTALL_WIZARD_FILES_NOT_EXECUTABLE');?>: plugins/editors/jckeditor</td>			
			<td width="20%" align="right"><?php if($this->nonExecutableFilesTotal): ?><a href="javascript: Joomla.submitbutton('changeexecutablepermission')"><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_CHANGE_NOW'); ?></a><?php endif;?></td>
		</tr>
		<tr>
			<td><img align="middle" src="images/<?php echo ($this->incorrectChmodFilesTotal ? 'warning.png' : 'tick.png'); ?>"/></td>
			<td colspan="2"><?php echo $this->incorrectChmodFilesTotal .' '. JText::_('PLG_JCK_INSTALL_WIZARD_FILES_WITH_NOT_RECOMMENDED_PERMISSIONS');?> (<?php echo  (int) $this->permission; ?>)</td>			
			<td width="20%" align="right"><?php if($this->incorrectChmodFilesTotal): ?><a href="javascript: Joomla.submitbutton('changefilespermission')"><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_CHANGE_NOW'); ?></a><?php endif;?></td>
		</tr>
		<tr>
			<td><img align="middle" src="images/<?php echo ($this->incorrectChmodFoldersTotal ? 'warning.png' : 'tick.png'); ?>"/></td>
			<td colspan="2"><?php echo $this->incorrectChmodFoldersTotal .' '. JText::_('PLG_JCK_INSTALL_WIZARD_FOLDERS_WITH_NOT_RECOMMENDED_PERMISSIONS');?> (<?php echo  (int) $this->folderPermission; ?>)</td>			
			<td width="20%"align="right"><?php if($this->incorrectChmodFoldersTotal): ?><a href="javascript: Joomla.submitbutton('changefolderspermission')"><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_CHANGE_NOW'); ?></a><?php endif;?></td>
		</tr>
		</table>
		</fieldset>
		<fieldset class="adminform" style="margin-top:10px;">
		<legend><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_IMAGE_FOLDER_PERMISSION'); ?></legend>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="40"><img align="middle" src="images/<?php echo ($this->nonWritableImageFolderTotal ? 'warning.png' : 'tick.png'); ?>"/></td>
			<td colspan="2"><?php echo $this->nonWritableImageFolderTotal .' '. JText::_('PLG_JCK_INSTALL_WIZARD_FOLDERS_NOT_WRITABLE'); ?></td>			
			<td width="20%" align="right"><?php if($this->nonWritableImageFolderTotal): ?><a href="javascript: Joomla.submitbutton('changeimagefolderswritablepermission')"><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_CHANGE_NOW'); ?></a><?php endif;?></td>
		</tr>
		</table>
		</fieldset>
	</div>
</div>
<div class="buttons left">
<button onclick="document.adminForm.task.value='';document.adminForm.submit();"><<< <?php echo JText::_('PLG_JCK_INSTALL_WIZARD_PREV');?></button>
</div>
<div class="buttons">
  <input type="submit" value="<?php echo JText::_('PLG_JCK_INSTALL_WIZARD_NEXT');?>  >>>" />
</div>
<input type="hidden" name="task" value="font" />	
 </form>