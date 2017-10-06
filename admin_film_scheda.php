<!DOCTYPE html>

<HTML>
    <HEAD>
<script type="text/javascript"> 
function Controlla() {
    var Title = document.scheda.Title.value;
    var IDDirector = document.scheda.IDDirector.value;
    var Year = document.scheda.Year.value;
    var IDCountry = document.scheda.IDCountry.value;
    //Effettua il controllo sul campo Title
    if ((Title == "") || (Title == "undefined")) {
        alert("Write the title of the film.");
        document.scheda.Title.focus();
        return false;
    }
    else if (IDDirector == "0") {
        alert("Select the director.");
        document.scheda.IDDirector.focus();
        return false;
    } 
    else if (IDCountry == "0") {
        alert("Select the Country.");
        document.scheda.IDCountry.focus();
        return false;
    } 
    else if (Year == "0") {
        alert("Select the Year.");
        document.scheda.Year.focus();
        return false;
    } 
    else {
        document.scheda.action = "admin_film.php";
        document.scheda.submit();
    }
}
     
</script>

<TITLE>FILM SCHEDA - ADMIN - MEDIATECA</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK rel="stylesheet" href='style.css'> </HEAD>
<BODY>

    <?php include "includes/header.php"; ?>
   
    <H1>ADMIN - FILM</H1>


<?php
require_once("functions/connection.inc.php");
require_once("functions/functions.php");

if (empty(getUser())){
    header("location: admin.php");
    exit;
}else{
    echo "<p class='giusto'>".strtoupper($User['Username'])."</p>";
}

$newIDActor = 0;
$delIDActor = 0;
if (!empty($_GET['id'])){
    $cheID = $_GET['id'];
    if (!empty($_GET['delIDActor'])){
        $delIDActor = $_GET['delIDActor'];
    }
}elseif (!empty($_POST['id'])){
    $cheID = $_POST['id'];
    if (!empty($_POST['newIDActor'])){
        $newIDActor = $_POST['newIDActor'];
    }
}else{
    $cheID = 0;
    $Title = "";
    $IDDirector = 0;
    $IDCountry = 0;
    $Year = 0;
}
$IDPoster =0;

if (!empty($_GET['ins'])){
     echo "<p class='giusto'>Film inserted/updated</p>";
}

if ($cheID==0){
    echo "NEW FILM";
} else{
    
    //se bisogna inserire un nuovo Actor
    if ($newIDActor <> 0){
        $cheQuery = "INSERT INTO FilmActor(IDFilm, IdActor) VALUES (".$cheID.",".$newIDActor.")";
        mysqli_query(GetMyConnection(), $cheQuery);
    }elseif ($delIDActor <> 0){
        $cheQuery = "DELETE FROM FilmActor WHERE IDFilm=".$cheID." AND IDActor=".$delIDActor;
        mysqli_query(GetMyConnection(), $cheQuery);
    }
    
    $cheQuery ="SELECT Film.IDFilm, Title, IDDirector, Year, IDCountry, IDPoster FROM Film ";
    $cheQuery = $cheQuery . "LEFT JOIN Posters ON Posters.IDFilm = Film.IDFilm ";
    $cheQuery = $cheQuery . "WHERE Film.IDFilm=" . $cheID ;
    
    if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {

        $row = $result->fetch_assoc();
        $Title = $row['Title'];
        $IDDirector = $row['IDDirector'];
        $IDCountry = $row['IDCountry'];
        $Year = $row['Year'];
        $IDPoster = $row['IDPoster'];
        if (is_null($IDPoster)){
          $IDPoster = 0;  
        }
        mysqli_free_result($result);
    }
}

?>
    <FORM name="scheda" method="post"> 
        <INPUT type='text' name='id' hidden="true" value="<?php echo $cheID; ?>">
        <INPUT type='text' name='update' hidden="true" value="1">
        <TABLE>
            <TR><TD class='newp'>Title</TD>
                <TD><INPUT type='text' name='Title' value="<?php echo $Title; ?>"></TD></TR> 
            <TR><TD class='newp'>Director</TD>
                <TD>
<?php 
    //Directors
    $cheQuery ="SELECT Directors.IDDirector, Name, Surname FROM Directors ORDER BY Surname";
    if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
        echo "<select name='IDDirector' id='IDDirector'>";
        $Sele = "<option value=0 ";
        if ($IDDirector==0){
            $Sele = $Sele . " selected";
        }
        $Sele = $Sele . "> --- </option>";
        echo $Sele;
        while ($row = $result->fetch_assoc()) {
            $Sele = "<option value=".$row['IDDirector'];
            if ($IDDirector == $row['IDDirector']){
                $Sele = $Sele . " selected"; 
            }
            $Sele = $Sele . ">".$row['Name']." ".$row['Surname']."</option>";
        echo $Sele;   
        }
        echo "</select>";
        mysqli_free_result($result);
    }
    if ($IDDirector != 0){
        echo "&nbsp;<a href='admin_director_scheda.php?id=$IDDirector'>director page</a>";
    }
?>
            </TD</TR> 
            <TR><TD class='newp'>Year</TD>
                <TD>
