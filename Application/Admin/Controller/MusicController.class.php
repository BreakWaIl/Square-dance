<?php
namespace Admin\Controller;
use Think\Controller;

class MusicController extends Controller 
{

   // 列表页的控制器
   public function index() 
   {
        // 取出数据库中的音乐数据
        $data = M('Music')->select();
        // 将数据分配到前台
        $this->assign('data',$data);
        $this->display();
   } 

    // 添加音乐的方法
    public function add()
    {
        // 验证时候有提交的动作
        if(IS_POST){
            //实例化music模型
            $model= M("Music");
            // 接受提交的数据
            if($data = $model->create()) {
                // 调用图片上传的方法
                $data['logo'] = $this->upload();
                //  将数据插入数据库中
                if($model->add($data)) {
                    $this->success('歌曲添加成功!');
                    exit;
                }
            }
        }
        $this->display();
    }
   
    // 声明图片上传得方法
    public function upload()
    {   
        $upload = new \Think\Upload();// 实例化上传类   
        $upload->maxSize   =     3145728 ;// 设置附件上传大小  
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型   
        $upload->rootPath  =      './Public/Uploads/'; // 设置附件上传的跟目录    // 上传文件   
        $upload->savePath='music/';   // 设置上传的二级目录
        $info   =   $upload->upload();    
        if(!$info) {// 上传错误提示错误信息       
            return false;
        }else{// 上传成功,返回图片的路径     
            $path = $info['smallimg']['savepath'].$info['smallimg']['savename'];
            return $path;
        }
     }
     
     // 封装一个借口供app进行调用
     function appApi()
     {
         // 接受传递过来的参数
         $limit = I('get.limit');
         $skip = I('get.skip');
         //添加数据的获取条件
         $data = M('Music')->order('id asc')->limit($skip,$limit)->select();
         //拼接图片路径
         foreach($data as $k=>$v){
               //注意这里进行拼接的时候要使用http,否则无法找到该图片
             $data[$k]['smallimg']='http://l.com/tp32_app_guangchangwu/public/uploads/'.$v['smallimg'];
             
         }
         //将数据的格式转化为json
         $json = json_encode($data);
         echo $json;exit;
     }
}