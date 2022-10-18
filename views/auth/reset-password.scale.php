<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        html, body {
            height: 100%;
        }
        
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
    </style>
    <title>Reset Password | Industrial Sales Assist</title>
</head>

<body>
    <?php include_once("views/shared/nav.php"); ?>
    <div main flex="v" fullwidth back-light v-center fullheight>
        <div class="content-section" flex="v" h-center style="box-shadow: 0 6px 6px -6px rgba(0, 0, 0, .3);">
            <div class="card" flex="v" style="justify-content: center; gap: 0; background-color: #FFF;">
                <form action="../auth/reset-password-submit" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="row">
                        <div class="column header-container" id="headers" style="gap: 10px; text-align: center; padding-top: 30px; min-width: 200px;">
                            <h1 style="margin: 0;">Reset Password</h1>
                            <h3 style="margin: 0;"></h3>
                        </div>
                        <div class="column"></div>
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
                                <input form-input type="password" id="password" placeholder="Password" name="password" required>
                                <input form-input type="password" id="confirm_password" placeholder="Confirm password" name="password-confirm" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column header-container" id="headers" style="text-align: center;">
                        </div>
                        <div class="column" style="align-items: flex-end">
                            <button type="submit" button contain="good" style="width: 200px; border-radius: 1000px;">Reset Password</button>
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
        let password = document.querySelector("input#password");
        let confirmPassword = document.querySelector("input#confirm_password");

        function validatePassword() {

            console.log(password.value);
            console.log(confirmPassword.value);

            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Passwords don't match!");
            } else {
                confirmPassword.setCustomValidity("");
            }
        }

        password.onkeydown = validatePassword;
        confirmPassword.onkeyup = validatePassword;
    </script>
</body>

</html>