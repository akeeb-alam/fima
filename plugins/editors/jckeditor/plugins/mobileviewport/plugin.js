/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @imagemobile plugin.
 */
(function()
{
	// Register a plugin named "save".
	CKEDITOR.plugins.add( 'mobileviewport',
	{
		init : function( editor )
		{
	
			var mainDocument = CKEDITOR.document,
			mainWindow = mainDocument.getWindow();
			
			var viewPaneSize = mainWindow.getViewPaneSize();
						
				
			editor.on('resize', function(evt)
			{
				//webkit does not redraw iframe correctly when editor's width is <= 320px 
				var viewPaneSize = mainWindow.getViewPaneSize();
				if (CKEDITOR.env.iOS && parseInt(viewPaneSize.width) <= 320) 
				{									
					var iframe = document.getElementById('cke_contents_' + editor.name).firstChild;
					iframe.style.display = 'none';
					iframe.style.display = 'block';
				}
				
			});
		}
	});
})();
