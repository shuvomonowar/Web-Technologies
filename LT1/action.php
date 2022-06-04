<?php
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $gendermf = $_POST["gender"];
    $email = $_POST["email"];
    $mobileno = $_POST["tel"];
    $location = $_POST["address"];

    if(empty($firstname)) {
        echo nl2br("First Name is empty.\n");
    }
    if(empty($lastname)) {
        echo nl2br("Last Name is empty.\n");
    }
    if(empty($gendermf)) {
        echo nl2br("Gender is not selected.\n");
    }
    if(empty($email)) {
        echo nl2br("Email is empty.\n");
    }
    if(empty($mobileno)) {
        echo nl2br("Mobile No is empty.\n");
    }
    if(empty($location)) {
        echo nl2br("Address is empty.\n");
    }
    else {
        echo nl2br("Registration is completed successfuly.\n");
    }
?>