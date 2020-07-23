<?php
include "../temp/header.php";

try {
    require "../config/config.php";
    require "../config/common.php";
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "UPDATE `Scratcher Report`
    SET `No Ticket Sold` = NULL,
    `Total Sale` = NULL,
    `Current Ticket` = IF(`Current Ticket` = `Pack Ct.`, NULL, `Current Ticket`),
    `End Ticket` = IF(`End Ticket` = `Pack Ct.`, NULL, `End Ticket`),
    `Begin Ticket` = `End Ticket`
    WHERE `Begin Ticket` IS NOT NULL";
    $statement = $connection->prepare($sql);
    $statement->execute();

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
