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
    </style>
    <title>Signup | UPCC</title>
</head>

<body>
    <div main flex="v" fullwidth back-light style="height: 100vh;">
        <h1>UPCC</h1>
        <h1 nomargin>Signup successful!</h1>
        <p nomargin>We sent you a <strong><em>confirmation email</em></strong> to complete your signup.</p>
        <p nomargin>Click <a href="../login/index">here</a> to login.</p>
    </div>
</body>

</html>