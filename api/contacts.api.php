<?php
require_once(__DIR__ . '/../class/contacts.class.php');



class API_contacts
{
    var $contacts;



    function __construct()
    {
        $this->contacts = new CLASS_contacts;
    }



    /**
     * 获取JSON数据转换成Array
     * @return array Array数据
     * @failure 41001 无效的JSON数据格式(空数据)
     * @failure 41002 无效的JSON数据格式(JSON数据没有格式体)
     */
    private function get_post_json()
    {
        $input = file_get_contents("php://input");
        if (empty($input)) { // 无效的数据
            dieJson(41001, '无效的JSON数据格式');
        }

        $array = json_decode($input, true);
        if (count($array) < 1) { // 空数组
            dieJson(41002, '无效的JSON数据格式');
        }

        return $array;
    }




    /**
     * 上传电话号码
     */
    public function uploadPhone()
    {
        $array = $this->get_post_json();
        $data = $array['data'];
        $len = count($data);
        if ($len < 1) { // 禁止上传空数据
            dieJson(41004, '禁止上传空数据');
        }
        $result = $this->contacts->uploadPhone($data);

        $statusCode = $result ? 200 : 0;
        $message = $result ? '上传成功' : '上传失败';
        dieJson($statusCode, $message);
    }



    /**
     * 获取电话号码
     * @param integer $number 获取的数量,默认=1
     */
    public function getPhone()
    {
        $number = $_GET['number'];
        $number = $number < 1 ? 1 : (int)$number;

        $result = $this->contacts->getPhone($number);

        $len  = count($result);

        if ($len < 1) { // 数据库中已经没有数据了
            dieJson(41004, '无可用号码');
        }

        dieJson(200, '获取号码成功', ['data' => $result]);
    }



    /**
     * 删除电话号码
     */
    public function deletePhone()
    {
        $id = $_REQUEST['id'];
        if (empty($id)) {
            dieJson(41005, '索引Id不能为空');
        }

        if ($id < 1) {
            dieJson(41006, '索引Id不能为0');
        }

        $result = $this->contacts->deletePhone($id);

        if ($result) dieJson(200, '删除成功');
        dieJson(0, '删除失败');
    }
}
