<?php
/*------------------------------------------------------------------------
# Copyright (C) 2005-2012 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.event.plugin');
jckimport('ckeditor.htmlwriter.javascript');


class plgEditorImageCSS extends JPlugin 
{
		
  	function plgEditorImageCSS(& $subject, $config) 
	{
		parent::__construct($subject, $config);
	}

	function beforeLoad(&$params)
	{
	
		$css = $params->get('jcktypography',false);
   
	
		if(!$css)
			return false;

		//lets create JS object
		$javascript = new JCKJavascript();	
	
		$javascript->addScriptDeclaration(
			"editor.on( 'configLoaded', function()
			{
				var styleDefinitions = editor.config.stylesSet;
			       styleDefinitions.push( { name : 'Caption Photo', element : 'img', attributes : { 'class' : 'caption photo' } });
			       styleDefinitions.push( { name : 'Caption PhotoBlack', element : 'img', attributes : { 'class' : 'caption photoblack' } });
			       styleDefinitions.push( { name : 'Caption PhotoBlue', element : 'img', attributes : { 'class' : 'caption photoblue' } });
			       styleDefinitions.push( { name : 'Caption PhotoGreen', element : 'img', attributes : { 'class' : 'caption photogreen' } });
			       styleDefinitions.push( { name : 'Caption PhotoRed', element : 'img', attributes : { 'class' : 'caption photored' } });
			       styleDefinitions.push( { name : 'Caption PhotoYellow', element : 'img', attributes : { 'class' : 'caption photoyellow' } });
			});"	
		);
		
		return $javascript->toRaw();
		
	}

}