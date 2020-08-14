<?php
require_once(__DIR__ . '/../module/connect.module.php');



class CLASS_contacts
{
    function __construct()
    {
    }






    /**
     * 上传电话号码
     * @param array $array 数据格式
     * @return boolean true || false
     */
    public function uploadPhone($array)
    {
        $str = '';
        $i = 0;
        $len  = count($array);
        foreach ($array as $key => $value) {
            $i++;
            $phone = $array[$key]['phone'];
            $str .= "('$phone', 0, now()" . ($i < $len ? '),' . PHP_EOL : ')');
        }

        $sql = "INSERT INTO 
        `gd_contacts`.`gc_phone` 
        (`phone`, `state`, `update_time`) VALUES $str ";

        $result = run($sql);
        return $result;
    }




    /**
     * 获取电话号码
     * @param integer $number 获取的数量
     * @return array 
     */
    public function getPhone($number)
    {
        $sql = "SELECT *  FROM `gd_contacts`.`gc_phone` WHERE `state` = 0 LIMIT $number";
        $result = run($sql);

        $array = array();
        while ($assoc = mysqli_fetch_assoc($result)) {
            $id = $assoc['id'];
            $bool = $this->deletePhone($id);
            if ($bool) {
                $phone = $assoc['phone'];
                $array[] = $phone;
            }
        }
        return $array;
    }






    /**
     * 删除电话号码
     * @param integer $id 数据库索引Id
     */
    public function deletePhone($id)
    {
        $sql = "DELETE FROM `gd_contacts`.`gc_phone` WHERE `id` = $id";
        $result = run($sql);
        return $result;
    }
}
