<?php
namespace Api\Controller;
use Think\Controller;

class MusicController extends Controller 
{
    public function index()
    {
    	$offset =  I('post.offset'); // 相当于 $_POST['id']
    	$limit = I('post.limit'); // 相当于 $_POST['id']
    	//步骤1：从数据库获取数据
    	$musicData = M('music')->order('id desc')->limit($offset, $limit)->select();
    	//步骤2：数据过滤
    	foreach ($musicData as $key => $value) {
    		$musicData[$key]['logo'] = 'http://192.168.72.36/tp32_app_guangchangwu/Public/Uploads/' . $musicData[$key]['logo'];
    	}
    	//步骤3：响应json数据
    	echo json_encode($musicData);
    }
}
