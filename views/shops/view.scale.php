<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use Main\Models\FetchModel;

    include_once "views/shared/headers.php"; ?>
    <style>
        html,
        body {
            height: 100%;
        }

        .products-section {
            padding: 0 15px;
        }

        .increment-controls {
            border: none;
            width: 40px;
            height: 40px;
            background-color: #555;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .increment-controls:hover {
            cursor: pointer;
            background-color: #333;
        }

        #minus-increment {
            border-radius: 5px 0 0 5px;
        }

        #plus-increment {
            border-radius: 0 5px 5px 0;
        }

        #item_count::-webkit-outer-spin-button,
        #item_count::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        #item_count[type=number] {
            -moz-appearance: textfield;
        }

        #email-popup-container {
            height: 100vh;
            width: 100vw;
            backdrop-filter: blur(3px);
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            display: none;
            opacity: 0;
            transition: opacity .15s ease-in-out;
            background-color: rgba(0, 0, 0, .1);
        }

        #email-popup {
            display: block;
            margin: 0;
            height: auto;
            width: 700px;
            background-color: white;
            box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2);
        }

        #price-header,
        #price-header * {
            color: #ed7d61;
        }

        .cards-container {
            width: 100%;
            padding: 1em 0;
            flex-wrap: wrap;
        }
    </style>
    <title>{{name}} | ISA</title>
</head>

<body flex="v" nogap>
    <?php include_once("views/shared/nav.php"); ?>
    <div flex="v" main style="flex-grow: 1;">
        <div flex="h">
            <button button contain="dark" small flex="h" v-center nogap onclick="history.back()"><img src="../views/assets/img/arrow-right.webp" alt="back" style="transform: rotate(180deg);">Back</button>
        </div>
        <div flex="h">
            <img src="../{{image_path}}" alt="shop image" style="height: 75px; width: 75px; border-radius: 100%;">
            <h3>{{name}}</h3>
        </div>
        <div class="cards-container" id="products" flex="h">
            <?php
            $FetchModel = new FetchModel();
            $results = $FetchModel->shopProducts($_GET["id"]);
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
    </div>
    <?php include_once "views/shared/footers.php"; ?>
</body>

</html>