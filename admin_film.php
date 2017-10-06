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
        //cancello il film
        $cheQuery = "DELETE FROM Film WHERE IDFilm=". $cheID;
        mysqli_query(GetMyConnection(), $cheQuery);
        header("location: admin_film_list.php");
    }    
}elseif(!empty($_POST['update'])){
    //prendo i dati con POST
    $Title = $_POST['Title'];
    $IDDirector = $_POST['IDDirector'];
    $IDCountry = $_POST['IDCountry'];
    $Year = $_POST['Year'];
    if ($cheID==0){
        //nuovo film
        $cheQuery = "INSERT INTO Film (Title, IDDirector, IDCountry, Year) ";
        $cheQuery = $cheQuery . "VALUES ('".$Title."',".$IDDirector.",".$IDCountry.",".$Year.")";
        mysqli_query(GetMyConnection(), $cheQuery);
        $cheID=mysqli_insert_id(GetMyConnection());
    }else{
        //update del film
        $cheQuery = "UPDATE Film SET Title='". $Title . "', IDDirector=".$IDDirector.", IDCountry=".$IDCountry.",Year=".$Year;
        $cheQuery = $cheQuery . " WHERE IDFilm=". $cheID;
        mysqli_query(GetMyConnection(), $cheQuery);
    }
    header("location: admin_film_scheda.php?id=".$cheID."&ins=1");
}elseif (isset($_FILES['file'])){
    $img = upload($cheID);
    header("location: admin_film_scheda.php?id=".$cheID."&img=$img");
}elseif(!empty($_GET['delPoster'])){
    //cancello la Poster
    $cheQuery = "DELETE FROM Posters WHERE IDFilm=". $cheID;
    mysqli_query(GetMyConnection(), $cheQuery);
    header("location: admin_film_scheda.php?id=".$cheID);
}
