<?php
include "../temp/header.php";

if (isset($_POST)) {
    try {
        require "../config/config.php";
        require "../config/common.php";
        if (isset($_POST['action'])) {
            $gameId = $_POST['gameID'];
            $num = $_POST['noReturn'];
            $connection = new PDO($dsn, $username, $password, $options);

            $sql = "SELECT * FROM (SELECT `Game ID`, `Current Ticket`, `No Ticket Sold`  FROM `Scratcher Report` 
            WHERE `Game ID` = ?) AS temp WHERE temp.`Current Ticket` IS NULL
            OR `No Ticket Sold` IS NULL
            OR temp.`No Ticket Sold` < ?
            OR temp.`Current Ticket` < ?";
            $statement1 = $connection->prepare($sql);
            $statement1->execute([$gameId, $num, $num]);
            $result1 = $statement1->fetchAll();

            $sql = "UPDATE `Scratcher Report`
            SET `No Ticket Sold` = `No Ticket Sold` - ?,
            `End Ticket` = `Current Ticket` - ?,
            `Current Ticket` = `Current Ticket` - ?,
            `Total Sale` = `Total Sale` - (? * `Price Unit`)
            WHERE `Game ID` = ?
            AND `No Ticket Sold` >= ?
            AND `Current Ticket` >= ?
            AND `Current Ticket` IS NOT NULL
            AND `No Ticket Sold` IS NOT NULL";

            $statement = $connection->prepare($sql);
            $statement->execute([$num, $num, $num, $num, $gameId, $num, $num]);

        } else {
            foreach ($_POST as $key => &$val) {
                $connection = new PDO($dsn, $username, $password, $options);

                $sql = "SELECT * FROM (SELECT `Game ID`, `Current Ticket`, `Pack Ct.` FROM `Scratcher Report` 
                WHERE `Game ID` = ?) AS temp WHERE temp.`Current Ticket` IS NULL
                OR temp.`Pack Ct.` - temp.`Current Ticket` < ?";
                $statement2 = $connection->prepare($sql);
                $statement2->execute([$key, $val]);

                $sql = "UPDATE `Scratcher Report`
                SET `No Ticket Sold` = COALESCE(`No Ticket Sold`,0) + ?,
                `End Ticket` = `Current Ticket` + ?,
                `Current Ticket` = `Current Ticket` + ?,
                `Total Sale` = COALESCE(`Total Sale`,0) + (? * `Price Unit`)
                WHERE `Game ID` = ?
                AND `Pack Ct.` - `Current Ticket` >= ?
                AND `Current Ticket` IS NOT NULL";

                $statement = $connection->prepare($sql);
                $statement->execute([$val, $val, $val, $val, $key, $val]);

            }
            $result2 = $statement2->fetchAll();

        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// return section
if (isset($_POST['action'])) {
    if (count($result1)==0) {
        if ($_POST['gameID']==="title") { ?>
            <p style="color: red">Something went wrong! You have to select a Game to return ticket(s)!<strong><br><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        <?php } else if (empty($_POST['noReturn'])) { ?>
            <p style="color: red">Something went wrong! Number of return ticket(s) cannot empty!<strong><br><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        <?php } else { ?>
            <p><strong>You have returned <?php echo $_POST['noReturn'] ?> ticket(s) of Game <?php echo substr($_POST['gameID'],-2) ?></strong></p>
        <?php }
     } else { ?>
        <p><strong><span style="color: red">Something went wrong! Possible problems may include:</span><br><br>
        <p style="margin-left: 25em; text-align: left">
            You are returning ticket(s) from an empty Game or <br>
            You are returning more than the number of ticket(s) allowed or <br>
            You are returning ticket(s) of a wrong Game.</p>
            </strong></p><br><br>
        <button class="group_function" type="button" onclick="refresh();">Try Again</button>
    <?php }
}

// add section
else {
    if (count($result2)==0) { ?>
        <p><strong>Sale ticket(s) have been updated!</strong></p>
    <?php } else { ?>
        <p><strong><span style="color: red">Something went wrong! Possible problems may include:</span><br><br>
        <p style="margin-left: 25em; text-align: left">
            You are adding ticket(s) to an empty Game or <br>
            You are adding more than the number of ticket(s) allowed.</p>
        </strong></p>
    <?php }
} ?>