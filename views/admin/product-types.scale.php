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

        #product-types-table tr:nth-child(even) {
            background-color: #E5E5E5;
        }
    </style>
    <title>Products | UPCC Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/admin_header_nav.php"); ?>
            <div main>
                <div flex="h">
                    <div flex="h" v-center fullwidth>
                        <h1>Product Types</h1>
                        <a href="../admin/new-product-type" contain="good" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/add.svg" alt=""></a>
                    </div>
                    <div flex="h" h-end fullwidth>
                        <div flex="v">
                            <h3 nomargin>Search</h3>
                            <div flex="h" v-center>
                                <input type="text" form-input box-shadow placeholder="Enter search here" id="search-input" onkeydown="fetchProductTypes()">
                                <div id="search-button" flex="h" v-center onclick="fetchProductTypes()">
                                    <img src="../views/assets/img/search.svg" alt="search" style="height: 2em; width: 2em;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div flex="v">
                    <div flex="h">
                        <div contain="primary" button small style="border-radius: 5px; display: none;" id="edit-button" onclick="editProductType()">Edit</div>
                        <div contain="danger" button small style="border-radius: 5px; display: none;" id="delete-button" onclick="deleteProductTypes()">Delete</div>
                    </div>
                    <div id="message" contain="danger" bordered dark-text style="display: none; opacity: 0;"></div>
                    <div flex="v">
                        <div id="product-types-page-controls" h-end fullwidth contain="white" small flex="h">
                            <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="prev-page">
                                < </div>
                                    <div contain="secondary" style="width: 150px; border-radius: var(--border-radius);" small flex="h" h-center id="pages-display">1 of 1</div>
                                    <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="next-page"> > </div>
                            </div>
                        </div>
                        <table table id='product-types-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                            <thead style="border-bottom: 1px solid #E5E5E5;">
                                <th></th>
                                <th>Name</th>
                                <th>Description</th>
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
                "product-types": 0,
            };
            var page_controls = {
                "product-types": {
                    "next": document.querySelector("#next-page"),
                    "previous": document.querySelector("#prev-page"),
                }
            };
            var table_bodies = {
                "product-types": document.querySelector("#product-types-table tbody"),
            };

            fetchProductTypes(pages["product-types"]);
            fetchTotalProductTypesCount();


            function fetchProductTypes(product_types_page) {
                clearTableBody(table_bodies["product-types"]);

                let filter = null;

                setTimeout(() => {
                    filter = document.querySelector("#search-input").value;

                    fetch(`../api/product-types?filter=${filter}&page=${product_types_page}&limit=${LIMIT}`).then(response => response.json()).then(json => {
                        if (json["status"] !== 200) console.error(json);
                        if (json["rows"] === undefined) return;

                        printProductTypesToTable(json);
                    });
                }, 1);
            }


            function printProductTypesToTable(json) {
                const TBODY = table_bodies["product-types"];
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
                            td.innerHTML = `<input type='checkbox' value='${row[key]}' onclick='checkTickedBoxes()'>`;
                        }

                        tr.appendChild(td);
                    }

                    TBODY.appendChild(tr);
                }
            }


            function fetchTotalProductTypesCount() {
                fetch("../api/product-types/count").then(response => response.json()).then(data => {
                    printProductTypesPages(data);
                });
            }


            function printProductTypesPages(data) {
                let controls = page_controls["product-types"];
                let total_count = 0;
                let total_pages = parseInt(total_count / LIMIT);
                let rows = data["rows"];

                if (rows == undefined) total_count = 0;
                else total_count = rows[0]["product-types_count"];

                controls["previous"].onclick = () => {
                    previousProductsTablePage()
                };
                controls["next"].onclick = () => {
                    nextProductTypesTablePage(total_pages)
                };

                controls.innerText = `Page ${pages["product-types"]+1} of ${total_pages}`;
            }


            function nextProductTypesTablePage(total_pages) {
                if (pages["product-types"] + 1 >= total_pages) return;

                let tbody = table_bodies["product-types"];
                tbody = clearTableBody(tbody);
                ++pages["product-types"];

                fetchProductTypes(pages["product-types"]);
                fetchTotalProductTypesCount();
            }


            function previousProductsTablePage() {
                if (pages["product-types"] - 1 < 0) return;

                let tbody = table_bodies["product-types"];
                tbody = clearTableBody(tbody);
                --pages["product-types"];

                fetchProductTypes(pages["product-types"]);
                fetchTotalProductTypesCount();
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


            function deleteProductTypes() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                let product_type_ids = [];

                for (let index = 0; index < tickedBoxes.length; index++) {
                    product_type_ids.push(tickedBoxes[index].value);
                }

                fetch("../api/remove-product-types", {
                    "method": "POST",
                    "Content-Type": "application/json",
                    "body": JSON.stringify(product_type_ids),
                }).then(response => response.text()).then(data => {
                    try {
                        data = JSON.parse(data);
                    } catch (error) {
                        console.error(error);
                    }
                    
                    if (data["status"] !== 200) return console.error(data["message"]);

                    let tbody = table_bodies["product-types"];
                    tbody = clearTableBody(tbody);

                    fetchProductTypes(pages["product-types"]);
                    fetchTotalProductTypesCount();

                    document.querySelector("#edit-button").style.display = "none";
                    document.querySelector("#delete-button").style.display = "none";

                    let message = document.querySelector("div#message");
                    message.innerText = "Product type(s) removed successfully!";
                    fadeIn(message);
                    setTimeout(() => {
                        fadeOut(message);
                    }, 5150);
                });
            }
        </script>
</body>

</html>