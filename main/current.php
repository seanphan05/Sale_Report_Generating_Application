<?php
require ('../../../../wp-load.php');
get_header(); 
session_start();

if($_SESSION['status']!="Active") {
    header("location: http://lotteryreport.ezyro.com");
}
?>
<h1 style="text-align: center;">Scratchers - Report System</h1>
<form style="text-align: center;">
    <button class="group_function" type="button" onclick="home();">Home Page</button>
</form>
<hr class="divide">
<div id="currentTicket">
    <?php include "getCurrent.php" ?>
</div>

