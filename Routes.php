<?php
namespace Main;

/**
 * Contains the routes to the controllers or wherever you point them to.
 */
class Routes {

    /**
     * @var array $List
     * Contains routes for the app.
     */
    private static array $List;

    public function __construct() {
        self::$List = [

            /**
             * URI => [Controller, function, HTTP request type],
             * GET requests can also be processed by adding a route.
             * e.g. "products/view?*" => ["ViewController", "viewProducts"]
             * 
             * To get rid of 'index' in URIs, simply remove it,
             * and still route it normally.
             * e.g. "products/index"
             * 
             * If URI length is more than one (1), do not leave a
             * trailing slash in the route as it will cause an error.
             */

            "error/403" => ["ViewsController", "error403"],
            "error/404" => ["ViewsController", "error404"],
            "api/error/403" => ["ApiController", "error403"],
            "api/error/404" => ["ApiController", "error404"],

            "api/assets/js?name=*" => ["AssetsController", "js", "GET"],
            "api/assets/css?name=*" => ["AssetsController", "css", "GET"],
            "api/assets/img?name=*&type=*" => ["AssetsController", "img", "GET"],
            "api/verifylogin" => ["AuthController", "login", "POST"],
            "api/users/count" => ["FetchController", "usersCount", "GET"],
            "api/products/count" => ["FetchController", "productsCount", "GET"],
            "api/orders/count" => ["FetchController", "ordersCount", "GET"],
            "api/users?filter=*&page=*&limit=*" => ["FetchController", "users", "GET"],
            "api/products?filter=*&page=*&limit=*" => ["FetchController", "products", "GET"],
            "api/orders?filter=*&page=*&limit=*" => ["FetchController", "orders", "GET"],
            "api/edituser" => ["UpdateController", "user", "POST"],
            "api/editproduct" => ["UpdateController", "product", "POST"],
            "api/removeuser" => ["DeleteController", "user", "POST"],
            "api/removeproduct" => ["DeleteController", "product", "POST"],
            "api/approveorder" => ["UpdateController", "approveOrder", "POST"],
            "api/declineorder" => ["UpdateController", "declineOrder", "POST"],
            "api/createuser" => ["CreateController", "user", "POST"],
            "api/createproduct" => ["CreateController", "products", "POST"],
            "api/companynatures" => ["FetchController", "companyNatures", "GET"],
            "api/uploads/img?name=*&type=*" => ["AssetsController", "imgUploaded", "GET"],
            "api/product?id=*" => ["FetchController", "product", "GET"],
            
            "default" => "home/index",
            "home/index" => ["ViewsController", "home"],
            "store/index" => ["ViewsController", "store"],
            "store/viewproduct?id=*" => ["ViewsController", "viewProduct"],
            "login/index" => ["ViewsController", "login"],
            "signup/index" => ["ViewsController", "signup"],
            "signup/success" => ["ViewsController", "signupSuccess"],
            "auth/logout" => ["AuthController", "logout"],
            "auth/loginredirect" => ["AuthController", "loginRedirect"],
            "admin/dashboard" => ["ViewsController", "adminDashboard"],
            "admin/users" => ["ViewsController", "adminUsers"],
            "admin/products" => ["ViewsController", "adminProducts"],
            "admin/orders" => ["ViewsController", "adminOrders"],
            "admin/edituser?id=*" => ["ViewsController", "adminEditUser"],
            "admin/editproduct?id=*" => ["ViewsController", "adminEditProduct"],
            "admin/removeusers" => ["ViewsController", "adminRemoveUsers"],
            "admin/removeproducts" => ["ViewsController", "adminRemoveProducts"],
        ];
    }

    /**
     * @method public getRoute()
     * Returns corresponding route in $List.
     * @param string $URI
     */
    public static function getRoute($URI) {
        $keys = array_keys(self::$List);
        foreach ($keys as $key) if (fnmatch($key, $URI)) return self::$List[$key];
        return null;
    }

}