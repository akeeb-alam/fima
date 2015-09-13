<?php
 define('_JEXEC', 1 );
 define('DS', DIRECTORY_SEPARATOR );
 define('JPATH_BASE', $_REQUEST["base"] );

 require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
 require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

 $mainframe =& JFactory::getApplication('site');
 $mainframe->initialise();

 $plugin =& JPluginHelper::getPlugin('content', 'fcomment');
 $pluginParams = new JRegistry();
 $pluginParams->loadString($plugin->params);
 $config =& JFactory::getConfig();

 $mail_to=$pluginParams->get('mail_to','');
 $mail_from=$config->get( 'fromname' )." <".$config->get( 'mailfrom' ).">";
 $mail_subject=$pluginParams->get('mail_subject','New post');

 $headers = "From: " . $mail_from;
 if (mail($mail_to, $mail_subject, $_REQUEST["body"], $headers)) 
 {
   echo("<p>Message successfully sent!</p>");
 } else 
 {
   echo("<p>Message delivery failed...</p>");
 }
?>
