<?php

    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", 
    "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);

    $emailTo = "moussadiallo10.mmd@gmail.com";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $array["firstname"] = verifyinput($_POST["firstname"]);
        $array["name"] = verifyinput($_POST["name"]);
        $array["email"] = verifyinput($_POST["email"]);
        $array["phone"] = verifyinput($_POST["phone"]);
        $array["message"] = verifyinput($_POST["message"]);
        $array["isSuccess"] = true;
        $emailText = "";

        if(empty($array["firstname"]))
        {
            $array["firstnameError"] = "Puis-je connaître ton prénoms stp !";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Firstname:{$array["firstname"]}\n";
        }
            
        if(empty($array["name"]))
        {
            $array["nameError"] = "je connaître ton nom aussi !";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Name: {$array["name"]}\n";
        }
            
        if(empty($array["message"]))
        {
            $array["messageError"] = "Quel message veux-tu que je reçoives ?";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "message: {$array["message"]}\n";
        }
        if(!isEmail($array["email"]))
        {
            $array["emailError"] = "C'est une joke? Entre un email et arrête de me niaiser!";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Email: {$array["email"]}n";
        }
        if(!isPhone($array["phone"]))
        {
            $array["phoneError"] = "Que des chiffres et des espaces svp!";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "Phone: {$array["phone"]}\n";
        }
        if($array["isSuccess"])
        {
            //Envoi_email
            $headers = "From : {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply To : {$array["email"]}";
            mail($emailTo, "Un message de votre portfolio", $emailText, $headers);
        }

        echo json_encode($array);

    }

    function isPhone($var)
    {
        return preg_match("/^[0-9 ]*$/", $var);
    }

    function isEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function verifyinput($var)
    {
        $var = trim($var);
        $var = stripcslashes($var);
        $var = htmlspecialchars($var);

        return $var;
    }

?>