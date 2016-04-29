<?php

class Cookie
{
    public $last_visit;

    function  __construct()
    {
        $this->last_visit = time();

    }

    function readableTime()
    {
        $unix  = $this->last_visit;
        $date = date("F j, Y, g:i a", $unix);
        return $date;
    }

    function setCookie()
    {
        $date_of_expiry = $this->last_visit + 60;
        $cookie_name = "last_visit";
        $cookie_value = $this->last_visit;
        $date_of_expiry;
        setcookie($cookie_name, $cookie_value ,time() + (86400 * 30), "/");
    }
}


$cookie = new Cookie();
$a =$cookie->setCookie();
echo true;