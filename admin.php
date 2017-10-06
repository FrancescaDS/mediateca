<?php

require_once 'functions/functions.php';
require 'includes/database.php';


$is_submitted = false; // has the form been submitted?
$success = false;
$errors = []; // Error messages from validation routines
$valid_data = []; // Valid data from validation routines
$redisplay_email = ' ';
$redisplay_password = '';

$button = filter_input(INPUT_POST, 'login_user');
if (!is_null($button)) {

    // Change value of flag variable
    $is_submitted = true;

    $email = trim(filter_input(INPUT_POST, 'email'));
    if (is_null($email)){
        $errors['email'] = 'Write your email in the field';
    } else {
        $valid_data['email'] = $email;
    }
    if (isset($valid_data['email'])) {
        $redisplay_email = htmlentities($valid_data['email'], ENT_QUOTES, 'utf-8');
    }
    
    $password = trim(filter_input(INPUT_POST, 'password'));
    if (is_null($password)){
        $errors['password'] = 'Write your password in the field';
    } else {
        $valid_data['password'] = $password;
    }
    if (isset($valid_data['password'])) {
        $redisplay_password = htmlentities($valid_data['password'], ENT_QUOTES, 'utf-8');
    }
    
    
    $classe_errore = 'error';
    if (empty($errors)) {
        $new_user = new UserService($db);
        if ($new_user->login($email, $password)){
            $classe_errore = 'no_error';
            $error_msg = 'Welcome back '. $new_user->getData()['firstname'];
            $_SESSION['logged_in'] = true;

            $_SESSION['user'] = $new_user->getData();
            $success = true;

        } else {
            $error_msg = 'Sorry, your credentials are invalid';
        }
    } else {
        $error_msg = 'ERROR LIST:<br />';
        foreach($errors as $key => $value) {
            $error_msg .=  $key . ': ' . $value . '<br />';
        }
    }
} elseif (!empty($_POST['Logout'])) {
    UserLogOut();
}


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ADMIN - MEDIATECA</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>

    <?php include "includes/header.php"; ?>
   
    <H1>ADMIN</H1>
    
    <?php 
    if ($is_submitted === true) {
        echo '<p class="' . $classe_errore. '">' . $error_msg . '</p>';
    }
    ?>
            
    <?php 
    if (!empty($_SESSION['logged_in'])){
        if ($_SESSION['logged_in'] === true ){ ?>
            <p class='giusto'>Welcome back <?php echo strtoupper($_SESSION['user']['firstname'])?> </p>

            <FORM name="logout" action="admin.php" method="post">
                <INPUT hidden="true" type='text' name='Logout' value="True">
                <INPUT type='submit' value='LOGOUT'>
            </FORM>
            <BR>
            <TABLE>
                <TR><TD><a href="admin_film_list.php">Film list</a></TD></TR>
                <TR><TD><a href="admin_actor_list.php">Actor/actress list</a></TD></TR>
                <TR><TD><a href="admin_director_list.php">Director list</a></TD></TR>
            </TABLE>
    <?php
        }
    }elseif (!$success) { ?>
            <table>
            <form action="admin.php" method="post" autocomplete="false">
            <tr>
                <td><label for="email-field">Email:</label></td>
                <td><input type="text" name="email" id="email-field" autocomplete="false"  value="<?php echo $redisplay_email ?>" />
</td>       </tr>
            <tr>
                <td><label for="password-field">Password:</label></td>
                <td><input type="password" name="password" id="password-field" autocomplete="false"  value="<?php echo $redisplay_password ?>" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="login_user" value="Log in" /></td>
            </tr>
            <tr>
                <td colspan="2"><a href="register.php">Register</a></td>
            </tr>
        </form>
            </table>
    <?php } ?>
    
    
    
    
    
    
    
    <?php include "includes/footer.php"; ?>
    
</BODY>
</HTML>