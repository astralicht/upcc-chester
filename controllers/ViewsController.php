<?php
namespace Main\Controllers;

use Main\Models\CreateModel;
use Main\Models\FetchModel;

/**
 * Handles view requests made for Arkan integrated views.
 */
class ViewsController {

    /**
     * @method private getFile()
     * @param string $path
     */
    private static function getFile($path): string {
        ob_start();
        include_once $path;
        $view = ob_get_clean();
        return $view;
    }

    function error403(): string { return self::getFile('views/403/index.php'); }
    function error404(): string { return self::getFile('views/404/index.php'); }
    function error500(): string { return self::getFile('views/500/index.php'); }
    function home(): string { return self::getFile('views/home/index.scale.php'); }
    function products(): string { return self::getFile('views/products/index.scale.php'); }
    function login(): string { return self::getFile('views/login/index.scale.php'); }
    function viewProduct(): string { return self::getFile('views/products/view.scale.php'); }
    function signup(): string { return self::getFile('views/signup/index.scale.php'); }
    function adminDashboard(): string { return self::getFile('views/admin/dashboard.scale.php'); }
    function adminUsers(): string { return self::getFile('views/admin/users.scale.php'); }
    function adminProducts(): string { return self::getFile('views/admin/products.scale.php'); }
    function adminProductTypes(): string { return self::getFile('views/admin/product-types.scale.php'); }
    function adminOrders(): string { return self::getFile('views/admin/orders.scale.php'); }
    function adminEditUser(): string { return self::getFile('views/admin/edit_user.scale.php'); }
    function adminNewProduct(): string { return self::getFile('views/admin/new-product.scale.php'); }
    function adminNewProductType(): string { return self::getFile('views/admin/new-product-type.scale.php'); }
    function adminViewOrder(): string { return self::getFile('views/admin/view-order.scale.php'); }
    function adminEditProduct(): string { return self::getFile('views/admin/edit-product.scale.php'); }
    function signupSuccess(): string { return self::getFile('views/signup/success.scale.php'); }
    function clientAccountDetails(): string { return self::getFile('views/client/account-details.scale.php'); }
    function clientOrderHistory(): string { return self::getFile('views/client/order-history.scale.php'); }
    function clientOrder(): string { return self::getFile('views/client/order.scale.php'); }
    function clientCart(): string { return self::getFile('views/client/cart.scale.php'); }
    function clientEditInfo(): string { return self::getFile('views/client/edit-info.scale.php'); }
    function agentDashboard(): string { return self::getFile('views/agent/dashboard.scale.php'); }
    function agentOrders(): string { return self::getFile('views/agent/orders.scale.php'); }
    function agentViewOrder(): string { return self::getFile('views/agent/view-order.scale.php'); }
    function agentNewOrder(): string { return self::getFile('views/agent/new-order.scale.php'); }
    function cookies(): string { return self::getFile('views/cookies/index.scale.php'); }
    function adminNewUser(): string { return self::getFile('views/admin/new-user.scale.php'); }
    function forgotPassword(): string { return self::getFile('views/login/forgot-password.scale.php'); }
    function resetEmailSent(): string { return self::getFile('views/login/reset-email-sent.scale.php'); }
    function invalidToken(): string { return self::getFile('views/auth/invalid-token.scale.php'); }
    function notLoggedIn(): string { return self::getFile('views/auth/not-logged-in.scale.php'); }
    function resetPassword(): string { return self::getFile('views/auth/reset-password.scale.php'); }
    function passwordResetSuccessful(): string { return self::getFile('views/auth/successful-password-reset.scale.php'); }

    function search() {
        $FetchModel = new FetchModel();
        $data = $FetchModel->search();

        $view = self::getFile('views/search/results.scale.php');
        $param = $_GET["param"];

        $shops = $data["shops"];
        $view = str_replace("{{search_param}}", $param, $view);

        $cards = "";

        foreach($shops as $shop) {
            try {
                $card = file_get_contents("views/templates/_card_shop.html");
                $card = str_replace("{{shop_name}}", $shop["name"], $card);
                $card = str_replace("{{shop_img_path}}", $shop["image_path"], $card);
                $card = str_replace("{{shop_id}}", $shop["id"], $card);

                $rows = $FetchModel->shopProducts($shop["id"])["rows"];
                $card = str_replace("{{shop_products_count}}", count($rows), $card);

                $rating = $FetchModel->shopRating($shop["id"])["rows"][0]["rating"];

                if ($rating == null || $rating == "") $rating = 0.0;

                $card = str_replace("{{shop_rating}}", $rating, $card);

                $cards .= $card;
            } catch (\TypeError $e) {}
        }

        if ($cards == "") $view = str_replace("{{shops_search_results}}", "<i>No shops found.</i>", $view);
        else $view = str_replace("{{shops_search_results}}", $cards, $view);


        $products = $data["products"];
        $cards = "";

        foreach($products as $product) {
            try {
                $card = file_get_contents("views/templates/_card_product.html");
                $card = str_replace("{{product_name}}", $product["product_name"], $card);
                $card = str_replace("{{product_id}}", $product["product_id"], $card);
                $card = str_replace("{{product_img_path}}", $product["product_img_path"], $card);
                $card = str_replace("{{product_price}}", $product["product_price"], $card);

                if (isset($product["items_sold"])) {
                    $items_sold = $product["items_sold"];
                    $items_sold = "<i fullwidth flex='h' h-end>$items_sold sold</i>";
                    $card = str_replace("{{products_more_info}}", $items_sold, $card);
                }
                else if (isset($product["clicks"])) {
                    $clicks = $product["clicks"];
                    $clicks = "<i fullwidth flex='h' h-end>$clicks views</i>";
                    $card = str_replace("{{products_more_info}}", $clicks, $card);
                }
                $cards .= $card;
            } catch (\TypeError $e) {}
        }

        if ($cards == "") $view = str_replace("{{products_search_results}}", "<i>No products found.</i>", $view);
        else $view = str_replace("{{products_search_results}}", $cards, $view);

        return $view;
    }


    function viewShop(): string {
        $view = self::getFile('views/shops/view.scale.php');
        $id = $_GET["id"];

        $FetchModel = new FetchModel();
        $response = $FetchModel->shop($id);
        $shop = $response["rows"][0];

        foreach ($shop as $key => $value) {
            if (!str_contains($view, $key)) continue;
            $view = str_replace("{{".$key."}}", $value, $view);
        }

        return $view;
    }


    function shops() {
        return self::getFile("views/shops/index.scale.php");
    }

}