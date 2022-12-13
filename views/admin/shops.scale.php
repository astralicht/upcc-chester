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

        #shops-table tr:nth-child(even) {
            background-color: #E5E5E5;
        }
    </style>
    <title>Shops | ISA Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/admin_header_nav.php"); ?>
            <div main>
                <div flex="h">
                    <div flex="h" v-center>
                        <h1>Shops</h1>
                        <a href="../admin/new-shop" contain="good" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/add.svg" alt=""></a>
                    </div>
                    <div flex="h" h-end fullwidth>
                        <div flex="v">
                            <h3 nomargin>Search</h3>
                            <div flex="h" v-center>
                                <input type="text" form-input box-shadow placeholder="Enter search here" id="search-input" onkeydown="fetchShops(pages['shops'])">
                                <div id="search-button" flex="h" v-center onclick="fetchShops()">
                                    <img src="../views/assets/img/search.svg" alt="search" style="height: 2em; width: 2em;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div flex="v">
                    <div flex="h">
                        <div contain="primary" button small style="border-radius: 5px; display: none;" id="edit-button" onclick="editShop()">Edit</div>
                        <div contain="danger" button small style="border-radius: 5px; display: none;" id="delete-button" onclick="deleteShops()">Delete</div>
                    </div>
                    <div id="message" contain="danger" bordered dark-text style="display: none; opacity: 0;"></div>
                    <div flex="v">
                        <div id="shops-page-controls" h-end fullwidth contain="white" small flex="h">
                            <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="prev-page">
                                < </div>
                                    <div contain="secondary" style="width: 150px; border-radius: var(--border-radius);" small flex="h" h-center id="pages-display">1 of 1</div>
                                    <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="next-page"> > </div>
                            </div>
                        </div>
                        <table table id='shops-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                            <thead style="border-bottom: 1px solid #E5E5E5;">
                                <th></th>
                                <th>Name</th>
                                <th>Rating</th>
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
                "shops": 0,
            };
            var page_controls = {
                "shops": {
                    "next": document.querySelector("#next-page"),
                    "previous": document.querySelector("#prev-page"),
                    "label": document.querySelector("#pages-display"),
                }
            };
            var table_bodies = {
                "shops": document.querySelector("#shops-table tbody"),
            };

            fetchShops(pages["shops"]);
            fetchTotalShopsCount();


            function fetchShops(shops_page) {
                clearTableBody(table_bodies["shops"]);
                shops_page = pages["shops"];

                let filter = null;
                let brand = null;
                let type = null;

                setTimeout(() => {
                    filter = document.querySelector("#search-input").value;

                    fetch(`../api/admin-shops?filter=${filter}&limit=${LIMIT}`).then(response => response.text()).then(text => {
                        try {
                            json = JSON.parse(text);
                        } catch (error) {
                            console.error(error);
                        }

                        if (json["status"] !== 200) console.error(json);
                        if (json["rows"] === undefined) return;

                        printShopsToTable(json);
                    });
                }, 1);
            }


            function printShopsToTable(json) {
                const TBODY = table_bodies["shops"];
                let rows = json["rows"];

                if (rows.length === 0) {
                    TBODY.innerHTML = "<div contain='white' noshadow><i>No records to display.</i></div>";
                    return;
                }

                for (let row of rows) {
                    let tr = document.createElement("tr");
                    let keys = Object.keys(row);
                    let shopId = "";

                    for (let key of keys) {
                        let td = document.createElement("td");

                        if (key === "id") {
                            shopId = row[key];
                            td.innerHTML = `<input type='checkbox' value='${shopId}' onclick='checkTickedBoxes()'>`;
                        } else if (key === "name") {
                            td.innerHTML = `<a href="../shops/view?id=${shopId}">${row[key]}</a>`;
                        } else {
                            td.innerText = row[key];
                        }

                        tr.appendChild(td);
                    }

                    TBODY.appendChild(tr);
                }
            }


            function fetchTotalShopsCount() {
                fetch("../api/shops/count").then(response => response.json()).then(data => {
                    printShopsPages(data);
                });
            }


            function printShopsPages(data) {
                let controls = page_controls["shops"];
                let total_count = data["rows"][0]["count"];
                let total_pages = parseInt(total_count / LIMIT);

                if (total_pages < 1) total_pages = 1;

                controls["previous"].onclick = () => {
                    previousShopsTablePage()
                };
                controls["next"].onclick = () => {
                    nextShopsTablePage(total_pages)
                };

                controls["label"].innerText = `Page ${pages["shops"]+1} of ${total_pages}`;
            }


            function nextShopsTablePage(total_pages) {
                if (pages["shops"] + 1 >= total_pages) return;

                let tbody = table_bodies["shops"];
                tbody = clearTableBody(tbody);
                ++pages["shops"];

                fetchShops(pages["shops"]);
                fetchTotalShopsCount();
            }


            function previousShopsTablePage() {
                if (pages["shops"] - 1 < 0) return;

                let tbody = table_bodies["shops"];
                tbody = clearTableBody(tbody);
                --pages["shops"];

                fetchShops(pages["shops"]);
                fetchTotalShopsCount();
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


            function deleteShops() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                let shop_ids = [];

                for (let index = 0; index < tickedBoxes.length; index++) {
                    shop_ids.push(tickedBoxes[index].value);
                }

                fetch("../api/admin/remove-shops", {
                    "method": "POST",
                    "Content-Type": "application/json",
                    "body": JSON.stringify(shop_ids),
                }).then(response => response.text()).then(data => {
                    try {
                        json = JSON.parse(json);
                    } catch (error) {
                        console.error(json);
                        location.reload();
                    }

                    if (data["status"] !== 200) return console.error(data["message"]);

                    let tbody = table_bodies["shops"];
                    tbody = clearTableBody(tbody);

                    fetchShops(pages["shops"]);
                    fetchTotalShopsCount();

                    document.querySelector("#edit-button").style.display = "none";
                    document.querySelector("#delete-button").style.display = "none";

                    let message = document.querySelector("div#message");
                    message.innerText = "Shop(s) removed successfully!";
                    fadeIn(message);
                    setTimeout(() => {
                        fadeOut(message);
                    }, 5150);
                });
            }


            function editShop() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                let shop_ids = [];

                for (let index = 0; index < tickedBoxes.length; index++) {
                    shop_ids.push(tickedBoxes[index].value);
                }

                window.location.href = `../admin/edit-shop?id=${shop_ids[0]}`;
            }
        </script>
</body>

</html>