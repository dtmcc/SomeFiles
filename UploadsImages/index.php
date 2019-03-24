<?php
/**
 * Created by PhpStorm.
 * User: smallpig
 * email: 1062436470@qq.com
 * Date: 2019-03-24
 * Time: 18:37
 */


/**
 * 部署到服务器下 作为接口 解决跨域的问题
 */
header('Access-Control-Allow-Origin:*');

/**
 * Class index
 * 简单的上传文件的类库
 */
class index
{
    /**
     * @return mixed
     * 文件上传
     */
    public function uploadsfile()
    {

        $file_name = time() . time() . strstr($_FILES['file']['name'], '.');
        $url = 'file/';
        //判断文件夹是否存在，不存在则创建
        is_dir($url) OR mkdir($url, 0777, true);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $url . $file_name)) {
            $arr = [
                'code' => 1,
                'msg' => '上传成功',
                'pic' => $url . $file_name
            ];
        } else {
            $arr = [
                'code' => 0,
                'msg' => '上传失败',
                'pic' => ''
            ];
        }
        return json($arr);
    }

    /**
     * @return mixed
     * 图片上传
     */
    public function uploads()
    {
        //图片支持上传格式
        $file_type = ['jpg', 'jpeg', 'png'];
        //循环判断图片是否为支持上传格式
        $status = false;
        foreach ($file_type as $key) {
            //去除多余空行、重复定义路由
            if (!strpos($key, $_FILES['file']['type']) && $key != '') {
                //如果支持结束循环
                $status = true;
                break;
            }
        }
        if ($status) {
            $file_name = time() . strstr($_FILES['file']['name'], '.');
            $url = 'upload/';
            //判断文件夹是否存在，不存在则创建
            is_dir($url) OR mkdir($url, 0777, true);
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $url . $file_name)) {
                //上传成功 返回图片路径
                $arr = [
                    'code' => 1,
                    'msg' => '上传成功',
                    'pic' => $url . $file_name,
                    'src' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace("index.php", "", $_SERVER['URL']) . $url . $file_name
                ];
            } else {
                //上传失败
                $arr = ['code' => 0, 'msg' => '上传失败', 'src' => ''];
            }
        } else {
            //文件格式不支持
            $arr = ['code' => 0, 'msg' => '文件格式不支持', 'src' => ''];
        }
        return json($arr);
    }
}