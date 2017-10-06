<?php
    require_once 'functions/functions.php';
    require 'includes/database.php';

    $che_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $film = new Film($db, $che_id);
    $Director = $film->Director;
    $che_Poster = $film->Poster;
    

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>FILM SCHEDA - MEDIATECA</title>
        <link href="style.css" rel="stylesheet" />
    </head>
<BODY>

    <?php include "includes/header.php"; ?>
   
    <H1>FILM</H1>


<?php
    $IDPoster = $film->getData()['IDPoster'];
    if (is_null($IDPoster)){
      $IDPoster = 0;
    }else{
        $Poster = $che_Poster->Poster;
        $Type = $che_Poster->Type;
    }

    echo "<p class='film'>" . $film->getData()['Title'] . "</p>";
    echo "<table border='1'>";
    echo "<tr><td><b>Year:</b></td><td>" . $film->getData()['Year'] . "</td></tr>";
    echo "<tr><td><b>Director:</b></td><td><A href='director_scheda.php?id=" . $Director->getData()['IDDirector'] . "'>" . $Director->getData()['Name'] ." ". $Director->getData()['Surname'] . "</a></td></tr>";
    echo "<tr><td><b>Country:</b></td><td>" . $film->getData()['Country'] . "</td></tr>";
    
    
    $lista = $film->lista_Actors;
    if (!empty($lista)){
        echo "<tr><td><b>Cast:</b></td><td>";
        while ($row = $lista->fetch()) {
          echo "<a href='actor_scheda.php?id=" . $row['IDActor'] . "'>" . $row['Name'] ." ".$row['Surname'].")</A><br>";
      } 
      echo "</td></tr>";
    }
    
    if ($IDPoster !=0){
        echo "<tr><td colspan='2'>";
        echo '<img src="data:'.$Type.';base64,'.base64_encode( $Poster ).'"/>';
        echo "</td></tr>";
    }
     
    echo "</table>";

?>
 
    <?php include "includes/liste.php"; ?>
   
    
    
<?php include "includes/footer.php"; ?>
  </BODY>
</HTML>
