<?php
session_start();
if (!isset($_SESSION["type"])) header("Location: ../error/403");
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

        th {
            text-align: left;
        }
    </style>
    <title>Order History | UPCC Client</title>
</head>

<body>
    <div flex="h" nogap>
        <?php include_once("views/shared/client_nav.php"); ?>
        <div main back-light fullwidth flex="v">
            <h1>Order History</h1>
            <div contain="white" fullwidth>
                <table id="order-products-table" table>
                    <thead>
                        <th>Product #</th>
                        <th>Name</th>
                        <th></th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="order-id" style="display: none;"><?php echo $_GET["id"]; ?></div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>
        var table_bodies = {
            "order-products": document.querySelector("#order-products-table tbody"),
        };


        fetchOrders();


        function fetchOrders() {
            let filter = null;
            let timeout = 10;
            const ORDER_ID = document.querySelector("#order-id").innerText;

            setTimeout(() => {
                clearTableBody(table_bodies["order-products"]);

                fetch(`../api/order?id=${ORDER_ID}`).then(response => response.text()).then(json => {
                    try {
                        json = JSON.parse(json);
                    } catch (error) {
                        console.error(error);
                    }

                    if (json["status"] !== 200) console.error(json);
                    if (json["rows"] === undefined) return;

                    printOrderProductsToTable(json);
                });
            }, timeout);
        }


        function printOrderProductsToTable(json) {
            const TBODY = table_bodies["order-products"];
            let rows = json["rows"];

            if (rows.length === 0) {
                TBODY.innerHTML = "<div contain='white' noshadow><i>No records to display.</i></div>";
                return;
            }

            for (let row of rows) {
                let tr = document.createElement("tr");
                let keys = Object.keys(row);

                for (let key of keys) {
                    let td = document.createElement("td");

                    if (key === "product_id") {
                        let a = document.createElement("a");

                        a.href = `../store/viewproduct?id=${row[key]}`;
                        a.innerText = "View in store";

                        td.appendChild(a);
                        tr.appendChild(td);
                        continue;
                    }

                    td.innerText = row[key];
                    tr.appendChild(td);
                }

                TBODY.appendChild(tr);
            }
        }


        function clearTableBody(tbody) {
            tbody.innerHTML = "";
            return tbody;
        }
    </script>
</body>

</html>