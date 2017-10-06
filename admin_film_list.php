<!DOCTYPE html>

<HTML>
    <HEAD>
<script type="text/javascript">
function cancella(id)
{
  var sei_sicuro = confirm('Are you sure you want to delete it?');
  if (sei_sicuro)
  {
    location.href = 'admin_film.php?id=' + id + "&del=1";
  }else{
    alert('No cancellation');
  }
}
</script>
<TITLE>FILM LIST - ADMIN - MEDIATECA</TITLE>

<LINK rel="stylesheet" href='style.css'> </HEAD>
<BODY>

    <?php include "includes/header.php"; ?>
   
    <H1>ADMIN - FILM LIST</H1>


<?php
require_once("functions/connection.inc.php");
require_once("functions/functions.php");

if (empty(getUser())){
    header("location: admin.php");
    exit;
}else{
    echo "<p class='giusto'>".strtoupper($User['Username'])."</p>";
}

$cheQuery ="SELECT Film.IDFilm, Title, Directors.IDDirector, Name, Surname, Year FROM Film LEFT JOIN Directors ON Film.IDDirector = Directors.IDDirector ORDER BY Year, Title";
if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
    
    echo "<H3>Our DB conteins " . mysqli_num_rows($result) . " films.</H3>";
    
    echo "<table><tr><td><b>Year</b></td><td><b>Title</b></td><td><b>Director</b></td><td>&nbsp;</td></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Year'] . "</td>";
        echo "<td><A href='admin_film_scheda.php?id=" . $row['IDFilm'] . "'>" . $row['Title'] . "</a></td>";
        echo "<td><A href='admin_director_scheda.php?id=" . $row['IDDirector'] . "'>" . $row['Name'] . $row['Surname'] . "</a></td>";
        echo "<td><A href='#' onclick='cancella(".$row['IDFilm'] .");'>delete</a></td>";
        echo "<tr>";
    }
    
    mysqli_free_result($result);
    echo "<tr><td colspan='3'>&nbsp;</td></tr>";
    echo "<tr><td colspan='3'><a href='admin_film_scheda.php'>New film</a></td></tr>";
    
    echo "</table>";
    
}

CleanUpDB();

?>


<?php include "footer.php"; ?>
  </BODY>
</HTML>
