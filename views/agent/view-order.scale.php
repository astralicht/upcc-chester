<?php
session_start();
if (!isset($_SESSION["type"]) && $_SESSION["type"] !== "AGENT") header("Location: ../error/403");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        #search-button {
            padding: 0 .3em;
            border-radius: 5px;
            cursor: pointer;
            height: 100%;
        }

        #search-button:hover {
            background-color: rgba(0, 0, 0, .3);
        }

        #orders-table tr:nth-child(even) {
            background-color: #E5E5E5;
        }
    </style>
    <title>Orders | UPCC Agent</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/agent_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/admin_header_nav.php"); ?>
            <div main flex="v">
                <div>
                    <button button contain="secondary" small onclick="history.back()">Back</button>
                </div>
                <div flex="h">
                    <div flex="h" v-center>
                        <div id="order-id" style="display: none;"><?php echo $_GET["order_id"] ?></div>
                        <h1 style="flex-shrink: 0;">Order #<?php echo $_GET["order_id"] ?></h1>
                    </div>
                </div>
                <div flex="v">
                    <div flex="v">
                        <table table id='orders-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                            <thead style="border-bottom: 1px solid #E5E5E5;">
                                <th>Product ID</th>
                                <th>Product Name</th>
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
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>
        var table_bodies = {
            "orders": document.querySelector("#orders-table tbody"),
        };


        fetchOrders();


        function fetchOrders() {
            let filter = null;
            let timeout = 10;
            const ORDER_ID = document.querySelector("#order-id").innerText;

            setTimeout(() => {
                clearTableBody(table_bodies["orders"]);

                fetch(`../api/order?id=${ORDER_ID}`).then(response => response.text()).then(json => {
                    try {
                        json = JSON.parse(json);
                    } catch (error) {
                        console.error(error);
                    }

                    if (json["status"] !== 200) console.error(json);
                    if (json["rows"] === undefined) return;

                    printOrdersToTable(json);
                });
            }, timeout);
        }


        function printOrdersToTable(json) {
            const TBODY = table_bodies["orders"];
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