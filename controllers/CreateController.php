<?php

namespace Main\Controllers;

use Main\Models\CreateModel;

session_start();

class CreateController {
    
    function user($data) { return (new CreateModel)->user($data); }
    function cartItem($data) { return (new CreateModel)->cartItem($data); }
    function productType($data) { return (new CreateModel)->productType($data); }
    function product($data) { return (new CreateModel)->product($data); }
    function productTags($data) { return (new CreateModel)->productTags($data); }
    function order($data) { return (new CreateModel)->order($data); }
    function history($data) { return (new CreateModel)->history($data); }
    function adminNewUser($data) { return (new CreateModel)->adminNewUser($data); }
    function clientOrder($data) { return (new CreateModel)->clientOrder($data); }
    
}
