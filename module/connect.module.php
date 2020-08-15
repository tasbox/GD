<?php

error_reporting(0);

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "wwxamn";



$connect = mysqli_connect($dbhost, $dbuser, $dbpassword);
if (!$connect) { // 连接Mysqli失败
    die(mysqli_error($connect));
}





/**
 * 执行sql代码
 * @param mixed $sql 代码
 * @return mixed
 */
function run($sql)
{
    global $connect;
    return ($connect->query($sql));
}




/**
 * 结束并返回json格式代码
 */
function dieJson($statuscode = 0, $message = "unknown", $data = [])
{
    $array = [
        "statusCode" => $statuscode,
        "message" => $message,
    ];

    die(json_encode($array + $data, JSON_UNESCAPED_UNICODE));
}
