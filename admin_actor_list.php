<!DOCTYPE html>

<HTML>
    <HEAD>

<script type="text/javascript">
function cancella(id)
{
  var sei_sicuro = confirm('Are you sure you want to delete it?');
  if (sei_sicuro)
  {
    location.href = 'admin_actor.php?id=' + id + "&del=1";
  }else{
    alert('No cancellation');
  }
}
</script>
        
        
        
<TITLE>ACTOR/ACTRESS LIST - ADMIN - MEDIATECA</TITLE>

<LINK rel="stylesheet" href='style.css'> </HEAD>
<BODY>

    <?php include "includes/header.php"; ?>
   
    <H1>ADMIN - ACTOR/ACTRESS LIST</H1>


<?php
require_once("functions/connection.inc.php");
require_once("functions/functions.php");

if (empty(getUser())){
    header("location: admin.php");
    exit;
}else{
    echo "<p class='giusto'>".strtoupper($User['Username'])."</p>";
}

$cheQuery ="SELECT IDActor, Name, Surname FROM Actors ORDER BY Surname, Name";
if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
    
    echo "<H3>Our DB conteins " . mysqli_num_rows($result) . " actors/actresses.</H3>";
    
    echo "<table><tr><td><b>Actor/Actress</b></td><td>&nbsp;</td></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><A href='admin_actor_scheda.php?id=" . $row['IDActor'] . "'>" . $row['Surname'] ." ". $row['Name'] . "</a></td>";
        echo "<td><A href='#' onclick='cancella(".$row['IDActor'] .");'>delete</a></td>";
        echo "<tr>";
    }
    
    mysqli_free_result($result);
    echo "<tr><td colspan='3'>&nbsp;</td></tr>";
    echo "<tr><td colspan='3'><a href='admin_actor_scheda.php'>New actor/actress</a></td></tr>";
    
    echo "</table>";
    
}

CleanUpDB();

?>


<?php include "includes/footer.php"; ?>
  </BODY>
</HTML>
