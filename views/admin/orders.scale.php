<?php
session_start();
if (!isset($_SESSION["type"])) header("Location: ../error/403");
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
    <title>Orders | UPCC Admin</title>
</head>

<body>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div main back-light fullwidth>
            <div flex="h">
                <h1>Orders</h1>
                <div flex="h" h-end fullwidth>
                    <div flex="v">
                        <h3 nomargin>Search</h3>
                        <div flex="h" v-center>
                            <input type="text" form-input box-shadow placeholder="Enter search here" id="search-input" onkeydown="fetchOrders()">
                            <div id="search-button" flex="h" v-center onclick="fetchOrders()">
                                <img src="../api/assets/img?name=search.webp&type=webp" alt="search" style="height: 2em; width: 2em;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div flex="v">
                <div flex="h">
                    <div contain="primary" button small style="border-radius: 5px;">Edit</div>
                    <div contain="danger" button small style="border-radius: 5px;">Delete</div>
                </div>
                <div flex="v">
                    <div id="orders-page-controls" h-end fullwidth contain="white" small flex="h">
                        <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" 
                            small flex="h" h-center id="prev-page"> < </div>
                        <div contain="secondary" style="width: 150px; border-radius: var(--border-radius);" small flex="h" h-center id="pages-display">1 of 1</div>
                        <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" 
                            small flex="h" h-center id="next-page"> > </div>
                    </div>
                    <table table id='orders-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                        <thead style="border-bottom: 1px solid #E5E5E5;">
                            <th></th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Brand</th>
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
            }
        };
        var table_bodies = {
            "orders": document.querySelector("#orders-table tbody"),
        };

        fetchOrders(pages["orders"]);
        fetchTotalOrdersCount();


        function fetchOrders(orders_page) {
            clearTableBody(table_bodies["orders"]);
            orders_page = 0;

            let filter = null;

            setTimeout(() => {
                filter = document.querySelector("#search-input").value;

                fetch(`../api/orders?filter=${filter}&page=${orders_page}&limit=${LIMIT}`).then(response => response.json()).then(json => {
                    if (json["status"] !== 200) console.error(json);
                    if (json["rows"] === undefined) return;

                    printOrdersToTable(json);
                });
            }, 1);
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
                    td.innerText = row[key];

                    if (key === "id") {
                        td.innerHTML = `<input type='checkbox' value='${row[key]}'>`;
                    }

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

            controls["previous"].onclick = () => {
                previousOrdersTablePage()
            };
            controls["next"].onclick = () => {
                nextOrdersTablePage(total_pages)
            };

            controls.innerText = `Page ${pages["orders"]+1} of ${total_pages}`;
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
    </script>
</body>

</html>