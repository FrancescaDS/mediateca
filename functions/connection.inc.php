<?php

$link = false;
$data_base = false;

/*
class connessione{
    public static $db_host = 'localhost';
    public static $db_user = 'root';
    public static $db_pw = '';
    public static $db_name = 'mediateca';

    public function __construct(){
        $this = new mysqli($db_host, $db_user, $db_pw, $db_name);
        if ($this->connect_errno) {
            printf("Connect failed: %s\n", $this->connect_error);
            exit();
        }
    }
}*/

function getDataBase(){
    global $data_base;
    
    if ($data_base ==false)
    {
        $hostname = "localhost";
        $dbname = "media";
        $user = "root";
        $pass = "";
        
        try {
        $data_base = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        //$db = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        
        
        } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
        }
    } 
    return $data_base;
}


function GetMyConnection(){
    global $link;
    
    if ($link ==false)
    {
        define('MYSQL_HOSTNAME','localhost');
        define('MYSQL_USER','root');
        define('MYSQL_PASSWORD','');
        define('MYSQL_DATABASE','mediateca');
        
        $link = mysqli_connect(MYSQL_HOSTNAME, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        //echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
        //echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
    }
    return $link;
}

function CleanUpDB()
{
    global $link;
    if ($link !=false){
        mysqli_close($link);
        $link = false;
    }
    
    
    global $data_base;
    if ($link !=false){
        $data_base = null;
        $data_base = false;
     }
}