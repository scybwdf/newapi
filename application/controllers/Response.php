<?php
class ResponseController extends Yaf_Controller_Abstract{
    const JSON="json";
    /**
     * 综合方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @param string $type 输出类型
     * return string
     */
    public static function show($code,$message='',$data=array(),$type=self::JSON){
        if(!is_numeric($code)){
            return '';
        }
        $type=isset($_REQUEST['formate']) ? $_REQUEST['formate'] :self::JSON;
        $res=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        if($type=='json'){
            return self::json($code,$message,$data);
            exit;
        }
        elseif ($type=='array'){
            header("Content-type:text/html;charset=utf8");
            var_dump($res);
            exit;
        }
        elseif ($type=='xml'){
            return self::xml($code,$message,$data);
            exit;
        }
        else{
            return self::json($code,$message,$data);
            exit;
        }
    }
    /**
     * 按json格式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data //数据
     * return string
     */
    public static function json($code,$message='',$data=array())
    {
        if(!is_numeric($code)){
            return '';
        }
        $res=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        return json_encode($res);
        exit;
    }
    /**
     * 按xml格式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data //数据
     * return string
     */
    public static function xml($code,$message='',$data=array()){
        if(!is_numeric($code)){
            return '';
        }
        $arr=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        header('Content-type:text/xml');
        $xml="<?xml version='1.0' encoding='UTF-8' ?>\n";
        $xml.="<root>\n";
        $xml.=self::xmlToEncode($arr);
        $xml.="</root>\n";
        return $xml;
        exit;
    }
    /**xml数据组装
     * @param $data
     * @return string
     */
    public static function xmlToEncode($data){
        $xml=$attr='';
        foreach ($data as $k=>$v){
            if(is_numeric($k)){
                $attr=" id='{$k}'";
                $k="item";
            }
            $xml.="<{$k}{$attr}>";
            $xml.=is_array($v) ? self::xmlToEncode($v):$v;
            $xml.="</{$k}>";
        }
        return $xml;
        exit;
    }
}