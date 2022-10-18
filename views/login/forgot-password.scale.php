<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        html,
        body {
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
            width: 100%;
        }
    </style>
    <title>Forgot Password | Industrial Sales Assist</title>
</head>

<body>
    <div contain="overlight" noshadow style="position: absolute;">
        <button onclick="history.back()" contain="secondary" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/arrow-right.webp" style="transform: rotate(180deg);" alt=""></button>
    </div>
    <div class="main-content" flex="v" fullheight back-light v-center h-center>
        <div contain="overlight" noshadow flex="v">
            <h1 nomargin>Forgot Password?</h1>
            <p nomargin>Enter your account email below and, if the account exists, an email will be sent to that email with steps to reset your password.</p>
            <form action="../forgot-password/email" flex="v" id="reset-form" method="POST" enctype="application/x-www-form-urlencoded">
                <input type="email" form-input placeholder="Enter email here..." style="background-color: white; color: #333;" id="email" required name="email">
                <button type="submit" button contain="good" style="width: 100%;">Send Reset Email</button>
            </form>
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
</body>

</html>