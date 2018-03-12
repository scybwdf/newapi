<?php
/**
 * Author :FELIX.
 * Date: 2018/3/12
 * Time: 15:15
 */
class BaseModel extends MysqlModel
{
    public $_db;

    public function __construct()
    {
        $config = include_once APPLICATION_PATH . "/conf/config.php";

        $this->_db = self::getInstance($config['DBHOST'], $config['DBUSER'], $config['DBPWD'], $config['DBNAME'], $config['DBCHARSET']);
    }
}