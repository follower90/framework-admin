/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'ru';
	config.uiColor = '#F8F8F8';
	config.extraPlugins = 'filebrowser';

};

CKEDITOR.config.filebrowserBrowseUrl = '/public/admin/js/ckfinder/ckfinder.html';
CKEDITOR.config.filebrowserUploadUrl = '/public/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
CKEDITOR.config.filebrowserWindowWidth = '1000';
CKEDITOR.config.filebrowserWindowHeight = '700';
