<?php include "../temp/header.php";

if (isset($_POST['clerkName']) && isset($_POST['dateInfo']) && isset($_POST['shiftInfo']) && $_POST['code']==="VGS1495") {
    session_start();
    $_SESSION['status']="Active";
    try {
        require "../config/config.php";
        require "../config/common.php";
        $clerkName = $_POST['clerkName'];
        $dateInfo = $_POST['dateInfo'];
        $shiftInfo = $_POST['shiftInfo'];

        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "UPDATE `Credentials`
        SET `User Name` = ?,
        `Date Info` = ?,
        `Shift Info` = ?
        WHERE `ID` = 1";

        $statement = $connection->prepare($sql);
        $statement->execute([$clerkName, $dateInfo, $shiftInfo]);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}