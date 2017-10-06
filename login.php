<?php
session_start();

// Classes
require_once 'functions.php';

// The database connection
require 'includes/database.php';


/**
 * Set up flag variables and data array variables
 */
$is_submitted = false; // has the form been submitted?
$success = false;
$errors = []; // Error messages from validation routines
$valid_data = []; // Valid data from validation routines
$redisplay_email = ' ';
$redisplay_password = '';

/**
 * Check if form was submitted, using the "name" of the button element
 * If it was, we validate the fields, recording info as we go.
 */
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
        $errors['password'] = 'Write your email in the field';
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
}

// Include the navigation script
$navigation = '';
require 'includes/navigation.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login page</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            // Echo the navigation
            echo $navigation;
        ?>

        <h1>Log in to your account</h1>
     
        <?php if ($is_submitted === true) {
            echo '<p class="' . $classe_errore. '">' . $error_msg . '</p>';
        }
?>
        
        <?php if (!$success) {?>
        <!-- The form... -->

        <form action="login.php" method="post" autocomplete="false">
            <p>
                <label for="email-field">Email:</label>
                <input type="text" name="email" id="email-field" autocomplete="false"  value="<?php echo $redisplay_email ?>" />
            </p>
            <p>
                <label for="password-field">Password:</label>
                <input type="password" name="password" id="password-field" autocomplete="false"  value="<?php echo $redisplay_password ?>" />
            </p>
            <input type="submit" name="login_user" value="Log in" />

        </form>
        <?php } ?>
        
        <?php include "includes/footer.php"; ?>

    </body>
</html>
