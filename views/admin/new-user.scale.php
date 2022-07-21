<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        .card {
            width: 100%;
            height: auto;
            border-radius: 7px;
            box-shadow: 0 6px 6px -6px rgba(0, 0, 0, .2);
            padding-bottom: 0;
            overflow: hidden;
        }

        .form-input {
            background-color: transparent;
            border-radius: 0;
            border-bottom: 2px solid #e5e5e5;
            color: #333;
            outline: none;
            width: 80%;
        }

        .form-input::placeholder {
            color: #999;
        }

        .card .row,
        .card .column {
            display: flex;
            width: 100%;
        }

        .card .column {
            flex-direction: column;
            padding: .5em 2em;
            justify-content: center;
        }

        .card #headers * {
            color: white;
        }

        #header {
            margin: 0;
            font-size: 1.2em;
            text-align: left;
            min-width: 250px;
        }

        .header-container {
            background-color: rgba(15, 39, 85, 1);
            flex-shrink: 2.3;
            min-width: 250px;
        }

        [form-input] {
            width: 100%;
            border-bottom: 1px solid #333;
            border-radius: 0;
        }

        #message-box {
            display: none;
            opacity: 0;
            transition: opacity .15s;
        }
    </style>
    <title>Signup | UPCC</title>
</head>

<body>
    <?php include_once("views/shared/nav.php"); ?>
    <div main flex="v" fullwidth back-light style="height: calc(100vh - 4em);" v-center>
        <div flex="h" v-center>
            <button onclick="history.back()" contain="secondary" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/arrow-right.webp" style="transform: rotate(180deg);" alt="">Back</button>
            <h1 style="margin: 0; flex-shrink: 0;">New User</h1>
            <div id="message-box" bordered fullwidth dark-text dark-text-all contain="danger" style="width: fit-content;"></div>
        </div>
        <div class="content-section" flex="v" h-center style="box-shadow: 0 6px 6px -6px rgba(0, 0, 0, .3);">
            <div class="card" flex="v" style="justify-content: center; gap: 0; background-color: #FFF;">
                <form onsubmit="submitSignUp(); return false;" id="new-user-form">
                    <div class="row">
                        <div class="column header-container"></div>
                        <div class="column"></div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">User Type</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div flex>
                                <select form-input id="type">
                                    <option value="AGENT">AGENT</option>
                                    <option value="ADMIN">ADMIN</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">Name</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div flex>
                                <input form-input type="text" id="first_name" placeholder="First Name" required>
                                <input form-input type="text" id="last_name" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">Name of Company</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div flex>
                                <input form-input type="text" id="company_name" placeholder="Name of Company">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">Address</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div flex>
                                <textarea form-input id="address" placeholder="Address" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">Nature of Company</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div flex>
                                <select form-input id="company_nature">
                                    <option value="NULL">Select company nature</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">Email Address</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div flex>
                                <input form-input type="text" id="email" placeholder="E-mail" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">Phone Numbers</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column" style="gap: 1em;">
                            <div flex>
                                <input form-input type="number" id="mobile_number" placeholder="Mobile Number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers">
                            <div flex>
                                <span id="header">Password</span>
                                <div flex="h" h-end fullwidth>
                                    <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="arrow-right">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div flex>
                                <input form-input type="password" id="password" placeholder="Password" required>
                                <input form-input type="password" id="confirm_password" placeholder="Confirm Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container"></div>
                        <div class="column" style="align-items: flex-end">
                            <button type="submit" button contain="good" style="width: 150px; border-radius: 1000px;">Sign up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>
        fetch("../api/companynatures").then(response => response.json()).then(json => {
            if (json["status"] !== 200) console.error(json);
            if (json["rows"] === undefined) return;

            const company_natures_select = document.querySelector("#company_nature");
            populateNaturesSelect(json, company_natures_select);
        });


        function populateNaturesSelect(json, company_natures_select) {
            let rows = json["rows"];

            if (rows.length === 0) return;

            for (let row of rows) {
                let option = document.createElement("option");
                option.value = row["nature"];
                option.innerText = row["nature"];
                company_natures_select.appendChild(option);
            }
        }


        function submitSignUp() {
            const INPUT_FIELDS = document.querySelectorAll("input");
            const SELECTS = document.querySelectorAll("select");
            const TEXTAREAS = document.querySelectorAll("textarea");
            let inputs = {};

            if (INPUT_FIELDS.length !== 0) {
                INPUT_FIELDS.forEach((field) => {
                    inputs[field.id] = field.value;
                });
            }

            if (SELECTS.length !== 0) {
                SELECTS.forEach((field) => {
                    inputs[field.id] = field.value;
                });
            }

            if (TEXTAREAS.length !== 0) {
                TEXTAREAS.forEach((field) => {
                    inputs[field.id] = field.value;
                });
            }

            fetch("../api/admin/create-user", {
                "method": "POST",
                "Content-Type": "application/json",
                "body": JSON.stringify(inputs),
            }).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch {
                    return console.error(json);
                }

                let messageBox = document.querySelector("div#message-box");

                if (json["status"] !== 200) {
                    messageBox.innerText = json["message"];
                    fadeInOut(messageBox);

                    return;
                }

                messageBox.innerText = "Successfully created new user.";
                messageBox.setAttribute("contain", "good");
                fadeInOut(messageBox);

                document.querySelector("form#new-user-form").reset();
            });
        }
    </script>
</body>

</html>