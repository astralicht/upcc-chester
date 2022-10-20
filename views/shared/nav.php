<?php session_start(); ?>
<style>
    #search-bar {
        border: 1px solid #e5e5e5;
        border-radius: 5px 0 0 5px;
        width: 250px;
        min-width: 250px;
    }

    #search-button {
        background-color: #e5e5e5;
        outline: none;
        border: none;
        height: 100%;
    }

    #search-button:hover {
        background-color: #ccc;
    }
</style>
<div contain="white" nav="h" style="height: 4em;">
    <div style="width: 100%;">
        <a href="../home/index" style="text-decoration: none;">
            <h3 nomargin>Industrial Sales Assist</h3>
        </a>
    </div>
    <div items fullwidth flex="h" h-end v-center nogap>
        <form action="../store/search" method="GET" flex="h" style="padding: .5em 1em;" nogap fullheight>
            <input type="text" id="search-bar" name="param" placeholder="Search..." form-input>
            <button flex="h" v-center style="padding: 0 .5em; border-radius: 0 5px 5px 0;" id="search-button">
                <img src="../views/assets/img/search.svg" alt="search">
            </button>
        </form>
        <a href="../home/index" nav-item contain="overlight">Home</a>
        <a href="../shops/index" nav-item contain="overlight">Shops</a>
        <a href="../products/index" nav-item contain="overlight">Products</a>
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