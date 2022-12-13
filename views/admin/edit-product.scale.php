<?php

use Main\Models\FetchModel;

session_start();
if (!isset($_SESSION["type"]) || $_SESSION["type"] !== "ADMIN") header("Location: ../error/403");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("views/shared/headers.php"); ?>
    <style>
        #message-box {
            display: none;
            opacity: 0;
            transition: opacity .15s;
        }
    </style>
    <title>Edit Product #<?php echo $_GET["id"]; ?> | ISA Admin</title>
</head>

<body back-light>
    <div flex="h">
        <?php include_once("views/shared/admin_nav.php"); ?>
        <div flex="v" fullwidth nogap>
            <div main flex="v">
                <div flex="h" v-center>
                    <button onclick="history.back()" contain="secondary" small button flex="h" v-center style="height: fit-content; width: fit-content; border-radius: var(--border-radius);"><img src="../views/assets/img/arrow-right.webp" style="transform: rotate(180deg);" alt=""></button>
                    <h1>Edit Product #<?php echo $_GET["id"]; ?></h1>
                </div>
                <img src="" alt="" id="product-image" style="height: 300px; width: 300px; box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2); flex-shrink: 0; object-fit: cover;">
                <form action="../upload/image" method="POST" enctype="multipart/form-data" flex="v">
                    <input type="file" name="image-input" id="image-input" form-input style="width: 300px; background-color: #ccc">
                    <input type="hidden" value="PRODUCT" name="image-type" id="image-type">
                    <input type="hidden" value="" name="old-image-path" id="old-image-path">
                    <input type="hidden" value="<?php echo $_GET["id"]; ?>" name="id" id="product-id">
                    <button type="submit" id="product-image-upload" form-input button contain="info" small style="width: 300px; border-radius: var(--border-radius);">Upload photo</button>
                </form>
                <form flex="v" onsubmit="submitProduct(); return false;">
                    <div id="message-box" bordered fullwidth dark-text dark-text-all></div>
                    <div form-group>
                        <div flex="h" v-center>
                            <h3 nomargin>Name</h3>
                            <i style="color: red;">*Required</i>
                        </div>
                        <input type="text" id="name" form-input placeholder="Enter name here" required>
                    </div>
                    <div flex="h">
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Product Type</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <select id="product-type" form-input required style="width: 250px;">
                                <option value="NULL">Select type</option>
                            </select>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Material</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="material" form-input placeholder="Enter material here" required>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Brand</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="brand" form-input placeholder="Enter brand here" required>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Connection Type</h3>
                            </div>
                            <input type="text" id="connection-type" form-input placeholder="Enter connection type here">
                        </div>
                    </div>
                    <div flex="h">
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Length</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="length" form-input placeholder="Enter length here" required>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Width</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="width" form-input placeholder="Enter width here" required>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Thickness</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="thickness" form-input placeholder="Enter thickness here" required>
                        </div>
                    </div>
                    <div flex="h">
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Unit Price</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="number" step="0.01" id="unit-price" form-input placeholder="Enter unit price here" required>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Shop</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <select id="shop" form-input required style="width: 250px;">
                                <option value="NULL">Select type</option>
                                <?php
                                $FetchModel = new FetchModel();
                                $rows = $FetchModel->shops()["rows"];
                                foreach ($rows as $row) {
                                    $id = $row["id"];
                                    $name = $row["name"];
                                    echo "<option value='$id'>$name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <b>Company Details</b>
                    <div flex="h">
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Company Name</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="company-name" placeholder="Enter company name here" form-input required>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Office Address</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="company-address" placeholder="Enter company address here" form-input required>
                        </div>
                        <div form-group>
                            <div flex="h" v-center>
                                <h3 nomargin>Contact Number</h3>
                                <i style="color: red;">*Required</i>
                            </div>
                            <input type="text" id="company-number" placeholder="Enter company number here" form-input required>
                        </div>
                    </div>
                    <div form-group fullwidth flex="v" h-end>
                        <button type="submit" contain="good" button>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div contain="dark" fullwidth sharp-edges>
        <div id="copyright" style="text-align: right; color: #aaa; font-size: 0.8em;">
            Copyright © 2022 | All rights reserved.
        </div>
    </div>
    <script>
        fetch("../api/product-types").then(response => response.text()).then(json => {
            try {
                json = JSON.parse(json);
            } catch (error) {
                console.error(json);
            }

            if (json["status"] == 200) {
                populateProductTypes(json["rows"]);
            }
        });


        let productId = document.querySelector("input#product-id").value;
        setTimeout(() => {
            fetch(`../api/product?id=${productId}`).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch {
                    console.error(json);
                    return;
                }

                let product = json["rows"][0];

                document.querySelector("input#name").value = product["name"];
                document.querySelector("input#material").value = product["material"];
                document.querySelector("input#length").value = product["length"];
                document.querySelector("input#width").value = product["width"];
                document.querySelector("input#thickness").value = product["thickness"];
                document.querySelector("input#brand").value = product["brand"];
                document.querySelector("input#connection-type").value = product["connection_type"];
                document.querySelector("input#unit-price").value = product["unit_price"];
                document.querySelector("input#company-name").value = product["company_name"];
                document.querySelector("input#company-address").value = product["office_address"];
                document.querySelector("input#company-number").value = product["contact_number"];
                document.querySelector("input#old-image-path").value = `${product["image_path"]}`;
                document.querySelector("img#product-image").src = `../${product["image_path"]}`;

                let shopSelectOptions = document.querySelector("select#shop").children;

                for (let shopSelectOption of shopSelectOptions) {
                    if (shopSelectOption.value == product["shop_id"]) shopSelectOption.setAttribute("selected", "");
                }

                let productTypeOptions = document.querySelector("select#product-type").children;

                for (let productTypeOption of productTypeOptions) {
                    if (productTypeOption.value == product["type_id"]) productTypeOption.setAttribute("selected", "");
                }
            });
        }, 10);


        function populateProductTypes(types = null) {
            if (types == null) return;

            const PRODUCT_TYPES_SELECT = document.querySelector("select#product-type");

            for (let index = 0; index < types.length; index++) {
                let option = document.createElement("option");
                option.innerText = types[index]["name"];
                option.value = types[index]["id"];

                PRODUCT_TYPES_SELECT.appendChild(option);
            }
        }


        function submitProduct() {
            const FORM = document.querySelector("form");
            const INPUT_FIELDS = document.querySelectorAll("input");
            const SELECTS = document.querySelectorAll("select");
            const MESSAGE_BOX = document.querySelector("#message-box");
            let inputs = {};

            if (INPUT_FIELDS.length !== 0) {
                INPUT_FIELDS.forEach((field) => {
                    inputs[field.id] = field.value;
                });
            }

            if (SELECTS.length !== 0) {
                SELECTS.forEach((field) => {
                    inputs[field.id] = field.value;
                });
            }

            inputs["product-id"] = document.querySelector("input#product-id").value;

            fetch("../api/editproduct", {
                "method": "POST",
                "Content-Type": "application/json; charset=UTF-8",
                "body": JSON.stringify(inputs),
            }).then(response => response.text()).then(json => {
                try {
                    json = JSON.parse(json);
                } catch (error) {
                    console.error(json);
                }

                if (json["status"] != 200) {
                    MESSAGE_BOX.setAttribute("contain", "danger");
                    MESSAGE_BOX.innerText = json["message"];
                    fadeInOut(MESSAGE_BOX);
                    return;
                }

                MESSAGE_BOX.setAttribute("contain", "good");
                MESSAGE_BOX.innerHTML = `Product <i>"${inputs["name"]}"</i> updated successfully`;
                fadeInOut(MESSAGE_BOX);
                FORM.reset();
            });
        }
    </script>
</body>

</html>