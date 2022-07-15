<?php

namespace Main\Controllers;

use Main\Models\UpdateModel;

session_start();

class UpdateController {

    function clientInfo($data) { return (new UpdateModel)->clientInfo($data); }
    function orderStatus($data) { return (new UpdateModel)->orderStatus($data); }
    function product($data) { return (new UpdateModel)->product($data); }
    
}
