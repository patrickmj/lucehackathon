<?php

function on_site($siteName)
{
    $hereCheck = new Zend_Session_Namespace($siteName);
    return $hereCheck->here;
}

function set_on_site($siteName, $here = true)
{
    $hereCheck = new Zend_Session_Namespace($siteName);
    $hereCheck->here = $here;
}

function set_on_site_by_ip($siteName, $ip_range)
{
    $ip = Zend_Controller_Front::getRequest();
    
}