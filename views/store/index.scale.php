<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "views/shared/headers.php"; ?>
    <link rel="stylesheet" href="api/assets/css?name=main.css">
    <style>
        :root {
            --card-width: 200px;
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

        .card {
            width: var(--card-width);
            min-width: var(--card-width);
            gap: 1em;
            padding-bottom: 1em;
            text-decoration: none;
        }

        .card:hover {
            box-shadow: 0 0 6px rgba(0, 0, 0, .3);
        }

        .card .card-img {
            width: var(--card-width);
            height: var(--card-width);
        }

        .card .card-title {
            display: block;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0;
            height: auto;
            width: auto;
        }

        .card .card-body {
            padding: 0 1em;
        }

        .card .card-price {
            color: #ed7d61;
        }
    </style>
    <title>Products | UPCC</title>
</head>

<body>
    <?php include_once("views/shared/nav.php"); ?>
    <div flex="v" main>
        <div>
            <h1>Products</h1>
        </div>
        <div flex="h">
            <div>
                <div flex="v" id="search-filter-container">
                    <h2 class="header">Search</h2>
                    <div>
                        <input type="text" id="search-input" placeholder="Search here" form-input>
                        <div style="padding: 1em 0;">
                            <button style="outline: none; border: 0; width: 100%; padding: .5em .7em;" button="secondary" fullpadding white-text style="border-radius: 1000px; box-sizing: border-box; width: 100%;" onclick="searchProduct(filter)">
                                Search
                            </button>
                        </div>
                        <hr>
                    </div>
                    <div id="advanced-search-filters" flex="v">
                        <div>
                            <h3 class="header">Type</h3>
                            <hr>
                            <select form-input id="type-select">
                                <option value="null">Select type</option>
                            </select>
                        </div>
                        <div>
                            <h3 class="header">Brand</h3>
                            <hr>
                            <select form-input id="brand-select">
                                <option value="null">Select brand</option>
                            </select>
                        </div>
                        <div style="padding: 1em 0;">
                            <button style="outline: none; border: 0; width: 100%; padding: .5em .7em;" button="secondary" fullpadding white-text style="border-radius: 1000px; box-sizing: border-box; width: 100%;" onclick="searchProductWithFilters()">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div flex="v" style="gap: 1em;" fullwidth>
                <div flex="h" flex-wrap id="products-container">
                </div>
                <div flex="h" h-center fullwidth id="show-more-container">
                    <i id="show-more-message" style="display: none;">No more products to display.</i>
                    <button style="outline: none; border: 0; width: 250px; padding: .5em .7em;" button="secondary" id="show-more" onclick="fetchMoreProducts(filter)">Show More Products</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "views/shared/footers.php"; ?>
    <script>
        const LIMIT = 25;
        var page = 0;
        var container = document.querySelector("#products-container");
        var filter = "null";
        var type = "null";
        var brand = "null";


        fetchProducts();
        fetchTypesAndBrands();


        function fetchProducts() {
            clearContainer(container);
            page = 0;

            fetch(`../api/products?filter=${filter}&brand=${brand}&typeid=${type}&page=${page}&limit=${LIMIT}`).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch {
                    console.error(json);
                    return;
                }

                if (json["status"] !== 200) console.error(json);
                if (json["rows"] === undefined) return;

                printProductsToContainer(json);
            });
        }


        function fetchMoreProducts() {
            ++page;

            fetch(`../api/products?filter=${filter}&brand=${brand}&typeid=${type}&page=${page}&limit=${LIMIT}`).then(response => response.json()).then(json => {
                if (json["status"] !== 200) console.error(json);
                if (json["rows"] === undefined) return;

                appendProductsToContainer(json);
            });
        }


        function printProductsToContainer(json) {
            const CONTAINER = container;
            let rows = json["rows"];

            let show_more_button = document.querySelector("button#show-more");
            let show_more_message = document.querySelector("i#show-more-message");

            show_more_button.style.display = "block";
            show_more_message.style.display = "none";

            for (let row of rows) {
                let div = document.createElement("div");
                let string = `<a href="../store/viewproduct?id={{product_id}}" class="card" flex="v">
                        <img src="../{{product_img_path}}" class="card-img" loading="lazy" style="object-fit: cover;">
                        <div class="card-body">
                            <div class="card-title">{{product_name}}</div>
                            <div class="card-price">₱{{product_price}}</span></div>
                        </div>
                    </a>`;

                string = string.replace("{{product_id}}", row["id"]);
                string = string.replace("{{product_img_path}}", row["image_path"]);
                string = string.replace("{{product_name}}", row["name"]);
                string = string.replace("{{product_price}}", row["unit_price"]);

                div.innerHTML = string;

                CONTAINER.appendChild(div);
            }
        }


        function appendProductsToContainer(json) {
            const CONTAINER = container;
            let rows = json["rows"];

            if (rows.length === 0) {
                let show_more_button = document.querySelector("button#show-more");
                let show_more_message = document.querySelector("i#show-more-message");

                show_more_button.style.display = "none";
                show_more_message.style.display = "block";
                return;
            }

            for (let row of rows) {
                let div = document.createElement("div");
                let string = `<a href="../store/viewproduct?id={{product_id}}" class="card" flex="v">
                        <img src="{{product_img_path}}" class="card-img" loading="lazy">
                        <div class="card-body">
                            <div class="card-title">{{product_name}}</div>
                            <div class="card-price">₱{{product_price}}</span></div>
                        </div>
                    </a>`;

                string = string.replace("{{product_id}}", row["id"]);
                string = string.replace("{{product_img_path}}", row["image_path"]);
                string = string.replace("{{product_name}}", row["name"]);
                string = string.replace("{{product_price}}", row["unit_price"]);

                div.innerHTML = string;

                CONTAINER.appendChild(div);
            }
        }


        function clearContainer(CONTAINER) {
            CONTAINER.innerHTML = "";
            return CONTAINER;
        }


        function searchProduct() {
            filter = document.querySelector("input#search-input").value;
            fetchProducts(filter);
        }


        function fetchTypesAndBrands() {
            fetch("../api/fetch/types-brands").then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch {
                    console.error(json);
                }

                let brands = json["brands"];
                let types = json["types"];

                let brandSelect = document.querySelector("select#brand-select");
                let typeSelect = document.querySelector("select#type-select");

                for (let brand of brands) {
                    let option = document.createElement("option");

                    option.value = brand["brand"];
                    option.innerText = brand["brand"];

                    brandSelect.appendChild(option);
                }

                for (let type of types) {
                    let option = document.createElement("option");

                    option.value = type["id"];
                    option.innerText = type["name"];

                    typeSelect.appendChild(option);
                }
            });
        }


        function searchProductWithFilters() {
            let brandSelect = document.querySelector("select#brand-select");
            let typeSelect = document.querySelector("select#type-select");
            let searchInput = document.querySelector("input#search-input");

            brand = brandSelect.value;
            type = typeSelect.value;
            filter = searchInput.value;

            clearContainer(container);
            page = 0;

            if (filter == "") filter = "null";

            fetch(`../api/products?filter=${filter}&brand=${brand}&typeid=${type}&page=${page}&limit=${LIMIT}`).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch {
                    console.error(json);
                    return;
                }

                if (json["status"] !== 200) console.error(json);
                if (json["rows"] === undefined) return;

                printProductsToContainer(json);
            });
        }
    </script>
</body>

</html>