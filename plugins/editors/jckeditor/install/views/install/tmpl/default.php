<?php 
/*------------------------------------------------------------------------
# Copyright (C) 2005-2012 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 
defined('JPATH_BASE') or die;

$os = strtoupper(substr(PHP_OS, 0, 3));
$isWin = ($os === 'WIN');

$user = JFactory::getUser();

?>
<style>
a:link, a:visited,  a:active, a:hover   {text-decoration: none;}
</style>

</style>
<script src="../jscolor/jscolor.js" type="text/javascript"></script>
<script src="js/combobox.js" type="text/javascript"></script>
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
<form name="adminForm" id="adminForm" action="index.php" method="post">
<div class="container">	
	<div class="mainBody">
		<h3><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_WELCOME') .' '. $user->name; ?></h3>
		<fieldset class="adminform">
		<legend><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_GETTING_STARTED');?></legend>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td style="padding-right:10px;"><a href="http://www.joomlackeditor.com/installation-guide?start=3#setup_wizard" target="_blank"><img align="middle"  border="0" src="images/installguide.png"/></a></td>
			<td><?php echo JText::_('PLG_JCK_INSTALL_WIZARD_WELCOME_MSG');?></td>			
		</tr>
		</table>
		</fieldset>
	</div>
</div>
<div class="buttons">
<input type="submit" value="<?php echo JText::_('PLG_JCK_INSTALL_WIZARD_NEXT');?>  >>>" />
</div>	
<input type="hidden" name="task" value="permissions" />
 </form>