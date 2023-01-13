<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    use Main\Models\FetchModel;
    include_once "views/shared/headers.php";
    ?>
    <link rel="stylesheet" href="api/assets/css?name=main.css">
    <style>
        html, body {
            height: 100%;
        }

        #search-filter-container {
            padding: 15px 20px;
            gap: 10px;
            background-color: #e5e5e5;
            border-radius: 5px;
            width: 30%;
            min-width: 300px;
        }

        #search-filter-container .header {
            margin: 7.5px 0;
        }

        hr {
            border: none;
            border-bottom: 2px solid #aaa;
        }

        .cards-container {
            flex-wrap: wrap;
            width: 100%;
            padding: 1em 0;
        }
    </style>
    <title>Shops | Industrial Sales Assist</title>
</head>

<body flex="v" nogap>
    <?php include_once("views/shared/nav.php"); ?>
    <div flex="v" main fullheight style="flex-grow: 1;">
        <div flex="h">
            <button button contain="dark" small flex="h" v-center nogap onclick="history.back()"><img src="../views/assets/img/arrow-right.webp" alt="back" style="transform: rotate(180deg);">Back</button>
        </div>
        <div>
            <h1>Shops</h1>
        </div>
        <div class="cards-container" id="shops" flex="h">
            <?php
            $FetchModel = new FetchModel();
            $results = $FetchModel->shops();
            $rows = $results["rows"];
            
            foreach ($rows as $row) {
                $card = file_get_contents("views/templates/_card_shop.html");

                $card = str_replace("{{shop_img_path}}", $row["image_path"], $card);
                $card = str_replace("{{shop_name}}", $row["name"], $card);
                $card = str_replace("{{shop_id}}", $row["id"], $card);

                $productsRows = $FetchModel->shopProducts($row["id"])["rows"];

                $card = str_replace("{{shop_products_count}}", count($productsRows), $card);

                $rating = $row["rating"];

                if ($rating == null || $rating == "") $rating = 0.0;

                $card = str_replace("{{shop_rating}}", $rating, $card);

                echo $card;
            }
            ?>
        </div>
    </div>
    <?php include_once "views/shared/footers.php"; ?>
</body>

</html>