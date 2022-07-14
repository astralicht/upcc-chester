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

        #users-table tr:nth-child(even) {
            background-color: #E5E5E5;
        }

        div#message {
            transition: opacity .15s;
        }
    </style>
    <title>Users | UPCC Admin</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <?php include_once("views/shared/admin_header_nav.php"); ?>
            <div main fullwidth>
                <div flex="h">
                    <div flex="h" v-center>
                        <h1>Users</h1>
                        <a href="../signup/index" contain="good" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/add.svg" alt=""></a>
                    </div>
                    <div flex="h" h-end fullwidth>
                        <div flex="v">
                            <h3 nomargin>Search</h3>
                            <div flex="h" v-center>
                                <input type="text" form-input box-shadow placeholder="Enter search here" id="search-input" onkeydown="fetchUsers()">
                                <div id="search-button" flex="h" v-center onclick="fetchUsers()">
                                    <img src="../views/assets/img/search.svg" alt="search" style="height: 2em; width: 2em;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div flex="v">
                    <div flex="h" id="action-buttons">
                        <div contain="danger" button small style="border-radius: 5px; display: none;" id="delete-button" onclick="deleteUsers()">Delete</div>
                    </div>
                    <div id="message" contain="danger" bordered dark-text style="display: none; opacity: 0;"></div>
                    <div flex="v">
                        <div id="users-page-controls" h-end fullwidth contain="white" small flex="h">
                            <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="prev-page">
                                < </div>
                                    <div contain="secondary" style="width: 150px; border-radius: var(--border-radius);" small flex="h" h-center id="pages-display">1 of 1</div>
                                    <div contain="secondary" button style="width: 50px; border-radius: var(--border-radius);" small flex="h" h-center id="next-page"> > </div>
                            </div>
                        </div>
                        <table table id='users-table' contain="white" style="width: auto; text-align: left; overflow: auto;">
                            <thead style="border-bottom: 1px solid #E5E5E5;">
                                <th></th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Name of Company</th>
                                <th>Nature of Company</th>
                                <th>Company Address</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
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
                "users": 0,
            };
            var page_controls = {
                "users": {
                    "next": document.querySelector("#next-page"),
                    "previous": document.querySelector("#prev-page"),
                }
            };
            var table_bodies = {
                "users": document.querySelector("#users-table tbody"),
            };

            fetchUsers(pages["users"]);
            fetchTotalUsersCount();


            function fetchUsers(users_page) {
                clearTableBody(table_bodies["users"]);
                users_page = 0;

                let filter = null;

                setTimeout(() => {
                    filter = document.querySelector("#search-input").value;

                    fetch(`../api/users?filter=${filter}&page=${users_page}&limit=${LIMIT}`).then(response => response.json()).then(json => {
                        if (json["status"] !== 200) console.error(json);
                        if (json["rows"] === undefined) return;

                        printUsersToTable(json);
                    });
                }, 1);
            }


            function printUsersToTable(json) {
                const TBODY = table_bodies["users"];
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


            function fetchTotalUsersCount() {
                fetch("../api/users/count").then(response => response.json()).then(data => {
                    printUsersPages(data);
                });
            }


            function printUsersPages(data) {
                let controls = page_controls["users"];
                let total_count = data["rows"][0]["users_count"];
                let total_pages = parseInt(total_count / LIMIT);

                controls["previous"].onclick = () => {
                    previousUsersTablePage()
                };
                controls["next"].onclick = () => {
                    nextUsersTablePage(total_pages)
                };

                controls.innerText = `Page ${pages["users"]+1} of ${total_pages}`;
            }


            function nextUsersTablePage(total_pages) {
                if (pages["users"] + 1 >= total_pages) return;

                let tbody = table_bodies["users"];
                tbody = clearTableBody(tbody);
                ++pages["users"];

                fetchUsers(pages["users"]);
                fetchTotalUsersCount();
            }


            function previousUsersTablePage() {
                if (pages["users"] - 1 < 0) return;

                let tbody = table_bodies["users"];
                tbody = clearTableBody(tbody);
                --pages["users"];

                fetchUsers(pages["users"]);
                fetchTotalUsersCount();
            }


            function clearTableBody(tbody) {
                tbody.innerHTML = "";
                return tbody;
            }


            function checkTickedBoxes() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                if (tickedBoxes.length === 0) {
                    document.querySelector("#delete-button").style.display = "none";
                    return;
                }

                if (tickedBoxes.length < 2) {
                    document.querySelector("#delete-button").style.display = "block";
                    return;
                }

                if (tickedBoxes.length > 1) {
                    document.querySelector("#delete-button").style.display = "block";
                    return;
                }
            }


            function deleteUsers() {
                const tickedBoxes = document.querySelectorAll("input[type=checkbox]:checked");

                let user_ids = [];

                for (let index = 0; index < tickedBoxes.length; index++) {
                    user_ids.push(tickedBoxes[index].value);
                }

                fetch("../api/remove-users", {
                    "method": "POST",
                    "Content-Type": "application/json",
                    "body": JSON.stringify(user_ids),
                }).then(response => response.json()).then(data => {
                    if (data["status"] === 200) {
                        let tbody = table_bodies["users"];
                        tbody = clearTableBody(tbody);

                        fetchUsers(pages["users"]);
                        fetchTotalUsersCount();

                        document.querySelector("#edit-button").style.display = "none";
                        document.querySelector("#delete-button").style.display = "none";

                        let message = document.querySelector("div#message");
                        message.innerText = "User(s) removed successfully!";
                        fadeIn(message);
                        setTimeout(() => {
                            fadeOut(message);
                        }, 5150);
                    }
                });
            }
        </script>
</body>

</html>