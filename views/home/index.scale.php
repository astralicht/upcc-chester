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
    <title>Home | UPCC</title>
</head>

<body>
    <div body back-light>
        <?php include_once("views/shared/nav.php"); ?>
        <div class="hero">
            <div style="height: calc(100vh - 3em); width: 100%; background-image: linear-gradient(to right, transparent, transparent, #000); position: absolute; top: 4em; left: 0;"></div>
            <div fullwidth></div>
            <div class="hero-content" flex="h" v-center style="width: 100%;">
                <div style="background-color: rgba(0, 0, 0, .7); backdrop-filter: blur(3px);" flex="v">
                    <div style="color: white;">
                        <h1 style=" display: inline; color: white; font-size: 3em;">UPCC</h1> has been at the forefront of the valve pipeline steel business in the
                        Philippines. We carry a wide range of High Pressure Steam valves carbon steel, forged steel, SS 304(CF8)/316L(CF8M) body
                        construction with pipe fittings/flanges and seamless pipes, Boiler tubes, and High Pressure Plates from Japan, Italy, Brazil,
                        Germany, Korea, China, and the United States. We hold the distinction of being ranked as one of the regular vendor of some of
                        the Philippines' biggest companies from sectors in Oil Refinery, Petroleum, Geothermal, LNG, LPG, Power/Energy, Chemical, Sugar
                        Mill, Food/Beverage, Distillery & International Sub contructors.
                    </div>
                    <div flex="h" h-end>
                        <a href="#" button="primary" white-text-all>
                            <b>Explore Valves</b>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div main flex="v">
            <div id="featured-products">
                <div>
                    <h1 style="width: 100%; text-align: center; font-size: 2.5em;">Featured Products</h1>
                </div>
                <div>
                    <div class="cards-container" flex="h" h-center></div>
                    <div fullwidth flex="h" h-center fullpadding>
                        <a href="../store/index" button="secondary" style="outline: none; border: 0; width: 300px; padding: .5em .7em;">View more in store</a>
                    </div>
                </div>
            </div>
        </div>
        <div flex="h" h-center v-center style="height: 600px;" id="about-us">
            <div style="background-color: #0f2755; height: 300px; width: 300px; z-index: 2; left: 150px;
                        position: absolute; justify-content: center; align-items: center;
                        box-shadow: 10px 10px 10px -10px rgba(0, 0, 0, .3);" flex>
                <h1 style="font-size: 2.5em; color: white;">
                    About Us
                </h1>
            </div>
            <div style="background-color: white; position: absolute; left: 320px; right: 150px; min-width: 700px; padding: 50px; 
                        padding-left: 170px; box-shadow: 0 0 9px 3px rgba(0, 0, 0, .15); overflow-x: auto;" flex>
                With an ever-growing demand for brand loyalty and repeat business, UPCC has done just that in large part due to keeping 
                up with the times. Stocking the newest and more improved materials, to associating ourselves with the latest international 
                standards, to being prevalent in its digital information and accessibility, we are a company of experience, instilled with 
                youth and both immersed in dedication.
            </div>
        </div>
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
