<?php
/*------------------------------------------------------------------------
04.# plg_fcomment
05.# ------------------------------------------------------------------------
06.# Gyula Komar
07.# copyright Copyright (C) 2011 Build Web.eu All Rights Reserved.
08.# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
09.# Websites: http://www.buildweb.eu
10.# Technical Support:  Forum - http://www.buildweb.eu/index.php?option=com_content&view=article&id=58&Itemid=81&lang=en
11.-------------------------------------------------------------------------*/

//For step by step instructions see: http://www.buildweb.eu/index.php?option=com_content&view=article&id=73&Itemid=81&lang=en

//Replaces {fcomment} tag in content with Facebook Comments Module. 
//You can use the moderation feature if you provide a Facebook Application ID and lint your URL at http://developers.facebook.com/tools/lint/.
//To get an App ID go to http://developers.facebook.com/ select MyApps and Set Up New App.

//to include e.g. to virtuemart go to themes/..php and add 
//echo JHTML::_('content.prepare','{fcomment}')
//VM cookies must be switched off

defined( '_JEXEC' ) or die();
if (!defined('DS')) {define('DS', DIRECTORY_SEPARATOR );}

jimport( 'joomla.event.plugin' );

class plgContentfcomment extends JPlugin 
{

	function plgContentfcomment( &$subject, $params ) 
	{
		parent::__construct( $subject, $params );
 	}

	function onContentPrepare( $context, &$row, &$params, $limitstart=0 )
	{
		global $mainframe;

		static $first_og=1;

		$regex = '/{(fcomment)\s*(.*?)}/i';

		$plugin	=& JPluginHelper::getPlugin('content', 'fcomment');
		$pluginParams = $this->params;

		$width=$pluginParams->get('width','');
		$num_posts=$pluginParams->get('num_posts','');
		$app_id=$pluginParams->get('app_id','');
		$colorscheme=$pluginParams->get('colorscheme','');
		$mail_to=$pluginParams->get('mail_to','');
		$mail_subject=$pluginParams->get('mail_subject','New post');
		$og_url=$pluginParams->get('og_url','');
		$og_type=$pluginParams->get('og_type','article');
		$og_image=$pluginParams->get('og_image','');
		$mobile=$pluginParams->get('mobile','');
		if ($mobile=='0') $mobile='';
		if ($mobile=='1') $mobile=' mobile="false"';
		if ($mobile=='2') $mobile=' mobile="true"';

		$uri =& JURI::getInstance();
		$curl = $uri->toString();

		$config =& JFactory::getConfig();

		$lang=&JFactory::getLanguage();
		$lang_tag=$lang->getTag();
		$lang_tag=str_replace("-","_",$lang_tag);

		$matches = array();
		preg_match_all( $regex, $row->text, $matches, PREG_SET_ORDER );

		$doc =& JFactory::getDocument();
		if ($first_og && (count($matches)>0))
		{
			if ($app_id!="") {$doc->addCustomTag('<meta property="fb:app_id" content="'.$app_id.'"/>');}
			if ($og_url=="1")
			{
				$doc->addCustomTag('<meta property="og:type" content="'.$og_type.'"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$curl.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.$config->get('sitename').'"/>');
				$doc->addCustomTag('<meta property="og:locale" content="'.$lang_tag.'"/>');
			}
			if ($og_image!="") $doc->addCustomTag('<meta property="og:image" content="'.$og_image.'"/>');
		}
		$first_og=0;

		$mail_from=$config->get( 'fromname' )." <".$config->get( 'mailfrom' ).">";

		$sendmailphp=JURI::base();
		$sendmailphp.="plugins".DS."content".DS."fcomment".DS."fcomment_sendmail.php";

		foreach ($matches as $args) 
		{
			$args=str_replace(" ","&", $args);
			parse_str( $args[2], $pars );

			$str="";

			if (isset($pars['lang'])) {$lang_tag=$pars['lang'];}
			if (isset($pars['mail_to'])) {$mail_to=$pars['mail_to'];}
			if (isset($pars['num_posts'])) {$num_posts=$pars['num_posts'];}
			if (isset($pars['width'])) {$width=$pars['width'];}

			$uri =& JURI::getInstance();
			$curl = $uri->toString();

			$curl = str_replace("https://","http://",$curl);
			$curl = str_replace("/?option","/index.php?option",$curl);	//correct not proper facebook link
			$pos = strpos($curl,"&fb_comment_id");				//remove trailing fb_comment_id
			if ($pos) $curl=substr($curl,0,$pos);				
			$pos = strpos($curl,"?fb_comment_id");				//remove trailing fb_comment_id
			if ($pos) $curl=substr($curl,0,$pos);				

			$id="";if (isset($pars['id'])) {$id=$pars['id'];}
			if ($id!="")
			{
				$article = JTable::getInstance('content');
				$article->load($id);
				$slug = $article->get('id').':'.$article->get('alias');
				$catid = $article->get('catid');
				$catslug = $catid ? $catid .':'.$article->get('category_alias') : $catid;
				$sectionid = $article->get('sectionid');
			
				$curl = 'http://';
				if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]=="on") {$curl='https://';};
				$curl .= $_SERVER["SERVER_NAME"];
				$curl .= JRoute::_(ContentHelperRoute::getArticleRoute($slug, $catslug, $sectionid));
			}

			if (isset($pars['url'])) 
			{
				$curl=$pars['url'];
				$curl=str_replace("~","=",$curl);
				$curl=str_replace("#","&",$curl);
			}

			$mail_body=$curl;

			$url="<plugin name=fcomment version=3.0.28/>";
			$url.="<div id=\"fb-root\"></div>";
			if ($pluginParams->get('mail_to','')=="")
			{
		 	 $ai='';
		 	 if ($app_id!="") {$ai='appId='.$app_id.'&amp;';}
		 	 $url.="<script src=\"http://connect.facebook.net/".$lang_tag."/all.js#".$ai."xfbml=1\"></script>";
			} else
			{
		 	 $scr="function sendmail() {\n";
		 	 $scr.="var xmlhttp;\n";
		 	 $scr.="if (window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();} else {xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');}\n";
			 $scr.="xmlhttp.open('GET','".$sendmailphp."?base=".urlencode(JPATH_BASE)."&body=".urlencode($mail_body)."',true);\n";
			 $scr.="xmlhttp.send();\n";
			 $scr.="};\n";
			 $scr.="window.fbAsyncInit = function() {\n";
			 $scr.="FB.init({appId: '".$app_id."', status: true, cookie: true, xfbml: true});\n";
			 $scr.="FB.Event.subscribe('comment.create', function (response) {sendmail();});\n";
			 $scr.="};\n";
			 $doc->addScriptDeclaration($scr);

			 $url.="<script type=\"text/javascript\">\n";
			 $url.="(function() {\n";
			 $url.="var e = document.createElement('script');\n";
			 $url.="e.type = 'text/javascript';\n";
			 $url.="e.src =  'http://connect.facebook.net/".$lang_tag."/all.js';\n";
			 $url.="e.async = true;\n";
			 $url.="document.getElementById('fb-root').appendChild(e);\n";
			 $url.="}());\n";
			 $url.="</script>\n";
			};
			
			$url.="<fb:comments width=\"".$width."\" num_posts=\"".$num_posts."\" href=\"".$curl."\" colorscheme=\"".$colorscheme."\"".$mobile."></fb:comments>";

			$row->text = preg_replace($regex, $url, $row->text, 1);
		}
	}
}
?>
