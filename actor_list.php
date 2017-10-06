<?php
require_once 'functions/functions.php';
require 'includes/database.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ACTOR LIST - MEDIATECA</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>

    <?php include "includes/header.php"; ?>
   
    <H1>ACTOR/ACTRESS LIST</H1>


<?php
    try {
        $sql = 'SELECT * FROM Actors ORDER BY Surname, Name';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();
        $rows = $stmt->fetchAll();
        echo "<H3>Our DB conteins " . count($rows) . " actors/actresses.</H3>";
        echo "<table><tr><td><b>Actor/Actress</b></td><td>&nbsp;</td></tr>";

        foreach($rows as $row){
            echo "<tr>";
            echo "<td><A href='actor_scheda.php?id=" . $row['IDActor'] . "'>" . $row['Surname'] ." ". $row['Name'] . "</a></td>";
            echo "<tr>";
        }

        echo "</table>";

    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

?>

     <?php include "includes/liste.php"; ?>

    <?php include "includes/footer.php"; ?>
  
    </BODY>
</HTML>
