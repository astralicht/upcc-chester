<?php

namespace Main\Controllers;

use Main\Models\FetchModel;

session_start();

class FetchController {

    function users($data) { return (new FetchModel)->users($data); }
    function products($data) { return (new FetchModel)->products($data); }
    function allOrders($data) { return (new FetchModel)->allOrders($data); }
    function clientOrders($data) { return (new FetchModel)->clientOrders($data); }
    function usersCount() { return (new FetchModel)->usersCount(); }
    function productsCount() { return (new FetchModel)->productsCount(); }
    function ordersCount() { return (new FetchModel)->ordersCount(); }
    function companyNatures() { return (new FetchModel)->companyNatures(); }
    function product($data) { return (new FetchModel)->product($data); }
    function user($data) { return (new FetchModel)->user($data); }
    function cartItemsCount() { return (new FetchModel)->cartItemsCount(); }
    function productTypes($data) { return (new FetchModel)->productTypes($data); }
    function productTypesAll() { return (new FetchModel)->productTypesAll(); }
    function clientCart($data) { return (new FetchModel)->clientCart($data); }
    function order($data) { return (new FetchModel)->order($data); }
    function featuredProducts($limit) { return (new FetchModel)->featuredProducts($limit); }
    function productsFilterOnly($data) { return (new FetchModel)->productsFilterOnly($data); }
    function allproductIds() { return (new FetchModel)->allProductIds(); }
    function typesAndBrands() { return (new FetchModel)->typesAndBrands(); }
    function isAccountEmail($email) { return (new FetchModel)->isAccountEmail($email); }
    function previousOrderedProducts($limit) { return (new FetchModel)->previousOrderedProducts($limit); }
    function search($param) { return (new FetchModel)->search($param); }
    function shopProductsCount($param) { return (new FetchModel)->shopProductsCount($param); }
    function notificationsUnread($data) { return (new FetchModel)->notificationsUnread($data); }
    function notificationsAll($data) { return (new FetchModel)->notificationsAll($data); }
    function adminShops($data) { return (new FetchModel)->adminShops($data); }
    function shopsCount($data) { return (new FetchModel)->shopsCount($data); }
    function adminShop($id) { return (new FetchModel)->shop($id); }
    function shopDetails($data) { return (new FetchModel)->shop($data); }

}
