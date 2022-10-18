<?php session_start(); ?>

<div contain="white" nav="h" style="height: 4em;">
    <div style="width: 100%;">
        <a href="../home/index" style="text-decoration: none;">
            <h3 nomargin>ISA</h3>
        </a>
    </div>
    <div items fullwidth flex="h" h-end v-center nogap>
        <a href="../home/index" nav-item contain="overlight">Home</a>
        <a href="../home/index#featured-products" nav-item contain="overlight">Featured Products</a>
        <a href="../home/index#about-us" nav-item contain="overlight">About</a>
        <a href="../home/index#contact" nav-item contain="overlight">Contact</a>
        <a href="../store/index" nav-item contain="overlight">Store</a>
        <?php if (!isset($_SESSION["type"])) { ?>
            <a href="../login/index" nav-item contain="overlight">Login</a>
        <?php } else { ?>
            <a href="../auth/loginredirect" nav-item contain="overlight" flex="h">
                <span id="cart-items-count" contain="overlight" nopadding noshadow style="font-weight: bold;"><?php echo $_SESSION["cart_count"]; ?></span>
                Hello, <?php echo $_SESSION["first_name"]; ?>!
                <img src="../<?php echo $_SESSION["dp_path"]; ?>" alt="prof_pic" style="height: 4em; width: 4em; background-color: #F0F0F0; font-size: .7em; border-radius: 50%;">
            </a>
        <?php } ?>
    </div>
</div>