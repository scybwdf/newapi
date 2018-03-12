<?php

class SmsController extends ResponseController{
    public function indexAction(){

        echo self::show(200,'122');die;
    }
    public function sendAction(){
      /*  $submit = $this->getRequest()->getQuery( "submit", "0" );
        var_dump($submit);die;
        if( $submit!="1" ) {
            echo self::show( ThirdParty_Error::AUDIO_NOT_FOUND,"请通过正确渠道提交");
            return FALSE;
        }*/

        // 获取参数
        $uid = $this->getRequest()->getPost( "uid", false );
        $contents = $this->getRequest()->getPost( "contents", false );

        if( !$uid || !$contents ) {
            echo self::show(ThirdParty_Error::CATE_ID_CONNOT_EMPTY,"用户ID、邮件标题、邮件内容均不能为空。");

            return FALSE;
        }

        // 调用Model, 发邮件
        $model = new SmsModel();
        if ( $model->send( intval($uid), trim($contents) ) ) {
            echo json_encode( array(
                "errno"=>0,
                "errmsg"=>"",
            ));
        } else {
            echo json_encode( array(
                "errno"=>$model->errno,
                "errmsg"=>$model->errmsg,
            ));
        }
        return false;
    }
}