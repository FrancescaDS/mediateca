<?php

require_once("functions/connection.inc.php");
require_once("functions/functions.php");

if (!empty($_POST['id'])){
    $cheID = $_POST['id'];
}elseif(!empty($_GET['id'])){
    $cheID = $_GET['id'];
}else{
    $cheID = 0;
}

if(!empty($_GET['del'])){
    if ($_GET['del'] == 1){
        //cancello il Director
        $cheQuery = "DELETE FROM Directors WHERE IDDirector=". $cheID;
        mysqli_query(GetMyConnection(), $cheQuery);
        header("location: admin_director_list.php");
    }    
}elseif(!empty($_POST['update'])){
    //prendo i dati con POST
    $Name = $_POST['Name'];
    $Surname = $_POST['Surname'];
    if ($cheID==0){
        //nuovo Director
        $cheQuery = "INSERT INTO Directors (Name, Surname) ";
        $cheQuery = $cheQuery . "VALUES ('".$Name."','".$Surname."')";
        mysqli_query(GetMyConnection(), $cheQuery);
        $cheID=mysqli_insert_id(GetMyConnection());
    }else{
        //update del Director
        $cheQuery = "UPDATE Directors SET Name='". $Name . "', Surname='".$Surname."'";
        $cheQuery = $cheQuery . " WHERE IDDirector=". $cheID;
        mysqli_query(GetMyConnection(), $cheQuery);
    }
    header("location: admin_director_scheda.php?id=".$cheID."&ins=1");
}
