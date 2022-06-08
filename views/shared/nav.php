<?php session_start(); ?>

<div contain="white" nav="h" style="height: 4em;">
    <div>
        <h2 nomargin>UPCC</h2>
    </div>
    <div items fullwidth flex="h" h-end nogap>
        <a href="../home/index" nav-item contain="overlight">Home</a>
        <a href="../home/index#featured-products" nav-item contain="overlight">Featured Products</a>
        <a href="../home/index#about-us" nav-item contain="overlight">About</a>
        <a href="../home/index#contact" nav-item contain="overlight">Contact</a>
        <a href="../store/index" nav-item contain="overlight">Store</a>
        <?php if (!isset($_SESSION["type"])) { ?>
            <a href="../login/index" nav-item contain="overlight">Login</a>
        <?php } else { ?>
            <a href="../auth/loginredirect" nav-item contain="overlight">Hello, <?php echo $_SESSION["first_name"]; ?>!</a>
        <?php } ?>
        <div nav-item noshadow pointable>
            <img src="../api/assets/img?name=search.webp&type=webp" alt="search" style="height: 1.5em;">
        </div>
    </div>
</div>