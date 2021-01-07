<?php
    require_once('class.pdo.php');
    require_once('class.auth.php');
    require_once('class.user.php');
    require_once('class.functions.php');
    require_once('class.hotel.php');
    require_once('class.template.php');
    require_once('class.email.php');

    $MyPDO = new MyPDO();
    $db = $MyPDO->connection();

    $Auth = new Auth();
    $User = new User();
    $Hotel = new Hotel();
    $Function = new Functions();
    $Template = new Template();
    $Email = new Email();
?>