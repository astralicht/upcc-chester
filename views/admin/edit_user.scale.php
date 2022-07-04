<?php
session_start();
if (!isset($_SESSION["type"])) header("Location: ../error/403");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <title>Edit User | UPCC Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/admin_header_nav.php"); ?>
            <div main>
                <div flex="v">
                    <h1>Edit User</h1>
                    <form onsubmit="return false;">
                        <input type="hidden" value="<?php echo $_GET["id"]; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>

    </script>
</body>

</html>