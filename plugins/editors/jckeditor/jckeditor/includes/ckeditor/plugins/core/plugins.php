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


class plgCorePlugins extends JPlugin 
{
		
  	function plgCorePlugins(& $subject, $config) 
	{
		parent::__construct($subject, $config);
	}
	

	//default method that is called
	function intialize(&$params) // Editor's params passed in
	{
		
		
		$javascript = new JCKJavascript();
		$javascript->addScriptDeclaration("
						
		(function()
		{
			    CKEDITOR.plugins.load = CKEDITOR.tools.override( CKEDITOR.plugins.load, function( originalLoad )
			    {
				    return function( name, callback, scope )
				    {
					    var allPlugins = {};

					    var loadPlugins = function( names )
					    {
						    originalLoad.call( this, names, function( plugins )
							    {
								    CKEDITOR.tools.extend( allPlugins, plugins );

								    var requiredPlugins = [];
								    for ( var pluginName in plugins )
								    {
									    var plugin = plugins[ pluginName ],
										    requires = plugin && plugin.requires;

									    if ( requires )
									    {
										    for ( var i = 0 ; i < requires.length ; i++ )
										    {
											    if ( !allPlugins[ requires[ i ] ] )
												    requiredPlugins.push( requires[ i ] );
										    }
									    }
								    }

								    if ( requiredPlugins.length )
									    loadPlugins.call( this, requiredPlugins );
								    else
								    {
									// Call the \"onLoad\" function for all plugins.
									for ( pluginName in allPlugins )
									{
										plugin = allPlugins[ pluginName ];
										CKEDITOR.fire(pluginName + CKEDITOR.tools.capitalize( this.fileName ) + 'Loaded' ,plugin );// AW needed to add hook when plugin is loaded
										if ( plugin.onLoad && !plugin.onLoad._called )
										{
											plugin.onLoad();
											plugin.onLoad._called = 1;
										}
									 }

									    // Call the callback.
									    if ( callback )
										    callback.call( scope || window, allPlugins );
								    }
							    }
							    , this);

					    };

					    loadPlugins.call( this, name );
				    };
			    });
		}
		)();");
		return $javascript->toRaw();
	}
}