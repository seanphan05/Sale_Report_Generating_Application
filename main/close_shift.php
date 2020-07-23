<?php
require ('../../../../wp-load.php');
get_header();

session_start();
if($_SESSION['status']!="Active") {
    header("location: http://lotteryreport.ezyro.com");
}
?>
<h1 style="text-align: center;">Scratchers - Shift Close Report</h1>
<form style="text-align: center;">
    <button class="group_function" type="button" onclick="home();">Home Page</button>
    <input id="showReport" class="group_function" type="submit" value="View Report">
    <button id="print" class="group_function" type="button" style="display:none;" onclick="printReport();">Print</button>
    <input id="closeShift" class="group_function" type="submit" value="Close Shift" disabled/>
</form>
<hr style="width:80%" class="divide">
<div id="reminder" style="text-align: center; display:block">Reminder: You can only close the shift after printing out the report!</div>
<br>
<div id="scratcher_report"></div>
<div id="close_shift_message" style="text-align: center; display:none">
    Shift Close has been processed! You can now sign off.<br><br>
    <input id="signOff" type="submit" value="Sign Off">
</div>