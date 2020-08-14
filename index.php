<?php
require_once(__DIR__ . '/api/contacts.api.php');


$action = $_REQUEST['action'];


if (!isset($action)) { // 没有设置action标志
    dieJson(41003, "无效的标志");
}

$contacts = new API_contacts;

switch ($action) {

    case 'uploadPhone': // 上传电话号码
        $contacts->uploadPhone();
        break;

    case 'getPhone': // 获取电话号码
        $contacts->getPhone();
        break;

    case 'deletePhone': // 删除电话号码
        $contacts->deletePhone();
        break;

    default:
        # code...
        break;
}
