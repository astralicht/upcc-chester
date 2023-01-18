<?php
session_start();
if (!isset($_SESSION["type"]) && $_SESSION !== "ADMIN") header("Location: ../error/403");
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
    <title>Edit Shop #<?php echo $_GET["id"]; ?> | ISA Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" style="width: 100%;" nogap>
            <div main fullwidth flex="v">
                <div>
                    <button button contain="secondary" small onclick="history.back()">Back</button>
                </div>
                <img src="" alt="" id="shop-image" style="height: 300px; width: 300px; box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2); flex-shrink: 0; object-fit: cover;">
                <form action="../upload/image" method="POST" enctype="multipart/form-data" flex="v">
                    <input type="file" name="image-input" id="image-input" form-input style="width: 300px; background-color: #ccc">
                    <input type="hidden" value="SHOP" name="image-type" id="image-type">
                    <input type="hidden" value="" name="old-image-path" id="old-image-path">
                    <input type="hidden" value="<?php echo $_GET["id"]; ?>" name="id" id="shop-id">
                    <button type="submit" id="shop-image-upload" form-input button contain="info" small style="width: 300px; border-radius: var(--border-radius);">Upload photo</button>
                </form>
                <h1 nomargin>Edit "<span id="shop-name-display"></span>" Shop</h1>
                <form onsubmit="submitShop(); return false;" flex="v" contain="white" fullwidth style="padding: 2em;">
                    <div form-group>
                        <h3 nomargin>Shop Name</h3>
                        <input type="text" id="shop_name" form-input style="color: #333;" placeholder="Enter shop name">
                    </div>
                    <div form-group fullwidth>
                        <div flex="h" fullwidth h-end>
                            <button type="submit" contain="good" button small>Save Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="shop-id" style="display: none;"><?= $_GET["id"]; ?></div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>
        let shopId = document.querySelector("div#shop-id").innerText;
        let shopNameField = document.querySelector("#shop_name");
        let shopNameDisplay = document.querySelector("#shop-name-display");
        let imagePreview = document.querySelector("img#shop-image")

        setTimeout(() => {
            fetch(`../api/admin-shop?id=${shopId}`).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch (error) {
                    console.error(json);
                    return;
                }

                if (json["status"] !== 200) return;

                let shopData = json["rows"][0];

                let shopName = shopData["name"];
                let imageName = shopData["image_name"];
                let imagePath = "../" + shopData["image_path"];

                shopNameDisplay.innerText = shopName;
                shopNameField.value = shopName;
                imagePreview.src = imagePath;
                imagePreview.alt = imageName;
            });
        }, 10)


        function submitShop() {
            fetch("../api/admin/save-shop", {
                "method": "POST",
                "Content-Type": "application/json; utf-8",
                "body": JSON.stringify({
                    "name": shopNameField.value,
                    "id": shopId,
                }),
            }).then(response => response.text()).then(data => {
                setTimeout(() => {
                    window.location.reload();
                }, 10)
            })
        }
    </script>
</body>

</html>