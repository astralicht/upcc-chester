<?php

namespace Main\Controllers;

use Main\Models\CreateModel;

session_start();

class CreateController {

    function user($data) { return (new CreateModel)->user($data); }
    
}
