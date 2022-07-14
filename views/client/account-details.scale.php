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
    <title>Account Details | UPCC Client</title>
</head>

<body back-light>
    <div flex="h" nogap>
        <?php include_once("views/shared/client_nav.php"); ?>
        <div flex="v" style="width: 100%;" nogap>
            <?php include_once("views/shared/client_header_nav.php"); ?>
            <input type="hidden" id="user_id" value="<?php echo $_SESSION["id"]; ?>">
            <div main fullwidth flex="v">
                <div>
                    <button button contain="secondary" small onclick="history.back()">Back</button>
                </div>
                <h1 nomargin>Account Details</h1>
                <div>
                    <h3 nomargin>Name</h3>
                    <p nomargin id="name"></p>
                </div>
                <div>
                    <h3 nomargin>Company Name</h3>
                    <p nomargin id="company_name"></p>
                </div>
                <div>
                    <h3 nomargin>Company Address</h3>
                    <p nomargin id="company_address"></p>
                </div>
                <div>
                    <h3 nomargin>Company Nature</h3>
                    <p nomargin id="company_nature"></p>
                </div>

                <br>

                <h1 nomargin>Contact Info</h1>
                <div>
                    <h3 nomargin>Phone/Landline</h3>
                    <p nomargin id="phone_number"></p>
                </div>
                <div>
                    <h3 nomargin>Email</h3>
                    <p nomargin id="email"></p>
                </div>

                <br>

                <div>
                    <a href="../client/edit-info?id=<?php echo $_SESSION["id"]; ?>" contain="secondary" button small>Edit Info</a>
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
        let user_id = document.querySelector("#user_id").value;

        fetch(`../api/user?id=${user_id}`).then(response => response.json()).then(json => {
            let details = json["rows"][0];
            if (json["status"] !== 200) console.error(json);
            document.querySelector("p#name").innerText = `${details["first_name"]} ${details["last_name"]}`;
            document.querySelector("p#company_name").innerText = details["company_name"] == null || details["company_name"] == undefined ? "N/A" : `${details["company_name"]}`;
            document.querySelector("p#company_address").innerText = details["company_address"] == null || details["company_address"] == undefined ? "N/A" : `${details["company_address"]}`;
            document.querySelector("p#company_nature").innerText = details["company_nature"] == null || details["company_nature"] == undefined ? "N/A" : `${details["company_nature"]}`;
            document.querySelector("p#phone_number").innerText = details["phone_number"] == null || details["phone_number"] == undefined ? "N/A" : `${details["phone_number"]}`;
            document.querySelector("p#email").innerText = details["email"] == null || details["email"] == undefined ? "N/A" : `${details["email"]}`;
        });
    </script>
</body>

</html>