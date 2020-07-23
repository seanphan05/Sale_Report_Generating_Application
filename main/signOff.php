<?php
include "../temp/header.php";

try {
    require "../config/config.php";
    require "../config/common.php";
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "UPDATE `Credentials`
    SET `User Name` = NULL,
    `Date Info` = NULL,
    `Shift Info` = NULL
    WHERE `ID` = 1";
    
    $statement = $connection->prepare($sql);
    $statement->execute();

    // destroy session
    session_start();
    session_destroy();
    $_SESSION = array();

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}