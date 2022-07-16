<?php
session_start();
if (!isset($_SESSION["type"]) || $_SESSION["type"] !== "AGENT") header("Location: ../error/403");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        :root {
            --card-width: 100%;
        }

        #message-box {
            display: none;
            opacity: 0;
            transition: opacity .15s;
        }

        .card {
            width: var(--card-width);
            gap: 1em;
            text-decoration: none;
            display: flex;
        }

        .card:hover {
            box-shadow: 0 0 6px rgba(0, 0, 0, .3);
        }

        .card .card-img {
            width: var(--card-width);
            height: var(--card-width);
        }

        .card .card-title {
            display: block;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0;
            height: auto;
            width: auto;
        }

        .card .card-body {
            padding: 0 1em;
        }

        .card .card-price {
            color: #ed7d61;
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
                <form flex="v" onsubmit="submitOrder(); return false;" id="order-form">
                    <input type="hidden" id="product-ids">
                    <div id="message-box" bordered fullwidth dark-text dark-text-all></div>
                    <div form-group>
                        <div flex="h" v-center>
                            <h3 nomargin>Client User #</h3>
                            <i style="color: red;">*Required</i>
                        </div>
                        <input type="number" id="user-id" form-input placeholder="Enter user # here" required>
                    </div>


                    <div flex="h">
                        <div flex="v" fullwidth>
                            <h3 nomargin>Products</h3>
                            <div flex="h" nogap>
                                <input type="text" id="search-input" placeholder="Search product # or name" form-input style="width: 300px; border-radius: var(--border-radius) 0 0 var(--border-radius)">
                                <div button contain="primary" style="border-radius: 0 var(--border-radius) var(--border-radius) 0; width: 100px;" onclick="searchProduct()">Search</div>
                            </div>
                            <div id="search-results" contain="white" nopadding style="width: 400px; height: 400px; overflow-y: auto; overflow-x: hidden;"></div>
                        </div>
                        <div flex="v" fullwidth>
                            <h4 nomargin>Selected Products</h4>
                            <div id="selected-products" contain="white" nopadding style="overflow-y: auto; width: 100%;"></div>
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


        function searchProduct() {
            filter = document.querySelector("input#search-input").value;
            fetchProducts(filter);
        }


        function fetchProducts(filter) {
            let container = document.querySelector("div#search-results");

            clearContainer(container);

            fetch(`../api/products?filter=${filter}`).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch {
                    console.error(json);
                    return;
                }

                if (json["status"] !== 200) console.error(json);
                if (json["rows"] === undefined) return;

                printProductsToContainer(json);
            });
        }


        function clearContainer(CONTAINER) {
            CONTAINER.innerHTML = "";
            return CONTAINER;
        }


        function printProductsToContainer(json) {
            const CONTAINER = document.querySelector("div#search-results");
            let rows = json["rows"];

            for (let row of rows) {
                let div = document.createElement("div");
                let string = `<a href="#" class="card" flex="h" v-center id="${row["id"]}" onclick="selectProduct(this)" style="padding-bottom: 0;">
                        <img src="../{{product_img_path}}" class="card-img" loading="lazy" style="object-fit: cover; width: 100px; height: 100px;">
                        <div class="card-title">#{{product_id}}: {{product_name}}</div>
                    </a>`;

                string = string.replace("{{product_id}}", row["id"]);
                string = string.replace("{{product_img_path}}", row["image_path"]);
                string = string.replace("{{product_id}}", row["id"]);
                string = string.replace("{{product_name}}", row["name"]);

                div.innerHTML = string;

                CONTAINER.appendChild(div);
            }
        }


        function selectProduct(product) {
            const CONTAINER = document.querySelector("div#selected-products");

            product.removeAttribute("onclick");
            product.style.width = "100%";

            let productIdsInput = document.querySelector("input#product-ids");
            productIdsInput.value += product.id + " ";

            CONTAINER.appendChild(product);
        }


        function submitOrder() {
            let userIdInput = document.querySelector("input#user-id");
            let productIdsInput = document.querySelector("input#product-ids");
            const FORM = document.querySelector("form#order-form");
            const MESSAGE_BOX = document.querySelector("#message-box");

            fetch("../api/create-order", {
                "method": "POST",
                "Content-Type": "application/json; charset=UTF-8",
                "body": JSON.stringify({"user-id": userIdInput.value, "product-ids": productIdsInput.value}),
            }).then(response => response.text()).then(data => {
                try {
                    data = JSON.parse(data);
                } catch (error) {
                    console.error(data);
                }

                if (data["status"] != 200) {
                    MESSAGE_BOX.setAttribute("contain", "danger");
                    MESSAGE_BOX.innerText = data["message"];
                    fadeInOut(MESSAGE_BOX);
                    return;
                }

                MESSAGE_BOX.setAttribute("contain", "good");
                MESSAGE_BOX.innerHTML = `Order <i>"${inputs["name"]}"</i> created successfully`;
                fadeInOut(MESSAGE_BOX);
                FORM.reset();
            });
        }
    </script>
</body>

</html>