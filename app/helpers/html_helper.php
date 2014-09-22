<?php

function eh($string)
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function readable_text($s)
{
    $s = htmlspecialchars($s, ENT_QUOTES);
    $s = nl2br($s);
    echo $s;
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
