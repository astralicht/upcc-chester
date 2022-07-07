<?php
session_start();
if (!isset($_SESSION["type"])) header("Location: ../error/403");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        #message-box {
            display: none;
            opacity: 0;
            transition: opacity .15s;
        }
    </style>
    <title>New Order | UPCC Agent</title>
</head>

<body back-light>
    <div flex="h">
        <?php include_once("views/shared/agent_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <div main flex="v">
                <div flex="h" v-center>
                    <button onclick="history.back()" contain="secondary" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/arrow-right.webp" style="transform: rotate(180deg);" alt=""></button>
                    <h1>New Order</h1>
                </div>
                <form flex="v" onsubmit="submitProductType(); return false;">
                    <div id="message-box" bordered fullwidth dark-text dark-text-all></div>
                    <div form-group>
                        <div flex="h" v-center>
                            <h3 nomargin>Client Email</h3>
                            <i style="color: red;">*Required</i>
                        </div>
                        <input type="email" id="email" form-input placeholder="Enter email here" required>
                    </div>
                    <div form-group>
                        <h3 nomargin>Products</h3>
                        <div flex="h">
                            <input type="text" id="search-product" placeholder="Search product # or name" form-input style="width: 300px;">
                            <button button contain="primary" style="width: 130px; padding: .5em 1em;" flex="h" nogap v-center><img src="../views/assets/img/add.svg" alt="add">Product</button>
                        </div>
                    </div>
                    <div flex="h" h-end>
                        <button type="submit" contain="good" button>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>
        function fetchProductsWithFilter() {
            let filter = document.querySelector("input#search-product");
            fetch(`../api/agent/products-for-select?filter=${filter}`).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch (error) {
                    console.error(error);
                }

                if (json["status"] !== 200) console.error(json);
                if (json["rows"] === undefined) return;

                populateProductsSelect(json["rows"]);
            });
        }


        function populateProductsSelect(rows) {
            const PRODUCTS_SELECT = document.querySelector("select#products");

            PRODUCTS_SELECT.innerHTML = "";

            for (let row of rows) {
                let option = document.createElement("option");

                option.value = row["id"];
                option.innerText = row["name"];

                PRODUCTS_SELECT.appendChild(option);
            }
        }


        function submitProductType() {
            const FORM = document.querySelector("form");
            const NAME = document.querySelector("input#name");
            const DESCRIPTION = document.querySelector("textarea#description");
            const MESSAGE_BOX = document.querySelector("#message-box");
            let inputs = {
                "name": NAME.value,
                "description": DESCRIPTION.value,
            };

            fetch("../api/create-product-type", {
                "method": "POST",
                "Content-Type": "application/json; charset=UTF-8",
                "body": JSON.stringify(inputs),
            }).then(response => response.text()).then(data => {
                try {
                    data = JSON.parse(data);
                } catch (error) {
                    console.error(error);
                    return;
                }

                if (data["status"] !== 200) {
                    MESSAGE_BOX.setAttribute("contain", "danger");
                    MESSAGE_BOX.innerText = data["message"];
                    fadeInOut(MESSAGE_BOX);
                    return;
                }

                MESSAGE_BOX.setAttribute("contain", "good");
                MESSAGE_BOX.innerHTML = `Product type <i>"${inputs["name"]}"</i> created successfully`;
                fadeInOut(MESSAGE_BOX);
                FORM.reset();
            });
        }
    </script>
</body>

</html>