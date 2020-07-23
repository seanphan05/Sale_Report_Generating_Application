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
        <input id="activatePack" class="group_function" type="submit" value="Activate"/>
    </div>
    <hr class="divide">
    <div id="nav-message" style="text-align: center"></div><br>
    <div id="activation_section">
        <div id="checkbox-list1">
            <?php for($i= 0; $i<=10; $i++) {
                echo '<label><input type="checkbox" name="checkboxlist" value="'.$result[$i]['Game ID'].'" /> Game '.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'<label><br><br>';
            } ?>
        </div>
        <div id="checkbox-list2">
            <?php for($i= 11; $i<=21; $i++) {
                echo '<label><input type="checkbox" name="checkboxlist" value="'.$result[$i]['Game ID'].'" /> Game '.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'<label><br><br>';
            } ?>
        </div>
        <div id="checkbox-list3">
            <?php for($i= 22; $i<=32; $i++) {
                echo '<label><input type="checkbox" name="checkboxlist" value="'.$result[$i]['Game ID'].'" /> Game '.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'<label><br><br>';
            } ?>
        </div>
    </div>

<?php }?>



