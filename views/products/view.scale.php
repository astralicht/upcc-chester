<?php

use Main\Models\UpdateModel;

session_start();

$UpdateModel = new UpdateModel();
$UpdateModel->productClicks($_GET["id"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "views/shared/headers.php"; ?>
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
    </style>
    <title></title>
</head>

<body>
    <?php include_once("views/shared/nav.php"); ?>
    <input type="hidden" id="product-id" style="display: hidden;" value="<?php echo $_GET['id']; ?>">
    <div flex="v" main fullheight>
        <div flex="h">
            <button button contain="dark" small flex="h" v-center nogap onclick="history.back()"><img src="../views/assets/img/arrow-right.webp" alt="back" style="transform: rotate(180deg);">Back</button>
        </div>
        <div flex="h" style="gap: 1.4em">
            <div style="height: 300px; width: 300px; box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2); flex-shrink: 0;">
                <img src="" alt="" id="product-image" style="object-fit: cover;">
            </div>
            <div flex="v" style="gap: 1em; padding: 15px 0; width: 100%;">
                <div class="products-section" flex="v" style="gap: .7em;">
                    <h2 id="name" style="margin: 0;">Product Name</h2>
                    <div style="padding: 1em; background-color: #F5F5F5;">
                        <p nomargin>
                            <strong>Type:</strong>
                            <span id="type"></span>
                        </p>
                        <p nomargin>
                            <strong>Brand:</strong>
                            <span id="brand"></span>
                        </p>
                        <p nomargin>
                            <strong>Material:</strong>
                            <span id="material"></span>
                        </p>
                    </div>
                    <h2 id="price-header" style="margin: 0;">₱<span id="unit_price">0.00</span></h2>
                </div>
                <div class="products-section">
                    <div flex v-center nogap>
                        <button class="increment-controls" id="minus-increment" onclick="decrementItemCount()">
                            -
                        </button>
                        <input type="number" id="item_count" form-input sharp-edges style="background-color: #f5f5f5; width: 5em; height: 40px; font-size: 1em;
                            text-align: center;" value="1" placeholder="1">
                        <button class="increment-controls" id="plus-increment" onclick="incrementItemCount()">
                            +
                        </button>
                    </div>
                </div>
                <div class="products-section" flex="h" v-center>
                    <button button="secondary" style="gap: .5em; width: 200px; height: 3em;" flex="h" v-center onclick="showEmailPopup()">
                        <img src="../views/assets/img/email.webp" alt="email">
                        Email Now
                    </button>
                    <button button="good" style="gap: .5em; width: 200px; height: 3em;" flex="h" v-center onclick="checkAuth()">
                        <img src="../views/assets/img/add-to-cart.webp" alt="add to cart">
                        Add to Cart
                    </button>
                    <a href="../store/compare?param=&first=<?php echo $_GET["id"]; ?>&second=">Compare price with another product</a>
                </div>
                <div class="products-section">
                    <div id="popup-message" style="opacity: 0; display: none; padding: 1em 1.5em; transition: opacity .3s ease-in-out;" flex></div>
                </div>
                <div class="products-section" flex="v" style="gap: 0; padding: 1em 1.5em; background-color: #f5f5f5; border-radius: 5px;">
                    <div style="width: 100%;">
                        <h3 style="margin: .3em 0;">More Details</h3>
                        <hr style="border: 0; border-bottom: 1px solid #999;">
                        <div style="padding: 1em; background-color: #F5F5F5;">
                            <p nomargin>
                                <strong>Connection Type:</strong>
                                <span id="connection_type"></span>
                            </p>
                            <p nomargin>
                                <strong>Length:</strong>
                                <span id="length"></span>
                            </p>
                            <p nomargin>
                                <strong>Width:</strong>
                                <span id="width"></span>
                            </p>
                            <p nomargin>
                                <strong>Thickness:</strong>
                                <span id="thickness"></span>
                            </p>
                            <p nomargin>
                                <strong>Company:</strong>
                                <span id="company_name"></span>
                            </p>
                            <p nomargin>
                                <strong>Company Address:</strong>
                                <span id="office_address"></span>
                            </p>
                            <p nomargin>
                                <strong>Contact Details:</strong>
                                <span id="contact_number"></span>
                            </p>
                            <p nomargin>
                                <strong>Shop Name:</strong>
                                <span id="shop_name"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="email-popup-container" style="flex-shrink: 0;">
            <div id="email-popup" flex="v" style="flex-shrink: 0;">
                <div flex="h" h-end>
                    <div style="height: 50px; width: 50px; background-color: #333; cursor: pointer;" flex="h" h-center v-center onclick="hideEmailPopup()">
                        <img src="../views/assets/img/close.webp" alt="close">
                    </div>
                </div>
                <div flex="v" style="padding: 25px 35px;">
                    <div>
                        <h2 id="name">Product Name</h2>
                    </div>
                    <div>
                        <form onsubmit="return false" method="POST" id="email_form">
                            <div flex="v">
                                <input type="email" form-input id="email" placeholder="Email address" style="border-bottom: 1px solid #aaa; border-radius: 0;">
                                <input type="text" form-input id="phone_number" placeholder="Phone number" style="border-bottom: 1px solid #aaa; border-radius: 0;">
                                <textarea form-input id="message" placeholder="Type your message here" rows="3" style="border-bottom: 1px solid #aaa; border-radius: 0;"></textarea>
                                <div fullwidth flex="h" h-end>
                                    <button button="secondary" onclick="sendMail()">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "views/shared/footers.php"; ?>
    <script>
        let container_display = false;
        let id = document.querySelector("#product-id").value;

        fetch(`../api/product?id=${id}`)
            .then(response => response.json())
            .then(json => {

                // console.log(json)

                displayDataToDom(json)
            });

        function displayDataToDom(json) {
            if (json["status"] !== 200) return;
            if (json["rows"].length < 1) return;

            let product = json["rows"][0];
            let keys = Object.keys(product);

            document.title = `${product["name"]} | ISA Store`;

            for (let key of keys) {
                let element = document.querySelector(`#${key}`);

                if (key === "type_id") continue;
                if (key === "id") continue;

                if (product[key] === null || product[key] === "") {
                    if (element === null) continue;

                    element.innerText = "N/A";
                    continue;
                }

                if (key === "image_path") {
                    let image = document.querySelector("img#product-image");
                    image.src = `../${product[key]}`;
                    image.style.width = "300px";
                    image.style.height = "300px";
                    image.style.objectFit = "cover";
                    continue;
                }

                if (key === "image_name") {
                    let image = document.querySelector("img#product-image");
                    image.alt = product[key];
                    continue;
                }

                if (key === "type_id") continue;

                if (key === "shop_id") {
                    fetch(`../api/shop-details?id=${product[key]}`).then(response => response.text()).then(json => {
                        try {
                            json = JSON.parse(json);
                        } catch (error) {
                            console.error(error);
                            console.error(json);
                        }

                        let element = document.querySelector("#shop_name");
                        let shopName = json["rows"][0]["name"];

                        element.innerText = shopName;

                        return;
                    });
                    continue;
                }

                element.innerText = product[key];
            }
        }

        function decrementItemCount() {
            const item_count = document.querySelector("#item_count");
            if (item_count.value - 1 < 1) return;
            --item_count.value;
        }

        function incrementItemCount() {
            const item_count = document.querySelector("#item_count");
            ++item_count.value;
        }

        function showEmailPopup() {
            const email_popup_container = document.querySelector("#email-popup-container");
            fadeInFlex(email_popup_container);
            container_display = true;
        }

        function hideEmailPopup() {
            const email_popup_container = document.querySelector("#email-popup-container");
            email_popup_container.style.display = "flex";
            fadeOut(email_popup_container);
            container_display = false;
        }

        document.addEventListener("click", (event) => {
            if (!container_display) return;
            const email_popup_container = document.querySelector("#email-popup-container");
            let targetElement = event.target;
            if (targetElement == email_popup_container) hideEmailPopup();
        });

        function checkAuth() {
            const popup_message = document.querySelector("#popup-message");

            fetch("../api/checkauth")
                .then(response => response.json())
                .then(json => {
                    if (json["is_auth"] === "TRUE") return addToCart(id);
                    popup_message.setAttribute("contain", "danger");
                    popup_message.setAttribute("bordered", "");
                    popup_message.setAttribute("dark-text", "");
                    popup_message.innerHTML = "You are currently not logged in! Click <a href='../login/index'>here</a> to login.";
                    fadeInFlex(popup_message);
                });
        }

        function addToCart(id) {
            const popup_message = document.querySelector("#popup-message");
            let quantity = document.querySelector("#item_count").value;

            fetch(`../api/addtocart?product_id=${id}&quantity=${quantity}`)
                .then(response => response.json()).then(json => {
                    if (json["status"] !== 200) {
                        popup_message.setAttribute("contain", "danger");
                        popup_message.setAttribute("bordered", "");
                        popup_message.setAttribute("dark-text", "");
                        popup_message.innerHTML = "Something went wrong. Please try again in a while.";
                        fadeIn(popup_message);
                        setTimeout(() => {
                            fadeOut(popup_message);
                        }, 5150);

                        return;
                    }

                    document.querySelector("#cart-items-count").innerText = json["cart_count"];

                    popup_message.setAttribute("contain", "good");
                    popup_message.setAttribute("bordered", "");
                    popup_message.setAttribute("dark-text", "");
                    popup_message.innerHTML = "Successfully added to cart!";
                    fadeIn(popup_message);
                    setTimeout(() => {
                        fadeOut(popup_message);
                    }, 5150);
                });
        }

        function sendMail() {
            const email_inputs = document.querySelectorAll("#email_form input");
            const email_textareas = document.querySelectorAll("#email_form textarea");
            let inputs = {};
            email_inputs.forEach((input) => {
                inputs[input.id] = input.value;
            });
            email_textareas.forEach((input) => {
                inputs[input.id] = input.value;
            });
            fetch("back/sendMail.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        "details": inputs,
                    }),
                })
                .then(response => response.json())
                .then(json => {
                    if (json["response_code"] !== 200) return;
                    const popup_message = document.querySelector("#popup-message");
                    popup_message.style.backgroundColor = "#a5bff2";
                    popup_message.style.border = "2px solid #0f2755";
                    popup_message.innerHTML = "<div>Email sent successfully!</div>";

                    const email_popup_container = document.querySelector("#email-popup-container");
                    fadeOut(email_popup_container);
                    setTimeout(() => {
                        fadeIn(popup_message);
                    }, 150);
                });
        }
    </script>
</body>

</html>