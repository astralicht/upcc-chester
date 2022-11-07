<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use Main\Controllers\FetchController;
    use Main\Models\FetchModel;

    include_once "views/shared/headers.php"; ?>
    <style>
        html,
        body {
            height: 100%;
        }

        .section-title {
            padding: 1em;
            background-color: #e5e5e5;
            width: 50%;
        }

        .section-subtitle {
            font-size: .5em;
            color: #ed7d61;
        }

        .cards-container {
            width: 100%;
            padding: 1em 0;
            flex-wrap: wrap;
        }
    </style>
    <title>Home | Industrial Sales Assist</title>
</head>

<body flex="v" nogap>
    <div body fullheight>
        <?php include_once("views/shared/nav.php"); ?>
        <div style="padding: 1em 3em; flex-grow: 1;">
            <section flex="v" nogap>
                <h2 class="section-title" flex="v" nogap>Featured Shops<span class="section-subtitle">Shops you might like</span></h2>
                <div flex="h" h-end style="padding: 0 1em;">
                    <a href="../shops/index">See all ></a>
                </div>
                <div class="cards-container" id="shops" flex="h">
                    <?php
                    $FetchModel = new FetchModel();
                    $results = $FetchModel->featuredShops(7);
                    $rows = $results["rows"];
                    foreach ($rows as $row) {
                        $card = file_get_contents("views/templates/_card_shop.html");

                        $card = str_replace("{{shop_img_path}}", $row["shop_image_path"], $card);
                        $card = str_replace("{{shop_name}}", $row["shop_name"], $card);
                        $card = str_replace("{{shop_id}}", $row["shop_id"], $card);

                        $rows = $FetchModel->shopProducts($row["shop_id"])["rows"];

                        $card = str_replace("{{shop_products_count}}", count($rows), $card);

                        $rating = $row["rating"];

                        if ($rating == null || $rating == "") $rating = 0.0;

                        $card = str_replace("{{shop_rating}}", $rating, $card);

                        echo $card;
                    }
                    ?>
                </div>
            </section>
            <section flex="v" nogap>
                <h2 class="section-title" flex="v" nogap>Featured Products<span class="section-subtitle">Products you might like</span></h2>
                <div flex="h" h-end style="padding: 0 1em;">
                    <a href="../products/index">See all ></a>
                </div>
                <div class="cards-container" id="products" flex="h">
                    <?php
                    $FetchModel = new FetchModel();
                    $results = $FetchModel->featuredProducts(10);
                    $rows = $results["rows"];
                    foreach ($rows as $row) {
                        $img_path = $row["product_img_path"];
                        $img_name = $row["product_img_name"];
                        $name = $row["product_name"];
                        $id = $row["product_id"];
                        $price = $row["product_price"];
                        $clicks = $row["clicks"];
                        $card = "<a href='../products/view?id=$id' style='text-decoration: none;'>
                                    <div class='card' flex='v'>
                                        <img src='../$img_path' alt='$img_name' class='card-img' style='object-fit: cover;'>
                                        <div class='card-body'>
                                            <span class='card-title'>$name</span>
                                            <div flex='h'>
                                                <span class='card-price' fullwidth>₱$price</span>
                                                <i fullwidth flex='h' h-end>$clicks views</i>
                                            </div>
                                        </div>
                                    </div>
                                </a>";
                        echo $card;
                    }
                    ?>
                </div>
            </section>
            <?php
            if (isset($_SESSION["type"])) {
            ?>
            <section flex="v" nogap>
                <h2 class="section-title">Buy Again</h2>
                <div flex="h" h-end style="padding: 0 1em;">
                    <a href="../products/index">See all ></a>
                </div>
                <div class="cards-container" id="buy-again" flex="h">
                    <?php
                    $FetchModel = new FetchModel();
                    $results = $FetchModel->previousOrderedProducts(10);
                    $rows = $results["rows"];

                    if (empty($rows) || gettype($rows) !== "array") {
                        echo "<i>No products previously bought.</i>";
                        return;
                    }

                    foreach ($rows as $row) {
                        $img_path = $row["image_path"];
                        $img_name = $row["image_name"];
                        $name = $row["name"];
                        $id = $row["product_id"];
                        $price = $row["unit_price"];
                        $card = "<a href='../products/view?id=$id' style='text-decoration: none;'>
                                    <div class='card' flex='v'>
                                        <img src='../$img_path' alt='$img_name' class='card-img' style='object-fit: cover;'>
                                        <div class='card-body'>
                                            <span class='card-title'>$name</span>
                                            <div flex='h'>
                                                <span class='card-price' fullwidth>₱$price</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>";
                        echo $card;
                    }
                    ?>
                </div>
            </section>
            <?php } ?>
        </div>
    </div>
    <?php include_once "views/shared/footers.php"; ?>
</body>

</html>