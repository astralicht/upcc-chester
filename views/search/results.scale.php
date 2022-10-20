<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "views/shared/headers.php"; ?>
    <link rel="stylesheet" href="api/assets/css?name=main.css">
    <style>
        html,
        body {
            height: 100%;
        }

        hr {
            border: none;
            border-bottom: 2px solid #aaa;
        }

        .filter-button {
            background-color: #f5f5f5;
            color: #333;
            padding: 0 1em;
            height: 100%;
            width: 150px;
            display: flex;
            align-items: center;
        }

        .filter-button:hover {
            background-color: #aaa;
        }

        .filter-button[active] {
            background-color: #ed7671;
            color: white;
        }
    </style>
    <title>Search "{{search_param}}" | Industrial Sales Assist</title>
</head>

<body flex="v">
    <?php include_once("views/shared/nav.php"); ?>
    <div flex="v" main style="flex-grow: 1;">
        <div flex="v" style="padding: 1em 0;">
            <div flex="h" v-center>
                <h2 nomargin fullwidth>Shops related to "<span style="color: #ed7d61;">{{search_param}}</span>"</h2>
                <i fullwidth style="text-align: right;"><a href="../shops/index">View all shops ></a></i>
            </div>
            <div flex="h">
                {{shops_search_results}}
            </div>
        </div>
        <div flex="v" style="padding: 1em 0;">
            <div flex="h" v-center>
                <h2 nomargin fullwidth>Products related to "<span style="color: #ed7d61;">{{search_param}}</span>"</h2>
                <i fullwidth style="text-align: right;"><a href="../products/index">View all products ></a></i>
            </div>
            <div style="background-color: #f5f5f5; padding: 0.5em 1em; width: fit-content;" flex="h" v-center>
                <b style="padding: 0 .5em;">Sort by:</b>
                <span button active sharp-edges class="filter-button" onclick="selectFilter(this)">Relevance</span>
                <span button sharp-edges class="filter-button" onclick="selectFilter(this)">Latest</span>
                <span button sharp-edges class="filter-button" onclick="selectFilter(this)">Top Sales</span>
                <div style="padding: 0 1em;" flex="h" v-center>
                    <span>Price:</span>
                    <select name="price-filter" id="price-filter" form-input onchange="selectFilter(this)">
                        <option value="">Select an option</option>
                        <option value="asc">Lowest to highest</option>
                        <option value="dsc">Highest to lowest</option>
                    </select>
                </div>
            </div>
            <div flex="h" style="width: 100%; flex-wrap: wrap;">
                {{products_search_results}}
            </div>
        </div>
    </div>
    <?php include_once "views/shared/footers.php"; ?>
    <script>
        let url = new URL(window.location.href);
        let sortParam = url.searchParams.get("sort");

        if (sortParam == "topsales") {
            let filterButtons = document.querySelectorAll(".filter-button");

            filterButtons.forEach((filterButton) => {
                filterButton.removeAttribute("active");
                if (filterButton.innerText == "Top Sales") filterButton.setAttribute("active", "");
            });
        } else if (sortParam == "relevance") {
            let filterButtons = document.querySelectorAll(".filter-button");

            filterButtons.forEach((filterButton) => {
                filterButton.removeAttribute("active");
                if (filterButton.innerText == "Relevance") filterButton.setAttribute("active", "");
            });
        } else if (sortParam == "latest") {
            let filterButtons = document.querySelectorAll(".filter-button");

            filterButtons.forEach((filterButton) => {
                filterButton.removeAttribute("active");
                if (filterButton.innerText == "Latest") filterButton.setAttribute("active", "");
            });
        } else if (sortParam == "price-asc" || sortParam == "price-dsc") {
            let priceFilter = document.querySelector("select#price-filter");
            let filterButtons = document.querySelectorAll(".filter-button");

            filterButtons.forEach((filterButton) => {
                filterButton.removeAttribute("active");
            });

            let priceFilterChildren = priceFilter.children;

            for (let i = 0; i < priceFilterChildren.length; i++) {
                let option = priceFilterChildren[i];

                if (option.value === "asc" && sortParam === "price-asc") option.setAttribute("selected", "");
                else if (option.value === "dsc" && sortParam === "price-dsc") option.setAttribute("selected", "");
            }
        } else if (sortParam == null) {
            let filterButtons = document.querySelectorAll(".filter-button");

            filterButtons.forEach((filterButton) => {
                filterButton.removeAttribute("active");
                if (filterButton.innerText == "Relevance") filterButton.setAttribute("active", "");
            });
        } else {
            let filterButtons = document.querySelectorAll(".filter-button");

            filterButtons.forEach((filterButton) => {
                filterButton.removeAttribute("active");
            });
        }

        function selectFilter(button) {
            let filterButtons = document.querySelectorAll(".filter-button");

            filterButtons.forEach((filterButton) => {
                filterButton.removeAttribute("active");
            });

            if (button.classList.contains("filter-button")) button.setAttribute("active", "");

            let url = new URL(window.location.href);

            if (button.innerText == "Relevance") url.searchParams.set("sort", "relevance");
            else if (button.innerText == "Latest") url.searchParams.set("sort", "latest");
            else if (button.innerText == "Top Sales") url.searchParams.set("sort", "topsales");
            else if (button.value == "dsc") url.searchParams.set("sort", "price-dsc");
            else if (button.value == "asc") url.searchParams.set("sort", "price-asc");

            window.location.href = url.href;
        }
    </script>
</body>

</html>