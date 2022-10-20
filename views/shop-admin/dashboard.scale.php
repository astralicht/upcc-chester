<?php
session_start();
if (!isset($_SESSION["type"]) || $_SESSION["type"] !== "SHOP-ADMIN") header("Location: ../error/403");
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
    </style>
    <title>Dashboard | ISA Shop Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <input type="hidden" id="shop_id" value="<?php echo $_SESSION["shop_id"]; ?>">
        <?php include_once("views/shared/shop_admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/shop_admin_header.php"); ?>
            <div main fullwidth>
                <div flex>
                    <div contain="white" style="width: 200px; padding: 0 1em;" fittocontent>
                        <h2>Products</h2>
                        <h3 id="products-count">N/A</h3>
                    </div>
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
        let shopId = document.querySelector("#shop_id").value;

        fetch("../api/products/count?shop-id=" + shopId).then(response => response.json()).then(json => {
            if (json["status"] !== 200) console.error(json);
            document.querySelector("#products-count").innerText = json["rows"].length;
        });
    </script>
</body>

</html>