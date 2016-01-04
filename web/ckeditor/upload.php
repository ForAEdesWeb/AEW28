<?php

/*
  CKEditor_upload.php
  monkee
  2009-11-15 16:47
 */

$config = array();
$config['type'] = array("flash", "img"); //上傳允許type值
$config['img'] = array("jpg", "bmp", "gif", "png"); //img允許后綴
$config['flash'] = array("flv", "swf"); //flash允許后綴
$config['flash_size'] = 1048576; //上傳flash大小上限 單位：KB
$config['img_size'] = 1048576; //上傳img大小上限 單位：KB
$config['message'] = ""; //上傳成功后顯示的消息，若為空則不顯示
$config['name'] = mktime(); //上傳后的文件命名規則 這里以unix時間戳來命名
$config['flash_dir'] = __DIR__ . "/../upload/flash";
$config['img_dir'] = __DIR__ . "/../upload/img";

$config['web_url'] = "/"; //提供此php檔案者 有bug 補函數
//文件上傳
uploadfile();

function uploadfile() {
    global $config;
//判斷是否是非法調用
    if (empty($_GET['CKEditorFuncNum']))
        mkhtml(1, "", "錯誤的功能調用請求");
    $fn = $_GET['CKEditorFuncNum'];
    if (!in_array($_GET['type'], $config['type']))
        mkhtml(1, "", "錯誤的文件調用請求");
    $type = $_GET['type'];

    if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
        //判斷上傳文件是否允許
        $filearr = pathinfo($_FILES['upload']['name']);
        $filetype = $filearr["extension"];
        if (!in_array($filetype, $config[$type]))
            mkhtml($fn, "", "錯誤的文件類型！");
        //判斷文件大小是否符合要求
        if ($_FILES['upload']['size'] > $config[$type . "_size"] * 1024)
            mkhtml($fn, "", "上傳的文件不能超過" . $config[$type . "_size"] . "KB！");

        $file_host = $config[$type . "_dir"] . "/" . $config['name'] . "." . $filetype;

        if (move_uploaded_file($_FILES['upload']['tmp_name'], $file_host)) {
            mkhtml($fn, "http://json.jpasia.aedew.com/upload/" . $type . "/" . $config['name'] . "." . $filetype, $config['message']);
        } else {
            mkhtml($fn, "", "文件上傳失敗，請檢查上傳目錄設置和目錄讀寫權限" . $file_host);
        }
    }
}

//輸出js調用
function mkhtml($fn, $fileurl, $message) {
    $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $fn . ', \'' . $fileurl . '\', \'' . $message . '\');</script>';
    exit($str);
}
