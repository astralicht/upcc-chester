<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once 'views/shared/headers.php'; ?>
    <title>Invalid Token | UPCC</title>
</head>

<body contain="overlight" noshadow flex="v" h-center fullwidth nogap>
    <h1> Invalid Token! </h1>
    <p text="medium">Redirecting you to login in <i id="count">5</i>...</p>
    <script>
        setInterval(() => {
            document.querySelector("i#count").innerText = parseInt(document.querySelector("i#count").innerText) - 1;
            if (document.querySelector("i#count").innerText == 0) window.location.href = "../login/index";
        }, 1000);
    </script>
</body>

</html>