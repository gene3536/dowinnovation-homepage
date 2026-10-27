/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.language                 = 'ko';
    config.docType                  = '<!DOCTYPE html">';
    config.font_defaultLabel        = '굴림';
    config.font_names               = '굴림/Gulim;돋움/Dotum;바탕/Batang;궁서/Gungsuh;Arial/Arial;Comic Sans MS/Comic Sans MS;Courier New/Courier New;Georgia/Georgia;Lucida Sans Unicode/Lucida Sans Unicode;Tahoma/Tahoma;Times New Roman/Times New Roman;Trebuchet MS/Trebuchet MS;Verdana/Verdana';
    config.fontSize_defaultLabel    = '12px';
    config.fontSize_sizes           = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;';
    config.resize_enabled           = true;
    config.autoUpdateElement		= true;
    config.enterMode                = CKEDITOR.ENTER_BR;
    config.shiftEnterMode           = CKEDITOR.ENTER_P;
    config.startupFocus             = false; //시작시 포커스
    config.uiColor                  = '#eaebe7';
    config.toolbarCanCollapse       = false;
    config.menu_subMenuDelay        = 0;
    config.allowedContent           = true;
    config.width                    = '100%';
    //config.filebrowserUploadUrl		= "/upload/ckupload";
	//config.filebrowserUploadUrl		= "/upload/ckfinder/userfiles/images";
    config.removePlugins					= "elementspath"; 

	config.filebrowserUploadUrl			= "/base/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
	config.filebrowserImageUploadUrl		= "/base/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
	config.filebrowserFlashUploadUrl		= "/base/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";
    
    config.toolbar =
    [['Source','Styles','Format','Font','FontSize'],
	['Bold','Italic','Underline','TextColor','BGColor'],
    '/',
    ['Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Link','Unlink','Anchor'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], 
    ['NumberedList','BulletedList','Outdent','Indent','Blockquote']];
};