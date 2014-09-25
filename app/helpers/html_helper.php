<?php
function eh($string)
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function readable_text($string)
{
    $string = htmlspecialchars($string, ENT_QUOTES);
    $s = nl2br($string);
    echo $string;
}

function letters_only($string)
{
    return preg_match ('/^[a-zA-Z\s]+$/',$string);
}

function email_valid($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_not_available($string1, $string2 = true, $inverse = true)
{
    $is_match = ($string1 === $string2);
    return $inverse !== $is_match;
}

function match_password($password, $confirm_password)
{
    return $password === $confirm_password;
}

function redirect($controller)
{
    switch ($controller) {
        case 'thread':
           header('Location: /thread/index');
            break;
        case 'user':
            header('Location: /user/login');
            break;
        default:
            header('Location: login');
            break;
    }
}
