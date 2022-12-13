<?php
session_start();
if (!isset($_SESSION["type"]) && $_SESSION !== "CLIENT") header("Location: ../auth/login");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <title>Logout Confirm | ISA Client</title>
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>

<body flex="v" nogap>
    <div main flex="v" h-center v-center nogap style="flex-grow: 1;">
        <h2>Are you sure you want to logout?</h2>
        <div flex="h" v-center>
            <a style="cursor: pointer;" onclick="history.back()" contain="danger" button small>No</a>
            <a href="../auth/logout" onclick="history.back()" contain="good" button small>Yes</a>
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
</body>

</html>