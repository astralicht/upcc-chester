<?php
session_start();
if (!isset($_SESSION["type"]) || $_SESSION["type"] !== "SHOP-ADMIN") header("Location: ../error/403");
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

        #products-table tr:nth-child(even) {
            background-color: #E5E5E5;
        }
    </style>
    <title>Shop Products | ISA Shop Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/shop_admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/shop_admin_header.php"); ?>
            <div main>
                <div flex="h">
                    <div flex="h" v-center>
                        <h1>Shop Products</h1>

                        <input type="hidden" id="shop_id" value="<?php echo $_SESSION["shop_id"]; ?>">

                        <a href="../shop-admin/new-product" contain="good" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/add.svg" alt=""></a>
                    </div>
                    <div flex="h" h-end fullwidth>
                        <div flex="v">
                            <h3 nomargin>Search</h3>
                            <div flex="h" v-center>
                                <input type="text" form-input box-shadow placeholder="Enter search here" id="search-input" onkeydown="fetchProducts()">
                                <div id="search-button" flex="h" v-center onclick="fetchProducts()">
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
                    <div id="message" contain="danger" bordered dark-text style="display: none; opacity: 0;"></div>
                    <div flex="v">
                        <div id="products-page-controls" h-end fullwidth contain="white" small flex="h">
                            <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="prev-page">
                                < </div>
                                    <div contain="secondary" style="width: 150px; border-radius: var(--border-radius);" small flex="h" h-center id="pages-display">1 of 1</div>
                                    <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="next-page"> > </div>
                            </div>
                        </div>
                        <table table id='products-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                            <thead style="border-bottom: 1px solid #E5E5E5;">
                                <th></th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Brand</th>
                                <th>Unit Price</th>
                                <th>Image Path</th>
                                <th>Image Name</th>
                                <th>Date Added</th>
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
                "products": 0,
            };
            var page_controls = {
                "products": {
                    "next": document.querySelector("#next-page"),
                    "previous": document.querySelector("#prev-page"),
                }
            };
            var table_bodies = {
                "products": document.querySelector("#products-table tbody"),
            };

            fetchProducts(pages["products"]);
            fetchTotalProductsCount();


            function fetchProducts(products_page) {
                clearTableBody(table_bodies["products"]);
                products_page = 0;

                let filter = null;
                let brand = null;
                let type = null;
                let page = pages["products"];

                setTimeout(() => {
                    filter = document.querySelector("#search-input").value;

                    fetch(`../api/products?filter=${filter}&brand=${brand}&typeid=${type}&page=${page}&limit=${LIMIT}`).then(response => response.json()).then(json => {
                        if (json["status"] !== 200) console.error(json);
                        if (json["rows"] === undefined) return;

                        printProductsToTable(json);
                    });
                }, 1);
            }


            function printProductsToTable(json) {
                const TBODY = table_bodies["products"];
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


            function fetchTotalProductsCount() {
                fetch("../api/products/count?shop-id=").then(response => response.json()).then(data => {
                    printProductsPages(data);
                });
            }


            function printProductsPages(data) {
                let controls = page_controls["products"];
                let total_count = data["rows"][0]["products_count"];
                let total_pages = parseInt(total_count / LIMIT);

                controls["previous"].onclick = () => {
                    previousProductsTablePage()
                };
                controls["next"].onclick = () => {
                    nextProductsTablePage(total_pages)
                };

                controls.innerText = `Page ${pages["products"]+1} of ${total_pages}`;
            }


            function nextProductsTablePage(total_pages) {
                if (pages["products"] + 1 >= total_pages) return;

                let tbody = table_bodies["products"];
                tbody = clearTableBody(tbody);
                ++pages["products"];

                fetchProducts(pages["products"]);
                fetchTotalProductsCount();
            }


            function previousProductsTablePage() {
                if (pages["products"] - 1 < 0) return;

                let tbody = table_bodies["products"];
                tbody = clearTableBody(tbody);
                --pages["products"];

                fetchProducts(pages["products"]);
                fetchTotalProductsCount();
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


            function deleteProducts() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                let product_ids = [];

                for (let index = 0; index < tickedBoxes.length; index++) {
                    product_ids.push(tickedBoxes[index].value);
                }

                fetch("../api/remove-products", {
                    "method": "POST",
                    "Content-Type": "application/json",
                    "body": JSON.stringify(product_ids),
                }).then(response => response.json()).then(data => {
                    if (data["status"] !== 200) return console.error(data["message"]);

                    let tbody = table_bodies["products"];
                    tbody = clearTableBody(tbody);

                    fetchProducts(pages["products"]);
                    fetchTotalProductsCount();

                    document.querySelector("#edit-button").style.display = "none";
                    document.querySelector("#delete-button").style.display = "none";

                    let message = document.querySelector("div#message");
                    message.innerText = "Product(s) removed successfully!";
                    fadeIn(message);
                    setTimeout(() => {
                        fadeOut(message);
                    }, 5150);
                });
            }


            function editProduct() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                let product_ids = [];

                for (let index = 0; index < tickedBoxes.length; index++) {
                    product_ids.push(tickedBoxes[index].value);
                }

                window.location.href = `../admin/edit-product?id=${product_ids[0]}`;
            }
        </script>
</body>

</html>