<?php

// 定义系统常量
define('DS',DIRECTORY_SEPARATOR);   //路径分割符
define('AROOT',dirname(__FILE__));  //web根路径

// 载入核心初始化脚本
require_once AROOT.DS.'loader.php';

//运行网站
\GiWebFrame\Core\App::run();


/**
$mysql= new \GiWebFrame\Lib\MysqlPdo();


$sql="CREATE TABLE `gi_user` (
  `userid` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


$sql='select * from gi_user';

var_dump($mysql->query($sql));
var_dump($mysql->fetchColumn());

$stmt="insert";
//print_r($mysql->exec($stmt));
 *
 * */