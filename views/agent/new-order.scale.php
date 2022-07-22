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
                    <div id="message-box" bordered fullwidth dark-text dark-text-all></div>
                    <div form-group>
                        <div flex="h" v-center>
                            <h3 nomargin>Client E-mail</h3>
                            <i style="color: red;">*Required</i>
                        </div>
                        <input type="email" id="user-email" form-input placeholder="Enter client e-mail here" required>
                    </div>


                    <div flex="h">
                        <div flex="v" style="width: 100%;">
                            <h3 nomargin>Products</h3>
                            <div flex="h" nogap>
                                <input type="text" id="search-input" placeholder="Search product # or name" form-input style="width: 100%; border-radius: var(--border-radius) 0 0 var(--border-radius)">
                                <div button contain="primary" style="border-radius: 0 var(--border-radius) var(--border-radius) 0; width: 100px; flex-shrink: 0;" onclick="searchProduct()">Search</div>
                            </div>
                            <div id="search-results" contain="white" nopadding style="width: 100%; height: 100%; overflow-y: auto;"></div>
                        </div>
                        <div flex="v" fullwidth>
                            <h3 nomargin>Selected Products</h3>
                            <div id="selected-products" contain="white" nopadding style="overflow-y: auto; width: 100%; height: 500px;"></div>
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
        let productIdsInput = {};

        fetchProducts("");

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
                let string = `<div class="card" flex="h" v-center id="prod-${row["id"]}" onclick="selectProduct(this)" style="padding-bottom: 0; padding-right: 1em; cursor: pointer;">
                                <img src="../{{product_img_path}}" class="card-img" loading="lazy" style="object-fit: cover; width: 100px; height: 100px;">
                                <div class="card-title" style="width: 100%;">#{{product_id}}: {{product_name}}</div>
                            </div>`;

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

            for (let child of CONTAINER.children) {
                if (child.id !== product.id) continue;

                ++child.querySelector("input#item-count").value;
                ++productIdsInput[product.id];

                return;
            }

            let productCopy = product.cloneNode(true);

            productCopy.removeAttribute("onclick");
            productCopy.style.width = "100%";

            productIdsInput[productCopy.id] = 1;

            productCopy.innerHTML += `<input type="number" step="1" id="item-count" value="0" placeholder="1" form-input style="width: 5em;">`;
            productCopy.innerHTML += `<div contain="danger" button style="width: 3em; height: 3em; border-radius: var(--border-radius);" flex="h" v-center onclick="removeProduct(this.parentNode)"><img src="../views/assets/img/trash-white.svg"></div>`;

            ++productCopy.querySelector("input#item-count").value;

            CONTAINER.appendChild(productCopy);
        }


        function removeProduct(product) {
            product.parentNode.removeChild(product);
        }


        function submitOrder() {
            let userEmailInput = document.querySelector("input#user-email");

            const FORM = document.querySelector("form#order-form");
            const MESSAGE_BOX = document.querySelector("#message-box");

            fetch("../api/create-order", {
                "method": "POST",
                "Content-Type": "application/json; charset=UTF-8",
                "body": JSON.stringify({
                    "user-email": userEmailInput.value,
                    "product-ids": productIdsInput
                }),
            }).then(response => response.text()).then(data => {
                try {
                    data = JSON.parse(data);
                } catch {
                    console.error(data);
                }

                if (data["status"] != 200) {
                    MESSAGE_BOX.setAttribute("contain", "danger");
                    MESSAGE_BOX.innerText = data["message"];
                    fadeInOut(MESSAGE_BOX);
                    return;
                }

                MESSAGE_BOX.setAttribute("contain", "good");
                MESSAGE_BOX.innerHTML = `Order created successfully`;

                fadeInOut(MESSAGE_BOX);

                FORM.reset();
            });

            document.querySelector("div#selected-products").innerHTML = "";
        }
    </script>
</body>

</html>