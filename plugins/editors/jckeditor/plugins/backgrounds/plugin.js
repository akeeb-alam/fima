/*
 * @file Background plugin for CKEditor
 * Copyright (C) 2011-13 Alfonso Martínez de Lizarrondo
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 */

// A placeholder just to notify that the plugin has been loaded
CKEDITOR.plugins.add( 'backgrounds',
{
	lang: ["en","es","de","fi","fr","nl","ru"],
	
	init : function( editor )
	{
		// It doesn't add commands, buttons or dialogs, it doesn't do anything here
	} //Init
} );


// This is the real code of the plugin
CKEDITOR.on( 'dialogDefinition', function( ev )
	{
		// Take the dialog name and its definition from the event data.
		var dialogName = ev.data.name,
			dialogDefinition = ev.data.definition,
			editor = ev.editor,
			tabName = '';

		// Check if it's one of the dialogs that we want to modify and note the proper tab name.
		if ( dialogName == 'table' || dialogName == 'tableProperties' )
			tabName = 'advanced';

		if ( dialogName == 'cellProperties' )
			tabName = 'info';

		// Not one of the managed dialogs.
		if ( tabName == '' )
			return;

		// Get a reference to the tab.
		var tab = dialogDefinition.getContents( tabName ),
			lang = editor.lang.backgrounds;

		// The text field
		var textInput =  {
				type : 'text',
				label : lang.label,
				id : 'background',
				onLoad : function()
				{	
					var dialog = this.getDialog();
					var name = dialog.getName();
					
					if(name == 'tableProperties' || name =='table') //Add stylebox change handler
					{
						
						var styles = dialog.getContentElement( 'advanced', 'advStyles' );
						var me = this;
						if ( styles )
						{
							styles.on( 'change', function( evt )
								{
									// Synchronize width value.
									var raw = this.getStyle( 'background-image', '' );
									var background = raw && raw.replace(/url\(['"]?(.*?)['"]?\)/,'$1') || '';
									me.setValue( background, true );
								});
						}
					}
				
				},
			     
				onChange : dialogName == 'tableProperties' ||  dialogName == 'table' ? function()
				{
					var styles = this.getDialog().getContentElement( 'advanced', 'advStyles' );
					var value =  this.getValue();
					if(value)
						styles && styles.updateStyle( 'background-image',"url('" + this.getValue()+"')" );
					else
						styles && styles.updateStyle( 'background-image',"" );
				} : function(){},
				setup : function( selectedElement ) 
				{
					
					var raw = selectedElement.getStyle( 'background-image' );
					if(raw)
					{
						var value = raw.replace(/url\(['"]?(.*?)['"]?\)/,'$1');
						this.setValue( value );
					}	
				},
				commit : function( data, selectedElement )
				{
					var element = selectedElement || data,
						value = this.getValue();
					if ( value )
						element.setStyle( 'background-image', "url('" +value+"')");
					else
						element.removeStyle( 'background-image' );
				}
			};

		// File browser button
		var browseButton =  {
				type : 'button',
				id : 'browse',
				hidden : 'true',
				filebrowser :
				{
					action : 'Browse',
					target: tabName + ':background',
					url: editor.config.filebrowserImageBrowseUrl || editor.config.filebrowserBrowseUrl,
					params : //optional
					{
						type : 'Images',
						currentFolder : '/'
					}
				},
				label : editor.lang.common.browseServer,
				requiredContent : textInput.requiredContent
			};

				
		// The position field
		var backgroundPosition = {
			type: 'text',
			label: lang.position,
			id: 'backgroundPosition',
			onLoad : function()
			{	
				var dialog = this.getDialog();
				var name = dialog.getName();
		
				if(name == 'tableProperties' || name =='table') //Add stylebox change handler
				{
					var styles = dialog.getContentElement( 'advanced', 'advStyles' );
					var me = this;
					
					//override onChange function to add handler for event
					if ( styles )
					{
						styles.on( 'change', function( evt )
							{
								// Synchronize width value.
								var backgroundPosition = this.getStyle( 'background-position', '' );
								me.setValue( backgroundPosition, true );
							});
					}
				}
			
			},
			onChange : dialogName == 'tableProperties' || dialogName == 'table' ? function()
			{
				var styles = this.getDialog().getContentElement( 'advanced', 'advStyles' );
				styles && styles.updateStyle( 'background-position',this.getValue() );
			} : function(){},
			setup: function (selectedElement) 
			{
				this.setValue( selectedElement.getStyle('background-position') );
			},
			commit: function (data, selectedElement) {
				var element = selectedElement || data,
							value = this.getValue();
				if (value)
					element.setStyle('background-position', value);
				else
					element.removeStyle('background-position');
			}
		};

		// The repeat select field
		var backgroundRepeat = {
			type: 'select',
			label: lang.repeat,
			id: 'backgroundRepeat',
			items:
			[
				[ lang.repeatBoth, '' ],
				[ lang.repeatX, 'repeat-x' ],
				[ lang.repeatY, 'repeat-y' ],
				[ lang.repeatNone, 'no-repeat' ]
			],
			onLoad : function()
			{	
				var dialog = this.getDialog();
				var name = dialog.getName();
				
				if(name == 'tableProperties' || name =='table') //Add stylebox change handler
				{
					var styles = dialog.getContentElement( 'advanced', 'advStyles' );
					var me = this;
					if ( styles )
					{
						styles.on( 'change', function( evt )
							{
								// Synchronize width value.
								var backgroundRepeat = this.getStyle( 'background-repeat', '' );
								me.setValue( backgroundRepeat, true );
							});
					}
				}
			
			},
			onChange : dialogName == 'tableProperties' || dialogName == 'table' ? function()
			{
				var styles = this.getDialog().getContentElement( 'advanced', 'advStyles' );
				styles && styles.updateStyle( 'background-repeat',this.getValue() );
			} : function(){},

			setup: function (selectedElement) 
			{
			
				this.setValue( selectedElement.getStyle('background-repeat') );
			},
			commit: function (data, selectedElement) {
				var element = selectedElement || data,
							value = this.getValue();
				if (value)
					element.setStyle('background-repeat', value);
				else
					element.removeStyle('background-repeat');
			}
		};

		// Enabled/disabled automatically in 4.1 by ACF
		if ( dialogName == 'cellProperties' )
		{
			textInput.requiredContent = 'td[background];th[background]';
			backgroundPosition.requiredContent = 'td[background];th[background]';
			backgroundRepeat.requiredContent = 'td[background];th[background]';
		}
		else
		{
			textInput.requiredContent = 'table[background]';
			backgroundPosition.requiredContent = 'table[background]';
			backgroundRepeat.requiredContent = 'table[background]';
		}
		
		// Add the elements to the dialog
		if (tabName == 'advanced') 
		{
			// Two rows
			tab.add(textInput);
			tab.add(browseButton);
			tab.add({
				type: 'hbox',
				widths: ['', '100px'],
				children: [backgroundPosition, backgroundRepeat ]
			});
		}
		else
		{
			// In the cell dialog add it as a single row
			browseButton.style = 'display:inline-block;margin-top:10px;';
			tab.add({
					type : 'hbox',
					widths: [ '', '100px'],
					children : [ textInput, browseButton],
					requiredContent : textInput.requiredContent
			});
			tab.add({
				type: 'hbox',
				widths: ['', '100px'],
				children: [backgroundPosition, backgroundRepeat]
			});
		}

		
	// inject this listener before the one from the fileBrowser plugin so there are no problems with the new fields.
	}, null, null, 9 );


// Translations 
(function() {
	var textsEn = {
		label	: 'Background image',
		position : 'Background position',
		repeat: 'Background repeat',
		repeatBoth : 'Repeat',
		repeatX : 'Horizontally',
		repeatY : 'Vertically',
		repeatNone : 'None'
	};
	var textsEs = {
		label	: 'Imagen de fondo',
		position : 'Posición del fondo',
		repeat: 'Repetición del fondo',
		repeatBoth : 'Repetir',
		repeatX : 'Horizontalmente',
		repeatY : 'Verticalmente',
		repeatNone : 'Ninguno'
	};
	
	var textsDe = {
		label	: 'Hintergrund',
		position : 'Hintergrund position',
		repeat: 'Hintergrund repeat',
		repeatBoth : 'Repeat',
		repeatX : 'horizontal',
		repeatY : 'vertikal',
		repeatNone : 'None'
	};
	
	var textsFi = {
		label	: 'tausta',
		position : 'taustaa kanta',
		repeat: 'Repetición del fondo',
		repeatBoth : 'taustaa toista',
		repeatX : 'vaakatasossa',
		repeatY : 'pystysuoraan',
		repeatNone : 'Keine'
	};
	
	var textsFr = {
		label	: "L'image de fond",
		position : "Position de fond",
		repeat: 'Répétition de fond',
		repeatBoth : 'Répéter',
		repeatX : 'horizontalement',
		repeatY : 'verticalement',
		repeatNone : 'Aucun'
	};
	
	var textsNl = {
		label	: 'Achtergrond',
		position : 'Achtergrond positie',
		repeat: 'Background repeat',
		repeatBoth : 'Herhalen',
		repeatX : 'Horizontaal',
		repeatY : 'Verticaal',
		repeatNone : 'Geen'
	};
	
	var textsRu = {
		label	: 'Фоновое изображение',
		position : 'положение фона',
		repeat: 'Repetición del fondo',
		repeatBoth : 'повторять',
		repeatX : 'горизонтально',
		repeatY : 'вертикально',
		repeatNone : 'Ни один'
	};
	
	CKEDITOR.plugins.setLang( "backgrounds", "en", { backgrounds : textsEn } );
	CKEDITOR.plugins.setLang( "backgrounds", 'es', { backgrounds : textsEs } );
	CKEDITOR.plugins.setLang( "backgrounds", 'de', { backgrounds : textsDe } );
	CKEDITOR.plugins.setLang( "backgrounds", 'fi', { backgrounds : textsFi} );
	CKEDITOR.plugins.setLang( "backgrounds", 'fr', { backgrounds : textsFr} );
	CKEDITOR.plugins.setLang( "backgrounds", 'nl', { backgrounds : textsNl} );
	CKEDITOR.plugins.setLang( "backgrounds", 'ru', { backgrounds : textsRu} );


})();