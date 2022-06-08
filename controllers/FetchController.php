<?php

namespace Main\Controllers;

use Main\Models\FetchModel;

session_start();

class FetchController {

    function users($data) { return (new FetchModel)->users($data); }
    function products($data) { return (new FetchModel)->products($data); }
    function orders($data) { return (new FetchModel)->orders($data); }
    function usersCount() { return (new FetchModel)->usersCount(); }
    function productsCount() { return (new FetchModel)->productsCount(); }
    function ordersCount() { return (new FetchModel)->ordersCount(); }
    function companyNatures() { return (new FetchModel)->companyNatures(); }
    
}
