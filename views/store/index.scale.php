<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "views/shared/headers.php"; ?>
    <link rel="stylesheet" href="api/assets/css?name=main.css">
    <style>
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
            width: 250px;
            min-width: 250px;
        }

        .card .card-img {
            width: 250px;
            height: 250px;
        }

        .card .card-body {
            width: 250px;
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
                    <h2 class="header">Search Filter</h2>
                    <div>
                        <h3 class="header">Type</h3>
                        <hr>
                        <select form-input id="type_select">
                            <option value="NULL">Select type</option>
                        </select>
                    </div>
                    <div>
                        <h3 class="header">Brand</h3>
                        <hr>
                        <select form-input id="type_select">
                            <option value="NULL">Select brand</option>
                        </select>
                    </div>
                    <div>
                        <h3 class="header">Variant</h3>
                        <hr>
                        <select form-input id="type_select">
                            <option value="NULL">Select variant</option>
                        </select>
                    </div>
                    <div style="padding: 1em 0;">
                        <button button="secondary" fullwidth fullpadding white-text style="border-radius: 1000px; box-sizing: border-box;">Apply filters</button>
                    </div>
                </div>
            </div>
            <div>
                <div flex flex-wrap>
                    <div class="card" flex="v">
                        <img src="" alt="" class="card-img">
                        <div class="card-body" flex="v">
                            <span class="card-title">Item Name</span>
                            <div flex="h" h-center>
                                <a href="../store/view?productid=123" button="secondary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="card" flex="v">
                        <img src="" alt="" class="card-img">
                        <div class="card-body" flex="v">
                            <span class="card-title">Item Name</span>
                            <div flex="h" h-center>
                                <a href="../store/view?productid=123" button="secondary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="card" flex="v">
                        <img src="" alt="" class="card-img">
                        <div class="card-body" flex="v">
                            <span class="card-title">Item Name</span>
                            <div flex="h" h-center>
                                <a href="../store/view?productid=123" button="secondary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="card" flex="v">
                        <img src="" alt="" class="card-img">
                        <div class="card-body" flex="v">
                            <span class="card-title">Item Name</span>
                            <div flex="h" h-center>
                                <a href="../store/view?productid=123" button="secondary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="card" flex="v">
                        <img src="" alt="" class="card-img">
                        <div class="card-body" flex="v">
                            <span class="card-title">Item Name</span>
                            <div flex="h" h-center>
                                <a href="../store/view?productid=123" button="secondary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="card" flex="v">
                        <img src="" alt="" class="card-img">
                        <div class="card-body" flex="v">
                            <span class="card-title">Item Name</span>
                            <div flex="h" h-center>
                                <a href="../store/view?productid=123" button="secondary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "views/shared/footers.php"; ?>
</body>

</html>