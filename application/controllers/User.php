<?php

class UserController extends Yaf_Controller_Abstract {

    public function indexAction(){
        return $this->loginAction();
    }

	public function registerAction($name = "user") {

		$uname = $this->getRequest()->getPost("username",false);
        $pwd=$this->getRequest()->getPost('password',false);
        if (!$uname||!$pwd){
            echo json_encode(array('code'=>-1002,'msg'=>'用户名与密码必须传递'));
            return false;
        }

		$model = new UserModel();
        if($model->register(trim($uname),trim($pwd))){
            echo json_encode(array(
                'code'=>0,
                'msg'=>"",
                'data'=>array('name'=>$uname)
            ));
        }


		$this->getView()->assign("content", $model->selectSample());
		$this->getView()->assign("name", $name);
        return false;
		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
	}
}
