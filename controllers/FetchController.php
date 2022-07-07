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
    function featuredProducts() { return (new FetchModel)->featuredProducts(); }
    function productsFilterOnly($data) { return (new FetchModel)->productsFilterOnly($data); }
    function allproductIds() { return (new FetchModel)->allProductIds(); }
    
}
