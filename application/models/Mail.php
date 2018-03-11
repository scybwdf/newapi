<?php
/**
 * @desc 邮件操作Model
 */
require APPLICATION_PATH.'/vendor/autoload.php';
use Nette\Mail\Message;

class MailModel{
    public $code=0;
    public $msg="";
    private $_db=null;

    public function __construct()
    {
    $this->_db=new PDO('mysql:host=localhost;dbname=newapi','root','dakehui9118');
    }

    public function send($uid,$title,$contents){
        $query = $this->_db->prepare("select `email` from `wf_user` where `id`= ? ");
        $query->execute( array(intval($uid)) );
        $ret = $query->fetchAll();

        if ( !$ret || count($ret)!=1 ) {
            $this->code = -3003;
            $this->msg = "用户邮箱信息查找失败";
            return false;
        }
        $userEmail = $ret[0]['email'];
        if( !filter_var($userEmail, FILTER_VALIDATE_EMAIL) ) {
            $this->code = -3004;
            $this->msg = "用户邮箱信息不符合标准，邮箱地址为：".$userEmail;
            return false;
        }

        $mail = new Message;
        $mail->setFrom('悦无限 <18698524659@163.com>')
            ->addTo( $userEmail )
            ->setSubject( $title )
            ->setBody( $contents );

        $mailer = new Nette\Mail\SmtpMailer([
            'host' => 'smtp.163.com',
            'username' => '18698524659@163.com',
            'password' => 'wdf13736895570', /* smtp独立密码 */
            'secure' => 'ssl',
        ]);
        $rep = $mailer->send($mail);
        return true;
    }
}