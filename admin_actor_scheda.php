<!DOCTYPE html>

<HTML>
    <HEAD>

        
<script type="text/javascript"> 
function Controlla() {
    var Name = document.scheda.Name.value;
    var Surname = document.scheda.Surname.value;
    //Effettua il controllo sul campo Name e Surname
    if ((Name == "") || (Name == "undefined")) {
        alert("Write the Name.");
        document.scheda.Name.focus();
        return false;
    }
    else if ((Surname == "") || (Surname == "undefined")) {
        alert("Write the Surname.");
        document.scheda.Surname.focus();
        return false;
    }
    else {
        document.scheda.action = "admin_actor.php";
        document.scheda.submit();
    }
}
     
</script>
        
<TITLE>ACTOR/ACTRESS SCHEDA - ADMIN - MEDIATECA</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK rel="stylesheet" href='style.css'> </HEAD>
<BODY>

    <?php include "includes/header.php"; ?>
   
    <H1>ADMIN - ACTOR/ACTRESS</H1>


<?php
require_once("functions/connection.inc.php");
require_once("functions/functions.php");

if (empty(getUser())){
    header("location: admin.php");
    exit;
}else{
    echo "<p class='giusto'>".strtoupper($User['Username'])."</p>";
}


if (!empty($_GET['id'])){
    $cheID = $_GET['id'];
}elseif (!empty($_POST['id'])){
    $cheID = $_POST['id'];
}else{
    $cheID = 3;
}


$persona = new Persona('Actor', $cheID);

if (!empty($_GET['ins'])){
     echo "<p class='giusto'>Actor/Actress inserted/updated</p>";
}

if ($cheID==0){
    echo "NEW ACTOR/ACTRESS";
}

?>
    <FORM name="scheda" method="post"> 
        <INPUT type='text' name='id' hidden="true" value="<?php echo $cheID; ?>">
        <INPUT type='text' name='update' hidden="true" value="1">
        <TABLE>
            <TR><TD class='newp'>Name</TD>
                <TD><INPUT type='text' name='Name' value="<?php echo $persona->Name; ?>"></TD></TR> 
            <TR><TD class='newp'>Surname</TD>
                <TD><INPUT type='text' name='Surname' value="<?php echo $persona->Surname; ?>"></TD</TR> 
            
            <TR><TD><INPUT type='reset' value='CANCEL'></TD>
                <TD><INPUT type='submit' value='OK' onClick='Controlla();'></TD></TR>
            <TR><TD colspan="2">&nbsp;</TD></TR>
            
            <TR><TD class='newp'>Films</TD>
                <TD>
<?php 
    $Lista = $persona->lista_film;
   /* while($row = $Lista->fetch_assoc()) { 
        echo "<a href='admin_film_scheda.php?id=" . $row['IDFilm'] . "'>" . $row['Title'] ." (".$row['Year'].")</A><br>";
    }*/


    $cheQuery ="SELECT Film.IDFilm, Title, Year FROM Film ";
    $cheQuery = $cheQuery . "INNER JOIN FilmActor ON Film.IDFilm = FilmActor.IDFilm ";
    $cheQuery = $cheQuery . "WHERE IDActor=" . $cheID ;

    if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {

        while ($row = $result->fetch_assoc()) {
            echo "<a href='admin_film_scheda.php?id=" . $row['IDFilm'] . "'>" . $row['Title'] ." (".$row['Year'].")</A><br>";
        }
        mysqli_free_result($result);
    }
?>    
               </TD></TR>
            <TR><TD colspan="2">&nbsp;</TD></TR>
            
            <TR><TD colspan="2"><a href='admin_actor_scheda.php'>New actor/actress</a></TD></TR>
            <TR><TD colspan="2"><a href='admin_actor_list.php'>Actor list</a></TD></TR>
            
        </TABLE>
    </FORM>
    
    
<?php
CleanUpDB();
?>


<?php include "includes/footer.php"; ?>
  </BODY>
</HTML>


