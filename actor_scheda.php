<?php
    require_once 'functions/functions.php';
    require 'includes/database.php';

    $che_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $persona = new Persona($db,'Actor', $che_id);
    

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ACTOR SCHEDA - MEDIATECA</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>

    <?php include "includes/header.php"; ?>
   
    <H1>ACTOR/ACTRESS</H1>
        <TABLE>
            <TR><TD class='newp'>Name</TD>
                <TD><?php echo $persona->getData()['Name']; ?></TD></TR> 
            <TR><TD class='newp'>Surname</TD>
                <TD><?php echo $persona->getData()['Surname']; ?></TD</TR> 
            <TR><TD class='newp'>Films</TD>
                <TD>
                <?php 
                    $lista = $persona->lista_film;
                    if (!empty($lista)){
                        while ($row = $lista->fetch()) {
                          echo "<a href='film_scheda.php?id=" . $row['IDFilm'] . "'>" . $row['Title'] ." (".$row['Year'].")</A><br>";
                      }  
                    }
                ?>    
               </TD></TR>
            
        </TABLE>


 <?php include "includes/liste.php"; ?>
<?php include "includes/footer.php"; ?>
  </BODY>
</HTML>


