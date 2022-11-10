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
    </style>
    <title>Orders | ISA Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/admin_header_nav.php"); ?>
            <div main>
                <div flex="h" flex="v">
                    <div flex="h" v-center>
                        <h1>Orders</h1>
                    </div>
                    <div flex="h" h-end fullwidth>
                        <div flex="v">
                            <h3 nomargin>Search</h3>
                            <div flex="h" v-center>
                                <input type="text" form-input box-shadow placeholder="Enter search here" id="search-input" onkeyup="fetchOrders(pages['orders'])">
                                <div id="search-button" flex="h" v-center onclick="fetchOrders()">
                                    <img src="../views/assets/img/search.svg" alt="search" style="height: 2em; width: 2em;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div flex="v">
                    <div flex="h">
                        <div contain="primary" button small style="border-radius: 5px; display: none;" id="edit-button" onclick="editProduct()">Edit</div>
                        <div contain="danger" button small style="border-radius: 5px; display: none;" id="delete-button" onclick="deleteProducts()">Delete</div>
                    </div>
                    <div flex="v">
                        <div id="orders-page-controls" h-end fullwidth contain="white" small flex="h">
                            <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="prev-page">
                                < </div>
                                    <div contain="secondary" style="width: 150px; border-radius: var(--border-radius);" small flex="h" h-center id="pages-display">1 of 1</div>
                                    <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="next-page"> > </div>
                            </div>
                        </div>
                        <table table id='orders-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                            <thead style="border-bottom: 1px solid #E5E5E5;">
                                <th></th>
                                <th>Order #</th>
                                <th>Client Name</th>
                                <th># of Items</th>
                                <th>Total Price</th>
                                <th></th>
                                <th>Status</th>
                                <th>Date Created</th>
                            </thead>
                            <tbody></tbody>
                        </table>
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
            const LIMIT = 25;
            var pages = {
                "orders": 0,
            };
            var page_controls = {
                "orders": {
                    "next": document.querySelector("#next-page"),
                    "previous": document.querySelector("#prev-page"),
                    "label": document.querySelector("#pages-display"),
                }
            };
            var table_bodies = {
                "orders": document.querySelector("#orders-table tbody"),
            };

            fetchOrders(pages["orders"]);
            fetchTotalOrdersCount();


            function fetchOrders(orders_page) {
                let filter = null;
                let timeout = 10;

                setTimeout(() => {
                    clearTableBody(table_bodies["orders"]);
                    filter = document.querySelector("#search-input").value;

                    fetch(`../api/orders?filter=${filter}&page=${orders_page}&limit=${LIMIT}`).then(response => response.text()).then(json => {
                        try {
                            json = JSON.parse(json);
                        } catch (error) {
                            console.error(json);
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

                        if (key === "id") {
                            td.innerHTML = `<input type='checkbox' value='${row[key]}' onclick='checkTickedBoxes()'>`;
                            tr.appendChild(td);
                            continue;
                        }
                        if (key === "order_id_redr") {
                            let a = document.createElement("a");
                            a.href = `../admin/view-order?order_id=${row[key]}`;
                            a.innerText = "View Order";
                            td.appendChild(a);
                            tr.appendChild(td);
                            continue;
                        }
                        if (key === "status") {
                            let div = document.createElement("div");
                            div.innerText = row[key];

                            div.style.textAlign = "center";
                            div.setAttribute("small", "");
                            div.setAttribute("fullwidth", "");
                            div.setAttribute("contain", "secondary");

                            if (row[key] === "APPROVED") div.setAttribute("contain", "warning");
                            if (row[key] === "DENIED") div.setAttribute("contain", "danger");
                            if (row[key] === "SHIPPED") div.setAttribute("contain", "warning");
                            if (row[key] === "DELIVERED") div.setAttribute("contain", "good");

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


            function fetchTotalOrdersCount() {
                fetch("../api/orders/count").then(response => response.json()).then(data => {
                    printOrdersPages(data);
                });
            }


            function printOrdersPages(data) {
                let controls = page_controls["orders"];
                let total_count = data["rows"][0]["orders_count"];
                let total_pages = parseInt(total_count / LIMIT);

                if (total_pages < 1) total_pages = 1;

                controls["previous"].onclick = () => {
                    previousOrdersTablePage()
                };
                controls["next"].onclick = () => {
                    nextOrdersTablePage(total_pages)
                };

                controls["label"].innerText = `Page ${pages["orders"]+1} of ${total_pages}`;
            }


            function nextOrdersTablePage(total_pages) {
                if (pages["orders"] + 1 >= total_pages) return;

                let tbody = table_bodies["orders"];
                tbody = clearTableBody(tbody);
                ++pages["orders"];

                fetchOrders(pages["orders"]);
                fetchTotalOrdersCount();
            }


            function previousOrdersTablePage() {
                if (pages["orders"] - 1 < 0) return;

                let tbody = table_bodies["orders"];
                tbody = clearTableBody(tbody);
                --pages["orders"];

                fetchOrders(pages["orders"]);
                fetchTotalOrdersCount();
            }


            function clearTableBody(tbody) {
                tbody.innerHTML = "";
                return tbody;
            }

            function checkTickedBoxes() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                if (tickedBoxes.length === 0) {
                    document.querySelector("#edit-button").style.display = "none";
                    document.querySelector("#delete-button").style.display = "none";
                    return;
                }

                if (tickedBoxes.length < 2) {
                    document.querySelector("#edit-button").style.display = "block";
                    document.querySelector("#delete-button").style.display = "block";
                    return;
                }

                if (tickedBoxes.length > 1) {
                    document.querySelector("#edit-button").style.display = "none";
                    document.querySelector("#delete-button").style.display = "block";
                    return;
                }

                document.querySelector("#edit-button").style.display = "none";
                document.querySelector("#delete-button").style.display = "none";
            }
        </script>
</body>

</html>