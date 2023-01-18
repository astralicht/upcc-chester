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
    </style>
    <title>Edit Info | ISA Client</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/client_nav.php"); ?>
        <div flex="v" style="width: 100%;" nogap>
            <div main fullwidth flex="v">
                <div>
                    <button button contain="secondary" small onclick="history.back()">Back</button>
                </div>
                <img src="" alt="" id="user-image" style="height: 300px; width: 300px; box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2); flex-shrink: 0; object-fit: cover;">
                <form action="../upload/image" method="POST" enctype="multipart/form-data" flex="v">
                    <input type="file" name="image-input" id="image-input" form-input style="width: 300px; background-color: #ccc">
                    <input type="hidden" value="USER" name="image-type" id="image-type">
                    <input type="hidden" value="" name="old-image-path" id="old-image-path">
                    <input type="hidden" value="<?php echo $_GET["id"]; ?>" name="id" id="user-id">
                    <button type="submit" id="user-image-upload" form-input button contain="info" small style="width: 300px; border-radius: var(--border-radius);">Upload photo</button>
                </form>
                <h1 nomargin>Edit Account Details</h1>
                <form onsubmit="submitInfo(); return false;" flex="v" contain="white" fullwidth style="padding: 2em;">
                    <div flex="h">
                        <div>
                            <div flex="h">
                                <h3 nomargin>First Name</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="first_name" form-input style="color: #333;" required>
                        </div>
                        <div>
                            <div flex="h">
                                <h3 nomargin>Last Name</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="last_name" form-input style="color: #333;" required>
                        </div>
                    </div>
                    <div form-group>
                        <h3 nomargin>Company Name</h3>
                        <input type="text" id="company_name" form-input style="color: #333;" placeholder="Enter company name">
                    </div>
                    <div form-group>
                        <h3 nomargin>Company Address</h3>
                        <input type="text" id="company_address" form-input style="color: #333;" placeholder="Enter company address">
                    </div>
                    <div form-group>
                        <h3 nomargin>Company Nature</h3>
                        <select id="company_nature" form-input style="color: #333;">
                            <option value="NULL">Select nature</option>
                        </select>
                    </div>

                    <br>

                    <h1 nomargin>Contact Info</h1>
                    <div form-group>
                        <h3 nomargin>Phone/Landline</h3>
                        <input type="text" id="phone_number" form-input style="color: #333;" placeholder="Enter mobile/landline number">
                    </div>

                    <br>

                    <div form-group fullwidth>
                        <div flex="h" fullwidth h-end>
                            <button type="submit" contain="good" button small>Save Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="display: none;" id="client-id"><?php echo $_SESSION["id"]; ?></div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>
        let user_id = document.querySelector("#client-id").innerText;


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


        fetch(`../api/user?id=${user_id}`).then(response => response.json()).then(json => {
            let details = json["rows"][0];

            if (json["status"] !== 200) console.error(json);

            document.querySelector("#first_name").value = details["first_name"];
            document.querySelector("#last_name").value = details["last_name"];
            document.querySelector("#company_name").value = details["company_name"];
            document.querySelector("#company_address").value = details["company_address"];
            document.querySelector("#phone_number").value = details["phone_number"];
            document.querySelector("img#user-image").src = "../" + details["dp_path"];
            document.querySelector("img#user-image").alt = "prof_picture";

            let companyNature = details["company_nature"];
            let natureOptions = document.querySelectorAll("select option");

            setTimeout(() => {
                for (let option of natureOptions) {
                    if (option.value === companyNature) {
                        option.setAttribute("selected", "");
                        break;
                    }
                }
            }, 10);

        }).catch(error => {
            console.error(error);
        });


        function submitInfo() {
            let clientId = document.querySelector("#client-id").innerText;
            let inputs = [];
            const INPUT_FIELDS = document.querySelectorAll("input");
            const SELECTS = document.querySelectorAll("select");

            for (let field of INPUT_FIELDS) {
                inputs.push(field.value);
            }

            for (let field of SELECTS) {
                inputs.push(field.value);
            }

            inputs.push(clientId);

            fetch("../api/client/save-info", {
                "method": "POST",
                "Content-Type": "application/json; utf-8",
                "body": JSON.stringify(inputs),
            }).then(response => response.text()).then(data => {
                setTimeout(() => {
                    window.location.reload();
                }, 10)
            })
        }
    </script>
</body>

</html>