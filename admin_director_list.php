<!DOCTYPE html>

<HTML>
    <HEAD>
<script type="text/javascript">
function cancella(id)
{
  var sei_sicuro = confirm('Are you sure you want to delete it?');
  if (sei_sicuro)
  {
    location.href = 'admin_director.php?id=' + id + "&del=1";
  }else{
    alert('No cancellation');
  }
}
</script>
<TITLE>DIRECTOR LIST - ADMIN - MEDIATECA</TITLE>

<LINK rel="stylesheet" href='style.css'> </HEAD>
<BODY>

    <?php include "includes/header.php"; ?>
   
    <H1>DIRECTOR LIST</H1>


<?php
require_once("functions/connection.inc.php");
require_once("functions/functions.php");

if (empty(getUser())){
    header("location: admin.php");
    exit;
}else{
    echo "<p class='giusto'>".strtoupper($User['Username'])."</p>";
}

$cheQuery ="SELECT IDDirector, Name, Surname FROM Directors ORDER BY Surname";
if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
    
    echo "<H3>Our DB conteins " . mysqli_num_rows($result) . " directors.</H3>";
    
    echo "<table><tr><td><b>Directors</b></td><td>&nbsp;</td></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><A href='admin_director_scheda.php?id=" . $row['IDDirector'] . "'>" . $row['Surname'] ." ". $row['Name'] . "</a></td>";
        echo "<td><A href='#' onclick='cancella(".$row['IDDirector'] .");'>delete</a></td>";
        echo "<tr>";
    }
    
    mysqli_free_result($result);
    echo "<tr><td colspan='3'>&nbsp;</td></tr>";
    echo "<tr><td colspan='3'><a href='admin_director_scheda.php'>New director</a></td></tr>";
    
    echo "</table>";
    
}

CleanUpDB();

?>


<?php include "includes/footer.php"; ?>
  </BODY>
</HTML>