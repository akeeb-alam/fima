<?php
/*---------------------------------------------------------------
# SP Facebook - All in one facebook module for joomla
# ---------------------------------------------------------------
# Author - JoomShaper http://www.joomshaper.com
# Copyright (C) 2010 - 2013 JoomShaper.com. All Rights Reserved.
# license - PHP files are licensed under  GNU/GPL V2
# Websites: http://www.joomshaper.com - http://www.joomxpert.com
-----------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');

/* Basic Options */
$uniqid					= $module->id;
$plg_type 				= $params->get('plg_type');
$app_id					= $params->get('app_id', '354400064582736');
$plg_lang				= $params->get('plg_lang');

/* Activity Feed */
$actvity_domain			= $params->get('actvity_domain');
$actvity_width			= $params->get('actvity_width');
$actvity_height			= $params->get('actvity_height');
$actvity_header			= $params->get('actvity_header');
$actvity_colorscheme	= $params->get('actvity_colorscheme');
$actvity_font			= $params->get('actvity_font');
$actvity_recommendations = $params->get('actvity_recommendations');

/* Comments */
$auto_url				= $params->get('auto_url');
$comments_url			= $auto_url ? JURI::current() : $params->get('comments_url');
$comments_width			= $params->get('comments_width');
$comments_numposts		= $params->get('comments_numposts');
$comments_colorscheme	= $params->get('comments_colorscheme');

/* Facepile */
$fp_url					= $params->get('fp_url');
$fp_width				= $params->get('fp_width');
$fp_rows				= $params->get('fp_rows');

/* Like Box */
$likebox_url			= $params->get('likebox_url');
$likebox_width			= $params->get('likebox_width');
$likebox_height			= $params->get('likebox_height');
$likebox_colorscheme	= $params->get('likebox_colorscheme');	
$likebox_showfaces		= $params->get('likebox_showfaces');	
$likebox_stream			= $params->get('likebox_stream');
$likebox_header			= $params->get('likebox_header');
$likebox_show_border	= $params->get('likebox_show_border', 'true');

/* Like Button */
$likebtn_url			= $params->get('likebtn_url');
$likebtn_sendbtn		= $params->get('likebtn_sendbtn');
$likebtn_layout			= $params->get('likebtn_layout');
$likebtn_width			= $params->get('likebtn_width');
$likebtn_showfaces		= $params->get('likebtn_showfaces');	
$likebtn_verd			= $params->get('likebtn_verd');
$likebtn_colorscheme	= $params->get('likebtn_colorscheme');	
$likebtn_font			= $params->get('likebtn_font');
	
/* Live Stream */
$livestream_appid		= $params->get('livestream_appid');
$livestream_width		= $params->get('livestream_width');
$livestream_height		= $params->get('livestream_height');
$livestream_xid			= $params->get('livestream_xid');
$livestream_attr_url	= $params->get('livestream_attr_url');
$livestream_posttofrnd	= $params->get('livestream_posttofrnd');	

/* Recommendations */
$rec_domain				= $params->get('rec_domain');
$rec_width				= $params->get('rec_width');
$rec_height				= $params->get('rec_height');
$rec_showheader			= $params->get('rec_showheader');
$rec_colorscheme		= $params->get('rec_colorscheme');
$rec_font				= $params->get('rec_font');
$rec_border				= $params->get('rec_border');

/* Send Button */
$send_url				= $params->get('send_url');
$send_font				= $params->get('send_font');
$send_colorscheme		= $params->get('send_colorscheme');

$doc = JFactory::getDocument();
$doc->addScript ('//connect.facebook.net/'.$plg_lang.'/all.js#xfbml=1&appId='. $app_id);

require(JModuleHelper::getLayoutPath('mod_sp_facebook',$plg_type));//Load Layout