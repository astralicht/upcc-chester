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

        th {
            text-align: left;
        }
    </style>
    <title>Order History | ISA Client</title>
</head>

<body>
    <div flex="h" nogap>
        <?php include_once("views/shared/client_nav.php"); ?>
        <div main back-light fullwidth flex="v">
            <?php include_once("views/shared/client_header_nav.php"); ?>
            <h1>Order History</h1>
            <div contain="white" fullwidth>
                <table id="orders-table" table>
                    <thead>
                        <th></th>
                        <th>Order #</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Status</th>
                    </thead>
                    <tbody></tbody>
                </table>
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


        fetchClientOrders();


        function fetchClientOrders() {
            clearTableBody(table_bodies["orders"]);

            let filter = null;

            setTimeout(() => {
                fetch(`../api/client/orders`).then(response => response.text()).then(json => {
                    try {
                        json = JSON.parse(json);
                    } catch {
                        return console.error(error);
                    }

                    if (json["status"] !== 200) return console.error(json);
                    if (json["rows"] === undefined) return;

                    printOrders(json);
                });
            }, 1);
        }


        function printOrders(json) {
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

                    if (key === "id") {
                        let a = document.createElement("a");

                        a.href = `../client/order?id=${row[key]}`;
                        a.innerText = "View Order";

                        td.appendChild(a);
                        tr.appendChild(td);
                        continue;
                    }

                    if (key === "status") {
                        let div = document.createElement("div");

                        div.innerText = row[key];

                        if (row[key] === "APPROVED") div.setAttribute("contain", "good");
                        if (row[key] === "DENIED") div.setAttribute("contain", "danger");
                        if (row[key] === "PENDING") div.setAttribute("contain", "secondary");
                        if (row[key] === "SHIPPED") div.setAttribute("contain", "warning");
                        if (row[key] === "DELIVERED") div.setAttribute("contain", "info");

                        div.setAttribute("small", "");
                        div.style.width = "100%";
                        div.style.textAlign = "center";

                        td.appendChild(div);
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