(function () {


    var fileButtonCount = 0;


    function checkDialog(editor, dialogName, definition, elements) {
        var element;

        for (var i in elements) {
            element = elements[i];


            if (dialogName == 'filebrowser')
                continue;

            if (typeof element == 'function' || element == null || element.type == 'undefined' || element.type == null)
                continue;

            if (element.type && (element.type == 'hbox' || element.type == 'vbox'))
                checkDialog(editor, dialogName, definition, element.children);

            if (!element.filebrowser)
                continue;


            if (typeof element.filebrowser == 'string')
                return; // filebrowser has been disbaled

            if (element.filebrowser.action == 'Browse') {
                fileButtonCount++
            }
        }
    }


    CKEDITOR.plugins.add('autolaunchfilebrowser',
	 {
	     init: function (editor) {
	         var pluginPath = this.path;

	         CKEDITOR.on('instanceReady', function (evt) {
	             var editor = evt.editor;

	             CKEDITOR.on('dialogDefinition', function (evt) {
	                 var dialogName = evt.data.name;

	                 fileButtonCount = 0;

	                 checkDialog(evt.editor, evt.data.name, evt.data.definition, evt.data.definition.contents[0].elements);


	                 var dialogAutolaunchFilebrowser = evt.data.name + 'AutolaunchFilebrowser';

	                 editor.on('dialogShow', function (evt) {
	                     var dialog = evt.data;


	                     if (dialogAutolaunchFilebrowser in editor.config && editor.config[dialogAutolaunchFilebrowser] || !(dialogAutolaunchFilebrowser in editor.config) && editor.config.autolaunchFilebrowser) {
	                         var count = fileButtonCount;

	                         if (count > 1)
	                             return;

	                         if (dialog._.name == 'filebrowser')
	                             return;


	                         if (dialog._.name != dialogName)
	                             return;

	                         var filebutton = dialog.getContentElement(dialog._.tabIdList[0], 'browse');

	                         if (!filebutton)
	                             return;
	                         var targetInfo = filebutton.filebrowser.target.split(':');

	                         var target = dialog.getContentElement(dialog._.tabIdList[0], targetInfo[1]);
	                         if (target && target.getValue())
	                             return;
	                         filebutton.fire('click');
	                     }
	                 });

	             });

	         });
	     }
	 });

})();