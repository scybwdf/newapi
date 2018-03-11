<?php
class MailController extends Yaf_Controller_Abstract{

    public function indexAction(){

    }
    public function sendAction(){
        $submit=$this->getRequest()->getQuery('submit',0);
        if($submit!="1"){
            echo json_encode(array(
                'code'=>-3001,
                'msg'=>"请通过正确途径提交"
            ));
            return false;
        }
        //获取参数

        $uid =$this->getRequest()->getPost( "uid", false );
        $title=$this->getRequest()->getPost('title',false);
        $contents=$this->getRequest()->getPost('contents',false);

        if(!$uid||!$title||!$contents){
            echo json_encode(array(
                'code'=>-3002,
                'msg'=>"用户ID、标题、内容不能为空"
            ));
            return false;
        }
        //调用model,发送邮件
        $model=new MailModel();
        if($model->send(intval($uid),trim($title),trim($contents))){
            echo json_encode(array(
                'code'=>0,
                'msg'=>''
            ));
        }
        else{
            echo json_encode(array(
                'code'=>$model->code,
                'msg'=>$model->msg
            ));
        }
        return false;
    }
}