<?php
session_start();
if (!isset($_SESSION["type"]) || $_SESSION["type"] !== "ADMIN") header("Location: ../error/403");
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

        #deny-popup-container,
        #approve-popup-container {
            height: 100vh;
            width: 100vw;
            backdrop-filter: blur(3px);
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            display: none;
            opacity: 0;
            transition: opacity .15s ease-in-out;
            background-color: rgba(0, 0, 0, .1);
        }

        #deny-popup,
        #approve-popup {
            display: block;
            margin: 0;
            height: auto;
            width: 700px;
            background-color: white;
            box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2);
        }
    </style>
    <title>View Order #<?php echo $_GET["order_id"]; ?> | ISA Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/admin_header_nav.php"); ?>
            <div main flex="v">
                <button button contain="secondary" small onclick="history.back()">Back</button>
                <div flex="h" v-center>
                    <div id="order-id" style="display: none;"><?php echo $_GET["order_id"] ?></div>
                    <h1 style="flex-shrink: 0;">Order #<?php echo $_GET["order_id"] ?></h1>
                    <div id="status-circle" contain="secondary" style="border-radius: 50px; padding: .5em 1em;" small>PENDING</div>
                </div>
                <div flex="v">
                    <table table id='orders-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                        <thead style="border-bottom: 1px solid #E5E5E5;">
                            <th>Product #</th>
                            <th>Product Name</th>
                            <th></th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div flex="h" fullwidth h-end>
                    <button contain="danger" button style="width: 200px;" onclick="denyOrder()">Deny Order</button>
                    <button contain="good" button style="width: 200px;" onclick="approveOrder()">Approve Order</button>
                </div>
            </div>
        </div>
        <div id="deny-popup-container" style="flex-shrink: 0;">
            <div id="deny-popup" flex="v" style="flex-shrink: 0;">
                <div flex="h" h-end>
                    <div style="height: 50px; width: 50px; background-color: #333; cursor: pointer;" flex="h" h-center v-center>
                        <img src="../api/assets/img?name=close.webp&type=webp" alt="close" onclick="hideConfirmation()">
                    </div>
                </div>
                <div flex="v" style="padding: 1em 2em;" h-center>
                    <div>
                        <h3 id="product_name" nomargin>Are you sure you want to <span style="color: red">deny</span> this order?</h3>
                    </div>
                    <div flex="h">
                        <button onclick="hideConfirmation()" contain="secondary" button>Cancel</button>
                        <button onclick="confirmOption('DENIED')" contain="danger" button>Deny Order</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="approve-popup-container" style="flex-shrink: 0;">
            <div id="approve-popup" flex="v" style="flex-shrink: 0;">
                <div flex="h" h-end>
                    <div style="height: 50px; width: 50px; background-color: #333; cursor: pointer;" flex="h" h-center v-center>
                        <img src="../api/assets/img?name=close.webp&type=webp" alt="close" onclick="hideConfirmation()">
                    </div>
                </div>
                <div flex="v" style="padding: 1em 2em;" h-center>
                    <div>
                        <h3 id="product_name" nomargin>Are you sure you want to <span style="color: green">approve</span> this order?</h3>
                    </div>
                    <div flex="h">
                        <button onclick="hideConfirmation()" contain="secondary" button>Cancel</button>
                        <button onclick="confirmOption('APPROVED')" contain="good" button>Approve Order</button>
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

                    if (key === "status") {
                        let statusCircle = document.querySelector("div#status-circle");

                        if (row[key] === "DENIED") {
                            statusCircle.setAttribute("contain", "danger");
                            statusCircle.innerText = row[key];
                        }
                        if (row[key] === "APPROVED") {
                            statusCircle.setAttribute("contain", "good");
                            statusCircle.innerText = row[key];
                        }

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


        function denyOrder() {
            const deny_popup = document.querySelector("#deny-popup-container");
            fadeInFlex(deny_popup);
        }


        function approveOrder() {
            const approve_popup = document.querySelector("#approve-popup-container");
            fadeInFlex(approve_popup);
        }


        function hideConfirmation() {
            const deny_popup = document.querySelector("#deny-popup-container");
            const approve_popup = document.querySelector("#approve-popup-container");

            fadeOut(deny_popup);
            fadeOut(approve_popup);
        }


        function confirmOption(option) {
            const ORDER_ID = document.querySelector("#order-id").innerText;

            fetch(`../api/admin/update-order-status`, {
                "method": "POST",
                "Content-Type": "application/json; utf-8",
                "body": JSON.stringify({
                    "order_id": ORDER_ID,
                    "status": option,
                }),
            }).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch (error) {
                    console.error(error);
                    return;
                }

                if (json["status"] !== 200) return console.error(json["message"]);

                window.location.reload();
            });
        }
    </script>
</body>

</html>