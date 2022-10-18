<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "views/shared/headers.php"; ?>
    <style>
        .hero {
            display: flex;
            flex: auto;
            height: calc(100vh - 3em);
            width: 100%;
            padding: 80px;
            background-color: #f5f5f5;
            background-image: url("../views/assets/img/hero1.webp");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hero-content>* {
            padding: 50px;
            width: 100%;
            color: white;
            line-height: 1.5em;
        }
    </style>
    <title>Home | Industrial Sales Assist</title>
</head>

<body>
    <div body back-light>
        <?php include_once("views/shared/nav.php"); ?>
        
    </div>
    <?php include_once "views/shared/footers.php"; ?>
    <script>
        fetch("../api/featured-products").then(response => response.text()).then(json => {
            try {
                json = JSON.parse(json);
            } catch (error) {
                console.error(error);
            }

            if (json["status"] !== 200) console.error(json);
            if (json["rows"] === undefined) return;

            printProducts(json["rows"]);
        });


        function printProducts(rows) {
            let cardsContainer = document.querySelector(".cards-container");

            for (let row of rows) {
                let card = document.createElement("div");

                card.className = "card";
                card.innerHTML = `<img src="../${row["image_path"]}" alt="${row["image_name"]}" class="card-img" style="object-fit: cover;">
                                    <div>
                                        <span class="card-title">${row["name"]}</span>
                                    </div>
                                    <div flex="h" h-center>
                                        <a href="../store/viewproduct?id=${row["id"]}" button="secondary" fullpadding no-text-decor style="width: 150px; border-radius: 1000px;">
                                            <div white-text>
                                                View Product
                                            </div>
                                        </a>
                                    </div>`;
                card.setAttribute("flex", "v");

                cardsContainer.appendChild(card);
            }
        }
    </script>
</body>

</html>
