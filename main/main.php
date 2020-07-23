<?php
require ('../../../../wp-load.php');
get_header(); 

session_start();
if($_SESSION['status']!="Active") {
    header("location: http://lotteryreport.ezyro.com");
}
?>

<h1 style="text-align: center;">Scratchers - Report System</h1>
<div id="main-ribbon">
    <input class="group_function" id="submit" type="submit" value="Submit"/>
    <button class="group_function" type="button" onclick="refresh();">New Transaction</button>
    <button class="group_function" type="button" onclick="current();">Get Current Ticket No</button>
    <button class="group_function" type="button" onclick="activate();">Pack Activation</button>
    <button class="group_function" type="button" onclick="returnTicket();">Return Ticket</button>
    <button class="group_function" type="button" onclick="closeShift();">Print Report and Close Shift</button>
    <button class="group_function" id="toggle" type="button" onclick="testMode();">Test Mode On</button>
</div>
<hr class="divide">
<div id="close_shift_message" style="display:none;">
    <strong>Data have been processed, you can print the report now!</strong>
</div>
<div id="total_add_message" style="display:none;">
    <strong>Total Sale for This Transaction is: <span style="color: red">$<a id="total_add_price">0</a></span></strong>
</div>
<div id="add_sale_message" class="notification" style="display:none;"></div><br>

<?php try {
require "../config/config.php";
require "../config/common.php";
$connection = new PDO($dsn, $username, $password, $options);
$sql = "SELECT `Game ID`, `Game Name`, `Game Code`, `Price Unit` FROM `Scratcher Report`";
$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();
}
catch (PDOException $error) {
echo $sql . "<br>" . $error->getMessage();
} ?>

<?php if ($result && $statement->rowCount() > 0) { ?>
<div id="firstCol">
    <?php for($i= 0; $i<=15; $i++) { ?>
    <div class="column">
        <p><strong class="title">Game <?php echo substr(escape($result[$i]['Game ID']), 4); ?> - <?php echo $result[$i]['Game Name']; ?> - <?php echo $result[$i]['Game Code']; ?> - $<span id="price_<?php echo $result[$i]['Game ID']; ?>"><?php echo $result[$i]['Price Unit']; ?></span></strong>
            <span id="add_message_<?php echo $result[$i]['Game ID']; ?>" class="tab" style="display:none;">Added <a class="temp" id="add_<?php echo $result[$i]['Game ID']; ?>">0</a> ticket(s). Total: <a class="temp" id="add_price_<?php echo $result[$i]['Game ID']; ?>">0</a></span>
        </p>
        <form>
            <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 1);">Add 1</button>
            <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 2);">Add 2</button>
            <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 3);">Add 3</button>
            <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 4);">Add 4</button>
            <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 5);">Add 5</button>
            <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 10);">Add 10</button>
            <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="resetCount(this);">Reset</button>
        </form>
    </div>
    <hr>
    <?php } ?>
</div>

<div id="secondCol">
    <?php for($i= 16; $i<=31; $i++) { ?>
        <div class="column">
            <p><strong class="title">Game <?php echo substr(escape($result[$i]['Game ID']), 4); ?> - <?php echo $result[$i]['Game Name']; ?> - <?php echo $result[$i]['Game Code']; ?> - $<span id="price_<?php echo $result[$i]['Game ID']; ?>"><?php echo $result[$i]['Price Unit']; ?></span></strong>
                <span id="add_message_<?php echo $result[$i]['Game ID']; ?>" class="tab" style="display:none;">Added <a class="temp" id="add_<?php echo $result[$i]['Game ID']; ?>">0</a> ticket(s). Total: <a class="temp" id="add_price_<?php echo $result[$i]['Game ID']; ?>">0</a></span>
            </p>
            <form>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 1);">Add 1</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 2);">Add 2</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 3);">Add 3</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 4);">Add 4</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 5);">Add 5</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 10);">Add 10</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="resetCount(this);">Reset</button>
            </form>
        </div>
        <hr>
    <?php } ?>
</div>

<div id="testCol">
    <?php for($i= 32; $i<=32; $i++) { ?>
        <div class="column">
            <p><strong class="title">Game <?php echo substr(escape($result[$i]['Game ID']), 4); ?> - <?php echo $result[$i]['Game Name']; ?> - <?php echo $result[$i]['Game Code']; ?> - $<span id="price_<?php echo $result[$i]['Game ID']; ?>"><?php echo $result[$i]['Price Unit']; ?></span></strong>
                <span id="add_message_<?php echo $result[$i]['Game ID']; ?>" class="tab" style="display:none;">Added <a class="temp" id="add_<?php echo $result[$i]['Game ID']; ?>">0</a> ticket(s). Total: <a class="temp" id="add_price_<?php echo $result[$i]['Game ID']; ?>">0</a></span>
            </p>
            <form>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 1);">Add 1</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 2);">Add 2</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 3);">Add 3</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 4);">Add 4</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 5);">Add 5</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 10);">Add 10</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="resetCount(this);">Reset</button>
            </form>
        </div>
        <hr>
    <?php } ?>
</div>
<?php } ?>
<?php get_footer(); ?>
