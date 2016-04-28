<?php

namespace GiWebFrame\Lib;

class MysqlPdo{
    private $db_debug=true;
    private $db_type='mysql';
    private $db_host='localhost';
    private $db_port=3306;
    private $db_charset='utf8';
    private $db_name='test';
    private $db_user='root';
    private $db_password='';


    private $pdo=null;
    private $result=null;

    function __construct()
    {

        $db=c('database');
        $this->db_host=$db['db_type']!=''?$db['db_type']:$this->db_type;
        $this->db_host=$db['db_host']!=''?$db['db_host']:$this->db_host;
        $this->db_port=$db['db_port']!=''?$db['db_port']:$this->db_port;
        $this->db_charset=$db['db_charset']!=''?$db['db_charset']:$this->db_charset;
        $this->db_name=$db['db_name']!=''?$db['db_name']:$this->db_name;
        $this->db_user=$db['db_user']!=''?$db['db_user']:$this->db_user;
        $this->db_password=$db['db_password']!=''?$db['db_password']:$this->db_password;
        $this->db_debug=$db['db_debug'];

        $host=$this->db_host;
        $db_name=$this->db_name;
        $db_charset=$this->db_charset;

        try{
            $this->pdo=new \PDO("mysql:host=$host;dbname=$db_name",$this->db_user,$this->db_password);
            $this->query("set name $db_charset");
            $this->setAttribute('PDO::ATTR_ERRMODE','PDO::ERRMODE_EXCEPTION');
//            $this->pdo->beginTransaction();
//            $this->pdo->commit();
//            $this->pdo->errorCode();
//            $this->pdo->errorInfo();
//            $this->pdo->exec();
//            $this->pdo->getAttribute();
//            $this->pdo->getAvailableDrivers();
//            $this->pdo->inTransaction();
//            $this->pdo->lastInsertId();
//            $this->pdo->prepare();
//            $this->pdo->query();
//            $this->pdo->quote();
//            $this->pdo->rollBack();

        }catch (\Exception $e){
            if($this->db_debug==true) {
                echo 'Database connect error:' . $e->getMessage();
            }
            exit;
        }

    }

    public function setAttribute($attr,$value){
        if ($this->pdo != null){
            try{
                return $this->pdo->setAttribute(constant($attr),constant($value));
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    public function getAttribute($attr){
        if ($this->pdo != null){
            try{
                return $this->pdo->getAttribute("PDO::$attr");
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    public function exec($statement)
    {
        if ($this->pdo != null){

            try{
                $this->result=$this->pdo->exec($statement);
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    /**
     * @note 数据查询操作
     * @param $sql
     * @return \PDOStatement
     */
    public function query($sql)
    {

        if ($this->pdo != null){
            try{
                $this->result=$this->pdo->query($sql);
                if($this->result){
                    return true;
                }
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    public function fetch(){
        if($this->result){
        return $this->result->fetch();
        }
    }
    public function fetchAll(){
        if($this->result) {
            return $this->result->fetchAll();
        }
    }
    public function fetchColumn(){
        if($this->result) {
            return $this->result->fetchColumn();
        }
    }

    /**
     * @note 最后一次插入的数据id
     * @return string
     */
    public function lastInsertId(){
        if ($this->pdo != null){
            try{
                return $this->pdo->lastInsertId();
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    public function prepare($statment,$driver_options=array()){
        if ($this->pdo != null){
            try{
                return $this->pdo->prepare($statment,$driver_options);
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }

    }

    /**
     * @note 防止sql注入
     * @param $str
     * @param int $parameter_type
     * @return string
     */
    public function quote($str, $parameter_type=\PDO::PARAM_STR){
        if ($this->pdo != null){
            try{
                return $this->pdo->quote($str, $parameter_type);
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    /**
     * @note 提交数据
     * @return bool
     */
    public function commit(){
        if ($this->pdo != null){
            try{
                return $this->pdo->commit();
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    /**
     * @note 数据回滚 当用户数据提交失败后，回滚操作
     * @return bool
     */
    public function rollBack(){
        if ($this->pdo != null){
            try{
                return $this->pdo->rollBack();
            }catch (\PDOException $e){
                if($this->db_debug==true) echo $e->getMessage();
            }
        }
    }

    public function select($table,$queryFieldArray=array(),$after=''){
        $queryFieldArray=$queryFieldArray==''?array('*'):$queryFieldArray;

        $queryField='';
        if(is_array($queryFieldArray)){
            foreach ($queryFieldArray as $key =>$value) {
                $queryField=$queryField.$value.',';
            }

            $queryField=rtrim($queryField,',');
        }
        $sql='select *';

    }

    public function close(){
        $this->pdo=null;
    }

    function __destruct(){
        self::close();
    }


}