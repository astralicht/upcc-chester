<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        html, body {
            height: 100%;
        }

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
            background-image: url("../api/assets/img?name=login1.webp&type=webp");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            width: 100%;
        }
    </style>
    <title>Login | UPCC</title>
</head>

<body>
    <?php include_once("views/shared/nav.php"); ?>
    <div class="main-content" flex="v" fullheight>
        <div class="content-section" flex="v" v-center h-center fullheight>
            <div class="card" flex="v" v-center style="gap: 30px; width: 500px;">
                <div style="text-align: center;">
                    <h1 nomargin white-text>Welcome!</h1>
                    <h3 nomargin white-text>Please login your account.</h3>
                </div>
                <div id="popup-message" style="opacity: 0; display: none; padding: 15px 20px; transition: opacity .3s ease-in-out;" flex></div>
                <form id="email_form" onsubmit="return false" method="POST" style="color: white; width: 100%;">
                    <div fullwidth flex="v" h-center>
                        <input type="text" form-input id="email" placeholder="Email Address" fullpadding>
                        <input type="password" form-input id="password" placeholder="Password" fullpadding>
                        <button button id="login" contain="good" onclick="checkAuth()" style="border-radius:1000px; width: 100%;">Login</button>
                    </div>
                </form>
                <div flex="v" h-center>
                    <a href="../signup/index" style="color: #ccc;">Don't have an account? Sign up here!</a>
                    <a href="../login/forgot-password" style="color: #ccc;">Forgot password?</a>
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
        function checkAuth() {
            const popup_message = document.querySelector("#popup-message");

            fadeOut(popup_message);
            setTimeout(() => {
                const email_inputs = document.querySelectorAll("#email_form input");
                let inputs = {};

                email_inputs.forEach((field) => {
                    inputs[field.id] = field.value;
                });

                fetch("../api/verifylogin", {
                        "method": "POST",
                        "Content-Type": "application/json",
                        "body": JSON.stringify(inputs),
                    })
                    .then(response => response.text())
                    .then(text => {
                        let json = null;

                        try {
                            json = JSON.parse(text);
                        } catch (error) {
                            console.error(text);
                            return;
                        }

                        if (json["status"] === 200) {
                            window.location.href = "../auth/loginredirect";
                            return;
                        }

                        popup_message.setAttribute("contain", "danger");
                        popup_message.setAttribute("bordered", "");
                        popup_message.setAttribute("fullwidth", "");
                        popup_message.innerHTML = "<div>Check your login credentials.";
                        fadeIn(popup_message);
                    });
            }, 150);
        }
    </script>
</body>

</html>