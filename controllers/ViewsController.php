<?php
namespace Main\Controllers;

use Main\Models\CreateModel;

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
    function home(): string { return self::getFile('views/home/index.scale.php'); }
    function store(): string { return self::getFile('views/store/index.scale.php'); }
    function login(): string { return self::getFile('views/login/index.scale.php'); }
    function viewProduct(): string { return self::getFile('views/store/view.scale.php'); }
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

}