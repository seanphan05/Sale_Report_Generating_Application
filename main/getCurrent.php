<?php
include "../temp/header.php";
try {
        require "../config/config.php";
        require "../config/common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT `Game ID`, `Pack Ct.`, `Current Ticket` FROM `Scratcher Report` WHERE `Game Code` <> 9999";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        }

catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

if ($result && $statement->rowCount() > 0) { ?>
    <h3 style="text-align: center;">Current Tickets No</h3>
    <table id="current_ticket_table">
        <tr>
            <th  class= "head" style="text-align: center">Game</th>
            <?php foreach ($result as $row) { ?>
            <td style="text-align: center"><?php echo substr(escape($row["Game ID"]), 4); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <th class= "head" style="text-align: center">No</th>
            <?php foreach ($result as $row) { ?>
            <td style="text-align: center; font-weight: bold"><?php if($row['Current Ticket']==$row["Pack Ct."]) {echo "";} else {echo escape($row["Current Ticket"]);} ?></td>
            <?php } ?>
        </tr>
    </table>
<?php } else { ?>
    <p>No Result found!</p>
<?php } ?>
