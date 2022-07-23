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

        tr {
            width: 100%;
            max-height: 150px;
        }

        th {
            text-align: left;
        }

        td {
            max-height: 150px;
            height: 150px;
        }

        td#img {
            padding: 0;
            width: 150px;
            max-width: 150px;
        }
    </style>
    <title>Cart | UPCC Client</title>
</head>

<body>
    <div flex="h" nogap>
        <?php include_once("views/shared/client_nav.php"); ?>
        <div style="display: none" id="user-id"><?php echo $_SESSION["id"]; ?></div>
        <div main back-light fullwidth flex="v">
            <?php include_once("views/shared/client_header_nav.php"); ?>
            <h1>Your Cart</h1>
            <table id="cart-table" table contain="white" style="width: 100%;">
                <tbody></tbody>
            </table>

            <div contain="white" fullwidth flex="h">
                <div style="flex-shrink: 0;">Total — <h3 id="total-price" style="color: #ed7d61; display: inline-block;">₱0.00</h3>
                </div>
                <div flex="h" h-end style="flex-grow: 1;">
                    <button onclick="checkoutCart()" button contain="info">Checkout</button>
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
        let userId = document.querySelector("#user-id").innerText;

        fetch(`../api/client/cart?client_id=${userId}`).then(response => response.json()).then(json => {
            if (json["status"] != 200) return console.error(json);

            let data = json["rows"];
            const CART_TBODY = document.querySelector("#cart-table tbody");

            if (data.length < 1) {
                let div = document.createElement("div");

                div.innerHTML = "<i>Your cart is empty!<i>";
                div.setAttribute("contain", "overlight");
                CART_TBODY.appendChild(div);
                return;
            }

            rows = buildCartRows(data);
            printCartRows(CART_TBODY, rows);
        }).catch(error => console.error(error));


        function buildCartRows(data) {
            let cart = [];

            for (let index = 0; index < data.length; index++) {
                const DATA_KEYS = Object.keys(data[index]);
                let row = {};

                for (let dataKey of DATA_KEYS) row[dataKey] = data[index][dataKey];

                cart.push(row);
            }

            return cart;
        }


        function printCartRows(CART_TBODY, rows) {
            let totalPrice = 0.0;
            let cartItemId = null;

            for (let row of rows) {
                let tr = document.createElement("tr");
                let quantity = 0;
                let unitPrice = 0.0;

                for (let key in row) {
                    let td = document.createElement("td");

                    if (key === "id") {
                        cartItemId = row[key];
                        continue;
                    }
                    if (key === "product_quantity") quantity = row[key];
                    if (key === "unit_price") {
                        unitPrice = row[key];

                        let text = document.createElement("span");
                        text.style.color = "#C0C0C0";
                        text.innerText = "/order";

                        td.innerText = `₱${numberWithCommas(unitPrice)}`;
                        td.appendChild(text);
                        tr.appendChild(td);
                        continue;
                    }
                    if (key === "image_path") {
                        let img = document.createElement("img");

                        img.src = `../${row[key]}`;
                        img.style.height = "150px";
                        img.style.width = "150px";

                        td.style.backgroundColor = "#F5F5F5";
                        td.id = "img";

                        td.appendChild(img);
                        tr.appendChild(td);
                        continue;
                    }

                    let div = document.createElement("div");
                    div.innerText = row[key];

                    td.appendChild(div);
                    tr.appendChild(td);
                }

                let td = document.createElement("td");
                let subtotal = quantity * unitPrice;

                totalPrice += subtotal;
                td.innerText = `₱${numberWithCommas((subtotal).toFixed(2))}`;
                td.style.color = "#ed7d61";
                tr.appendChild(td);

                td = document.createElement("td");
                let a = document.createElement("a");
                let img = document.createElement("img");

                img.src = "../views/assets/img/trash-white.svg";

                a.href = `../api/client/remove-from-cart?id=${cartItemId}`;
                a.appendChild(img);
                a.setAttribute("contain", "danger");
                a.setAttribute("button", "");
                a.setAttribute("noshadow", "");
                a.style.borderRadius = "var(--border-radius)";
                a.style.width = "fit-content";

                td.appendChild(a);
                td.style.display = "flex";
                td.style.justifyContent = "center";
                td.style.alignItems = "center";
                td.style.height = "150px";

                tr.appendChild(td);

                CART_TBODY.appendChild(tr);
            }

            let totalPriceContainer = document.querySelector("#total-price");
            totalPriceContainer.innerText = `₱${numberWithCommas(totalPrice.toFixed(2))}`;
        }


        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }


        function checkoutCart() {
            
        }
    </script>
</body>

</html>