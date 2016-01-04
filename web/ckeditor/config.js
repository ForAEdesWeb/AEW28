/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

        config.language = 'zh';
	config.toolbar = 'Full';
	config.skins = 'kama';

	config.filebrowserImageUploadUrl = '/ckeditor/upload.php?type=img';
	config.filebrowserFlashUploadUrl = '/ckeditor/upload.php?type=flash';

	config.width = 600;
	config.height = 500;
};
