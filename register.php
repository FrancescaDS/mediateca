<?php
require_once 'functions/functions.php';
require 'includes/database.php';

/**
 * Set up flag variables and data array variables
 */
$is_submitted = false; // has the form been submitted?
$success = false; //flag to see or hide the form
$errors = []; // Error messages from validation routines
$valid_data = []; // Valid data from validation routines
$redisplay_email = '';
$redisplay_password = '';
$redisplay_firstname = '';
$redisplay_surname = '';

/**
 * Check if form was submitted, using the "name" of the button element
 * If it was, we validate the fields, recording info as we go.
 */
$button = filter_input(INPUT_POST, 'register_user');
if (!is_null($button)) {

    // Change value of flag variable
    $is_submitted = true;
    
    try {
        
        $user = new UserService($db);
        
        //validate email
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (is_null($email)) {
            $errors['email'] = 'Please enter a valid email - now the field is empty';
        } elseif ($email === false) {
            $errors['email'] = 'Please enter a valid email';
        } else {
            //check if email still exists in the db
            if ($user->existsEmail($email)){
                $errors['email'] = 'Your email is still present in our db, please enter a new valid email or login';
            } else {
                $valid_data['email'] = @email;
            }
        }
        if (isset($valid_data['email'])) {
            $redisplay_email = htmlentities($valid_data['email'], ENT_QUOTES, 'utf-8');
        }
        
        //validate password 6 chars and 20 max
        $password = trim(filter_input(INPUT_POST, 'password'));
        if ((strlen($password) < 6) or (strlen($password) > 20)){
            $errors['password'] = 'Your password must be 6-20 charactes long.';
        } else {
            $valid_data['password'] = @password;
        }
        if (isset($valid_data['password'])) {
            $redisplay_password = htmlentities($valid_data['password'], ENT_QUOTES, 'utf-8');
        }
        

        //validate firstname max 255 chars
        $firstname = trim(filter_input(INPUT_POST, 'firstname'));
        if ((strlen($firstname) === 0 ) or (strlen($firstname) > 255)){
            $errors['firstname'] = 'Your firstname must be less than 255 charactes long.';
        } else {
            $valid_data['firstname'] = $firstname;
        }
        if (isset($valid_data['firstname'])) {
            $redisplay_firstname = htmlentities($valid_data['firstname'], ENT_QUOTES, 'utf-8');
        }
        
        //validate surname max 255 chars
        $surname = trim(filter_input(INPUT_POST, 'surname'));
        if ((strlen($surname) === 0 ) or (strlen($surname) > 255)){
            $errors['surname'] = 'Your surname must be less than 255 charactes long.';
        } else {
            $valid_data['surname'] = $surname;
        }
        if (isset($valid_data['surname'])) {
            $redisplay_surname = htmlentities($valid_data['surname'], ENT_QUOTES, 'utf-8');
        }
        
        
    } catch (PDOException $e) {
        exit('Failed to connect: ' . $e->getMessage());
    }
 
    $classe_errore = 'error';
    if (empty($errors)) {
        //inserire i dati nel db
        $new_user = new UserService($db);
        if (!($new_user->register($email, $password, $firstname, $surname))){
            $error_msg = 'problem insert';
        } else {
            $error_msg = 'Welcome '. $new_user->getData()['firstname'];
            $classe_errore = 'no_error';
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $new_user->getData();
            $success = true;
        }
    } else {
        $error_msg = 'ERROR LIST:<br />';
        foreach($errors as $key => $value) {
            $error_msg .=  $key . ': ' . $value . '<br />';
        }
    }
}




?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>REGISTRATION - MEDIATECA</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>

    <?php include "includes/header.php"; ?>
   
    <H1>REGISTRATION</H1>
       
            <?php
            if ($is_submitted === true) {
                echo '<p class="' . $classe_errore. '">' . $error_msg . '</p>';
            }
        ?> 
    
    <?php 
    if (!empty($_SESSION['logged_in'])){
        if ($_SESSION['logged_in'] === true ){ ?>
            <p class='giusto'>Welcome <?php echo strtoupper($new_user->getData()['firstname'])?> </p>
            
            <TABLE>
                <TR><TD><a href="admin_film_list.php">Film list</a></TD></TR>
                <TR><TD><a href="admin_actor_list.php">Actor/actress list</a></TD></TR>
                <TR><TD><a href="admin_director_list.php">Director list</a></TD></TR>
            </TABLE>
    <?php
        }
    }
    ?> 
    
    
        
        <?php if (!$success) {?>
        <!-- The form... -->
        <table>
        <form action="register.php" method="post" autocomplete="false">
            <tr>
                <td><label for="email-field">Email:</label></td>
                <td><input type="text" name="email" id="email-field" autocomplete="false" value="<?php echo $redisplay_email ?>" /></td>
            </tr>
            <tr>
                <td><label for="password-field">Password:</label></td>
                <td><input type="password" name="password" id="password-field" autocomplete="false"   value="<?php echo $redisplay_password ?>" /></td>
        </tr>
            <tr>
                <td><label for="firstname-field">First name:</label></td>
                <td><input type="text" name="firstname" id="firstname-field" autocomplete="false"  value="<?php echo $redisplay_firstname ?>"  /></td>
            </tr>
            <tr>
                <td><label for="surname-field">Surname:</label></td>
                
                <td><input type="text" name="surname" id="surname-field" autocomplete="false"  value="<?php echo $redisplay_surname ?>"  /></td>
            </tr>
            <tr><td colspan="2"><input type="submit" name="register_user" value="Register" /></td></tr>
             <tr>
                <td colspan="2"><a href="admin.php">Login</a></td>
            </tr>
        </form>
        </table>
        <?php } ?>
        
        <?php include "includes/footer.php"; ?>

    </body>
</html>
