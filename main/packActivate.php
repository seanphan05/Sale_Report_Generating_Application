<?php
include "../temp/header.php";

if (isset($_POST['selectedGames'])) {
    try {
        $games = implode("', '" , $_POST['selectedGames']);
        require "../config/config.php";
        require "../config/common.php";
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM `Scratcher Report`
        WHERE `Current Ticket` <> `Pack Ct.` 
        AND `Current Ticket` IS NOT NULL
        AND `Game ID` IN ("."'".$games."'".")";
        $statement1 = $connection->prepare($sql);
        $statement1->execute();
        $result1 = $statement1->fetchAll();


        $sql = "UPDATE `Scratcher Report`
        SET `Current Ticket` = 0,
        `Begin Ticket` = COALESCE(`Begin Ticket`, 0),
        `End Ticket` = 0
        WHERE (`Current Ticket` = `Pack Ct.` OR `Current Ticket` IS NULL)
        AND `Game ID` IN ("."'".$games."'".")";

        $statement = $connection->prepare($sql);
        $statement->execute();

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<?php if (count($result1)==0 && count($_POST['selectedGames'])!=0) { ?>
    <div>
        <p>All selected Games have been activated! </p><br>
        <button class="group_function" type="button" onclick="refresh();">Activate Other Games</button>
    </div>
<?php } else if (count($_POST['selectedGames'])==0){ ?>
    <div>
        <p style="color: red">You have to select at lease 1 game to activate! </p><br>
        <button class="group_function" type="button" onclick="refresh();">Try Again</button>
    </div>
<?php } else { ?>
    <div>
        <p><span style="color: red">Something went wrong!</span><br> Some game(s) cannot be activated. Please check again!</p><br>
        <button class="group_function" type="button" onclick="refresh();">Try Again</button>
    </div>
<?php } ?>
