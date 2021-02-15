<?php
require_once '../load.php';
confirm_logged_in();


if(isset($_POST['submit'])){
    //DEBUG ONLY, remove it after
    ini_set('display_errors', 0);

    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json; charset=UTF-8');
    $results = [];
    $user_name = '';
    $user_pass = '';
    $user_email = '';

    // 1. check the submission out 


    if (isset($_POST['username'])) {
        $user_name = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    }

    if (isset($_POST['email'])) {
        $user_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    }

    if (isset($_POST['password'])) {
        $user_pass = filter_var(htmlspecialchars($_POST['password']), FILTER_SANITIZE_STRING);
    }

    $results['username'] = $user_name;
    $results['password'] = $user_pass;


    // 2. prepare the email - print out the label and put on the package / prepare the package in certain format (for ex. does it have stamps, valid postal code?)

    $email_subject = 'Welcome New User';
    $email_recipient = 'support@website.ca';

    $email_message = sprintf('Username: %s, Email: %s, Password: %s', $user_name, $user_email, $user_pass);

    $email_headers = array(
        'From'=>$user_email
    );

    // 3. send out the email - send out the package

    $email_result = mail($email_recipient, $email_subject, $email_message, $email_headers);

    if ($email_result) {
        $results['message'] = sprintf('Thank you for contacting us, %s. You will get an email with your username and password soon.', $user_name);
    } else {
        $results['message'] = sprintf('We are sorry but the email did not go through.');
    }

    // results

    echo json_encode($results);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>
    <h2>Create User</h2>
    <?php echo !empty($message)?$message:'';?>
    <form action="admin_createuser.php" method="POST">
    <!-- Use POST - do not show sensitive information in URL -->
        <label for="first_name">First Name</label> 
        <input id="first_name" type="text" name="fname" value="">
        <br><br>

        <label for="username">Username</label> 
        <input id="username" type="text" name="username" value="">
        <br><br>

        <p>Password will be generated for you.</p>
        <!-- <label for="password">Password</label> 
        <input id="password" type="text" name="password" value="">
        change type="text" to type="password" for production to hide password when typed - better UX-->
        <br><br> 

        <label for="email">Email</label> 
        <input id="email" type="email" name="email" value="">
        <br><br>

        <button type="submit" name="submit">Create User</button>
        
    </form>

    <?php 
    // if( $sendMail == true ) {
    //     echo "Message sent successfully...";
    // }else {
    //     echo "Message could not be sent...";
    // }
    ?>
    
</body>
</html>