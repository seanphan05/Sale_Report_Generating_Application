<?php
require ('../../../../wp-load.php');
get_header(); 

session_start();
if($_SESSION['status']!="Active") {
    header("location: http://lotteryreport.ezyro.com");
}
?>
<?php try {
    require "../config/config.php";
    require "../config/common.php";
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT `Game ID`, `Game Name`, `Game Code` FROM `Scratcher Report`";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
}
catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
if ($result && $statement->rowCount() > 0) { ?>

<h1 style="text-align: center;">Scratchers - Report System</h1>
<div style="text-align: center;">
    <button class="group_function" type="button" onclick="home();">Home Page</button>
    <button style="display:none" id="returnAnotherTicket" class="group_function" type="button" onclick="refresh();">Return Another Game</button>
    <input id="returnTicket" class="group_function" type="submit" value="Return"/>
</div>
<hr class="divide">
<div id="returnMessage" style="text-align: center"></div><br>
<div id="returnSection" style="text-align: center">
    <select id="returnList">
        <option selected="selected" value="title">-------------- Please Select A Game --------------</option>
        <?php for($i= 0; $i<=32; $i++) {
            echo '<option value="'.$result[$i]['Game ID'].'">Game '.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'</option>';
        } ?>
    </select><br><br>
    <div id="returnNo">
        <label>How many ticket do you want to return?</label>
        <input id="returnTicketNum" type="number" placeholder="0"/>
    </div>
</div>
<?php }?>