<?php
session_start();
if (!isset($_SESSION["type"]) && $_SESSION !== "CLIENT") header("Location: ../error/403");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        .card {
            width: 60%;
            height: 500px;
            padding: 30px;
            border-radius: 7px;
            box-shadow: 0 6px 6px -6px rgba(0, 0, 0, .2);
            background-color: rgba(15, 39, 85, .8);
            backdrop-filter: blur(3px);
        }

        [form-input] {
            background-color: transparent;
            border-radius: 0;
            border-bottom: 2px solid #e5e5e5;
            color: white;
            outline: none;
            width: 100%;
            font-size: 1em;
        }

        [form-input]::placeholder {
            color: #999;
        }

        .main-content {
            background-image: url("../api/assets/img?name=login.webp&type=webp");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
        }

        ul#notifications-container {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul#notifications-container>li {
            padding: .5em .7em;
        }
    </style>
    <title>Notifications | ISA Client</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/client_nav.php"); ?>
        <div flex="v" style="width: 100%;">
            <?php include_once("views/shared/client_header_nav.php"); ?>
            <input type="hidden" id="user_id" value="<?php echo $_SESSION["id"]; ?>">
            <div main flex="v">
                <h1 nomargin>Notifications</h1>
                <div flex="h" v-center>
                    <a href="?user_id=<?php echo $_SESSION["id"]; ?>&param=unread" small <?php echo ($_GET["param"] === "unread") ? "contain='secondary'" : "contain='overlight' noshadow"; ?>>Unread</a>
                    <a href="?user_id=<?php echo $_SESSION["id"]; ?>&param=all" small <?php echo ($_GET["param"] === "all") ? "contain='secondary'" : "contain='overlight' noshadow"; ?>>All</a>
                    <div flex="h" h-end style="flex-grow: 1;">
                        <a href="../api/notifications/mark-all-read?user_id=<?php echo $_SESSION["id"]; ?>">Mark All as Read</a>
                    </div>
                </div>
                <div flex="v">
                    <?php
                    $response = (new \Main\Models\FetchModel)->notificationsAll(["user_id" => $_SESSION["id"]]);

                    if ($response["status"] != 200 || count($response["rows"]) < 1) {
                        echo "<i fullwidth style='text-align:center'>No new notifications.</i>";
                        return;
                    }

                    $rows = $response["rows"];
                    foreach ($rows as $row) {
                        $message = $row["message"];
                        $dateAdded = $row["date_added"];

                        echo "<div contain='white' fullwidth>$dateAdded | $message</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
</body>

</html>