<?php 
    //Year
    echo "<select name='Year' id='Year'>";
    $Sele = "<option value=0 ";
    if ($Year==0){
        $Sele = $Sele . " selected";
    }
    $Sele = $Sele . "> --- </option>";
    echo $Sele;
    for ($i = 1920; $i <= 2017; $i++) {
        $Sele = "<option value=".$i;
            if ($Year == $i){
                $Sele = $Sele . " selected"; 
            }
            $Sele = $Sele . ">".$i."</option>";
        echo $Sele; 
    }
    echo "</select>";
?>
            </TD</TR>  
            <TR><TD class='newp'>Country</TD>
                <TD>
<?php 
    //Countries
    $cheQuery ="SELECT IDCountry, Country FROM Countries ORDER BY Country";
    if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
        echo "<select name='IDCountry' id='IDCountry'>";
        $Sele = "<option value=0 ";
        if ($IDCountry==0){
            $Sele = $Sele . " selected";
        }
        $Sele = $Sele . "> --- </option>";
        echo $Sele;
        while ($row = $result->fetch_assoc()) {
            $Sele = "<option value=".$row['IDCountry'];
            if ($IDCountry == $row['IDCountry']){
                $Sele = $Sele . " selected"; 
            }
            $Sele = $Sele . ">".$row['Country']."</option>";
        echo $Sele;   
        }
        echo "</select>";
        mysqli_free_result($result);
    }
?>
            </TD</TR> 
            
            <TR><TD><INPUT type='reset' value='CANCEL'></TD>
                <TD><INPUT type='submit' value='OK' onClick='Controlla();'></TD></TR>
            
            <TR><TD colspan="2">&nbsp;</TD></TR>
        </TABLE>
    </FORM>
   
    

    <TABLE>       
        <TR><TD class='newp'>Poster</TD>
            <TD>
<?php
//Poster
if ($cheID ==0){
    echo "You will be able to upload a poster only when your film is created";
}
else{
    if (!empty($_GET['img'])){    
        if ($_GET['img']== -2){
            echo "No new file to upload/Problems with the new file (maybe too large)<br>";
        }elseif ($_GET['img']== -1){
            echo "The file was too big<br>";
        }
    }
    if  ($IDPoster !=0){
        $cheQuery = "SELECT IDPoster, Name, Type, Poster FROM Posters WHERE IDPoster='$IDPoster'";
        if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
            $row = $result->fetch_assoc();
            $Name = $row['Name'];
            $Type = $row['Type'];
            $Poster = $row['Poster'];
            echo $Name . "&nbsp;<a href='admin_film.php?id=$cheID&delPoster=1'>delete poster</a><br>";
            echo '<img src="data:'.$Type.';base64,'.base64_encode( $Poster ).'"/>';        
        } else{
            echo "Problems with showing the poster uploaded.";
        }
    }else{
        echo "No poster uploaded";
    }     
?>

<form enctype="multipart/form-data"  action="admin_film.php" method="post">
    <INPUT type='text' name='id' hidden="true" value="<?php echo $cheID; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    <input type="file" name="file" size="40" />
    <input type="submit" value="Upload" />
</form>
<?php
}
?>            
            </TD>
        </TR>
    </TABLE>

    
    
    
    <TABLE>       
            <TR><TD class='newp'>Cast</TD>
                <TD>
                    <?php
//Cast
if ($cheID ==0){
    echo "You will be able to assign a cast only when your film is created";
}else{                 
              
    $cheQuery ="SELECT Actors.IDActor, Name, Surname FROM Actors ";
    $cheQuery = $cheQuery . "INNER JOIN FilmActor ON Actors.IDActor = FilmActor.IDActor ";
    $cheQuery = $cheQuery . "WHERE IDFilm=" . $cheID . " ORDER BY Surname";
    if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
        while ($row = $result->fetch_assoc()) {
            echo "<a href='admin_actor_scheda.php?id=" . $row['IDActor'] . "'>" . $row['Surname'] . " " . $row['Name'] . "</A> <a href='admin_film_scheda.php?id=".$cheID."&delIDActor=".$row['IDActor']."'>cancel</a><br>";
        }
        mysqli_free_result($result);
    }
    $cheQuery = "SELECT Actors.IDActor, Name, Surname FROM Actors ";
    $cheQuery = $cheQuery . "WHERE not EXISTS(SELECT FilmActor.idActor from FilmActor WHERE FilmActor.IDActor = Actors.IDActor and FilmActor.IDFilm=".$cheID.") ";
    $cheQuery = $cheQuery . " ORDER BY Surname";
    if ($result = mysqli_query(GetMyConnection(), $cheQuery)) {
        echo "<FORM name='Actors' action='admin_film_scheda.php' method='post'>"; 
        echo "<INPUT type='text' name='id' hidden='true' value=".$cheID.">";
        
        echo "New actor <select name='newIDActor' id='newIDActor'>";
        echo "<option value='' selected> --- </option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"".$row['IDActor']."\">".$row['Name']." ".$row['Surname']."</option>";
        }
        echo "</select> <INPUT type='submit' value='INSERT'></FORM>";
        mysqli_free_result($result);
    }
}  
?>                 </TD></TR>
            
            <TR><TD colspan="2">&nbsp;</TD></TR>
            <TR><TD colspan="2"><a href='admin_film_scheda.php'>New film</a></TD></TR>
            <TR><TD colspan="2"><a href='admin_film_list.php'>Film list</a></TD></TR>
            
        </TABLE>
    
<?php
CleanUpDB();
?>


<?php include "includes/footer.php"; ?>
  </BODY>
</HTML>


