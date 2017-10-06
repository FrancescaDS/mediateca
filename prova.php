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

echo $cheID;
echo $_GET['del'];
if(!empty($_GET['del'])){
    if ($_GET['del'] == 1){
        //cancello l'Actor
        echo "cancella";
        //$cheQuery = "DELETE Actors WHERE IDActor=". $cheID;
        //mysqli_query(GetMyConnection(), $cheQuery);
        //header("location: admin_actor_list.php");
    } 
}
