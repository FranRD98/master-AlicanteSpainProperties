<?php
/*
 * ADOBE SYSTEMS INCORPORATED
 * Copyright 2007 Adobe Systems Incorporated
 * All Rights Reserved
 * 
 * NOTICE:  Adobe permits you to use, modify, and distribute this file in accordance with the 
 * terms of the Adobe license agreement accompanying it. If you have received this file from a 
 * source other than Adobe, then your use, modification, or distribution of it requires the prior 
 * written permission of Adobe.
 */

/*
    Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

$KT_tNG_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong>';
$KT_tNG_uploadFileList1 = array(
    'tNG_config.inc.php',
    '../common/KT_common.php',
    'tNG_functions.inc.php',
    'triggers/tNG_TidyContent.inc.php',
    'triggers/tNG_defTrigg.inc.php',
    '../common/lib/resources/KT_Resources.php',
    '../common/lib/shell/KT_Shell.php',
    '../common/lib/folder/KT_Folder.php',
    '../common/lib/file_upload/KT_FileUpload.php',
    '../common/lib/image/KT_Image.php',
    '../common/lib/email/KT_Email.php',
    '../common/lib/db/KT_Db.php',
    '../common/lib/file/KT_File.php',
    '../common/lib/captcha/KT_Captcha.php',
    '../common/KT_functions.inc.php',
);

$KT_tNG_uploadFileList2 = array(
    'tNG_log.class.php',
    'tNG_dispatcher.class.php',
    'tNG.class.php',
    'tNG_fields.class.php',
    'tNG_insert.class.php',
    'tNG_update.class.php',
    'tNG_delete.class.php',
    'tNG_multiple.class.php',
    'tNG_multipleInsert.class.php',
    'tNG_multipleUpdate.class.php',
    'tNG_multipleDelete.class.php',
    'tNG_custom.class.php',
    'tNG_login.class.php',
    'tNG_logoutTransaction.class.php',
    'tNG_import.class.php',
    'tNG_error.class.php',
    'triggers/tNG_SetOrderField.class.php',
    'triggers/tNG_Redirect.class.php',
    'triggers/tNG_FormValidation.class.php',
    'triggers/tNG_FieldCompare.class.php',
    'triggers/tNG_FileUpload.class.php',
    'triggers/tNG_ImageUpload.class.php',
    'triggers/tNG_FileDelete.class.php',
    'triggers/tNG_LinkedTrans.class.php',
    'triggers/tNG_CheckTableField.class.php',
    'triggers/tNG_CheckUnique.class.php',
    'triggers/tNG_ChkForbiddenWords.class.php',
    'triggers/tNG_CheckDetailRecord.class.php',
    'triggers/tNG_CheckMasterRecord.class.php',
    'triggers/tNG_DeleteDetailRec.class.php',
    'triggers/tNG_DeleteFolder.class.php',
    'triggers/tNG_ThrowError.class.php',
    'triggers/tNG_Email.class.php',
    'triggers/tNG_EmailRecordset.class.php',
    'triggers/tNG_EmailPageSection.class.php',
    'triggers/tNG_RestrictAccess.class.php',
    'triggers/tNG_Captcha.class.php',
    'triggers/tNG_UserLoggedIn.class.php',
    'triggers/tNG_ManyToMany.class.php',
    'triggers/tNG_MtmFakeRs.class.php',
    'triggers/tNG_Logout.class.php',
    'triggers/tNG_DynamicThumbnail.class.php',
    'triggers/tNG_DynamicMedia.class.php',
    'triggers/tNG_Download.class.php',
    'triggers/tNG_MFileUpload.class.php',
    'triggers/tNG_MImageUpload.class.php',
    'triggers/tNG_MuploadHelper.class.php',
    'triggers/tNG_FileListRecordset.class.php',
    'triggers/tNG_TidyContent.class.php',
);

foreach ($KT_tNG_uploadFileList1 as $file) {
    $KT_tNG_uploadFileName = dirname(__FILE__) . '/' . $file;
    if (file_exists($KT_tNG_uploadFileName)) {
        require_once($KT_tNG_uploadFileName);
    } else {
        die(sprintf($KT_tNG_uploadErrorMsg, $file));
    }
}

foreach ($KT_tNG_uploadFileList2 as $file) {
    $KT_tNG_uploadFileName = dirname(__FILE__) . '/' . $file;
    if (file_exists($KT_tNG_uploadFileName)) {
        require_once($KT_tNG_uploadFileName);
    } else {
        die(sprintf($KT_tNG_uploadErrorMsg, $file));
    }
}

// Función de carga automática usando spl_autoload_register()
spl_autoload_register(function ($class_name) {
    $class_map = array(
        'tNG_log' => 'tNG_log.class.php',
        'tNG_dispatcher' => 'tNG_dispatcher.class.php',
        'tNG' => 'tNG.class.php',
        'tNG_fields' => 'tNG_fields.class.php',
        'tNG_insert' => 'tNG_insert.class.php',
        'tNG_update' => 'tNG_update.class.php',
        'tNG_delete' => 'tNG_delete.class.php',
        'tNG_multiple' => 'tNG_multiple.class.php',
        'tNG_multipleInsert' => 'tNG_multipleInsert.class.php',
        'tNG_multipleUpdate' => 'tNG_multipleUpdate.class.php',
        'tNG_multipleDelete' => 'tNG_multipleDelete.class.php',
        'tNG_custom' => 'tNG_custom.class.php',
        'tNG_login' => 'tNG_login.class.php',
        'tNG_logoutTransaction' => 'tNG_logoutTransaction.class.php',
        'tNG_import' => 'tNG_import.class.php',
        'tNG_error' => 'tNG_error.class.php',
        'tNG_SetOrderField' => 'triggers/tNG_SetOrderField.class.php',
        'tNG_Redirect' => 'triggers/tNG_Redirect.class.php',
        'tNG_FormValidation' => 'triggers/tNG_FormValidation.class.php',
        'tNG_FieldCompare' => 'triggers/tNG_FieldCompare.class.php',
        'tNG_FileUpload' => 'triggers/tNG_FileUpload.class.php',
        'tNG_ImageUpload' => 'triggers/tNG_ImageUpload.class.php',
        'tNG_FileDelete' => 'triggers/tNG_FileDelete.class.php',
        'tNG_LinkedTrans' => 'triggers/tNG_LinkedTrans.class.php',
        'tNG_CheckTableField' => 'triggers/tNG_CheckTableField.class.php',
        'tNG_CheckUnique' => 'triggers/tNG_CheckUnique.class.php',
        'tNG_ChkForbiddenWords' => 'triggers/tNG_ChkForbiddenWords.class.php',
        'tNG_CheckDetailRecord' => 'triggers/tNG_CheckDetailRecord.class.php',
        'tNG_CheckMasterRecord' => 'triggers/tNG_CheckMasterRecord.class.php',
        'tNG_DeleteDetailRec' => 'triggers/tNG_DeleteDetailRec.class.php',
        'tNG_DeleteFolder' => 'triggers/tNG_DeleteFolder.class.php',
        'tNG_ThrowError' => 'triggers/tNG_ThrowError.class.php',
        'tNG_Email' => 'triggers/tNG_Email.class.php',
        'tNG_EmailRecordset' => 'triggers/tNG_EmailRecordset.class.php',
        'tNG_EmailPageSection' => 'triggers/tNG_EmailPageSection.class.php',
        'tNG_RestrictAccess' => 'triggers/tNG_RestrictAccess.class.php',
        'tNG_Captcha' => 'triggers/tNG_Captcha.class.php',
        'tNG_UserLoggedIn' => 'triggers/tNG_UserLoggedIn.class.php',
        'tNG_ManyToMany' => 'triggers/tNG_ManyToMany.class.php',
        'tNG_MtmFakeRs' => 'triggers/tNG_MtmFakeRs.class.php',
        'tNG_DynamicThumbnail' => 'triggers/tNG_DynamicThumbnail.class.php',
        'tNG_DynamicMedia' => 'triggers/tNG_DynamicMedia.class.php',
        'tNG_Download' => 'triggers/tNG_Download.class.php',
        'tNG_MFileUpload' => 'triggers/tNG_MFileUpload.class.php',
        'tNG_MImageUpload' => 'triggers/tNG_MImageUpload.class.php',
        'tNG_FileListRecordset' => 'triggers/tNG_FileListRecordset.class.php',
        'tNG_MuploadHelper' => 'triggers/tNG_MuploadHelper.class.php',
        'tNG_TidyContent' => 'triggers/tNG_TidyContent.class.php',
    );

    if (isset($class_map[$class_name])) {
        require_once(dirname(__FILE__) . '/' . $class_map[$class_name]);
    }
});

if (isset($GLOBALS['KT_prefered_image_lib'])) {
    $GLOBALS['tNG_prefered_image_lib'] = $GLOBALS['KT_prefered_image_lib'];
}
$GLOBALS['tNG_prefered_imagemagick_path'] = '/media/images/';
if (isset($GLOBALS['KT_prefered_imagemagick_path'])) {
    if(isset($GLOBALS['KT_prefered_imagemag']))
        $GLOBALS['tNG_prefered_imagemagick_path'] = $GLOBALS['KT_prefered_imagemag'];
}

//$GLOBALS['tNG_debug_mode'] = 'DEVELOPMENT';