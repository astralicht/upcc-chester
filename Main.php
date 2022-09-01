<?php
namespace Main;

use Main\Config;
use Main\Routes;
use Main\Resource;
use Main\Controllers\Controller;

require_once realpath("vendor/autoload.php");

/**
 * Main class containing the system.
 */
class Main {

    function __construct() {
        $Config = new Config();
        $Routes = new Routes();
        $Controller = new Controller();
        $Resource = new Resource();
        $data = null;

        $URI_OFFSET = $Config->getURIOffset();
        $URI = $_SERVER["REQUEST_URI"];
        $URI_array = explode("/", $URI);

        for ($i = 0; $i < ["OFFSET-2" => 2, "OFFSET-1" => 1][strtoupper($URI_OFFSET)]; $i++) array_shift($URI_array);

        $URI = implode("/", $URI_array);

        if (empty($URI)) {
            header("Location:" . $Routes->getRoute("default"));
            return;
        }

        if (count($URI_array) === 1 && self::isApiRequest($URI_array[0]) === false) {
            header("Location:" . $URI . "/index");
            return;
        }

        $route = $Routes->getRoute($URI);

        if ($route === null && self::isApiRequest($URI_array[0]) === true) {
            $Resource = $Controller->getResource($Routes->getRoute("api/error/404"));
            echo $Resource->getData();
            return;
        }

        if ($route === null && self::isApiRequest($URI_array[0]) !== true) {
            $Resource = $Controller->getResource($Routes->getRoute("error/404"));
            echo $Resource->getData();
            return;
        }

        if ($route !== null && self::isApiRequest($URI_array[0]) !== true) {
            $Resource = $Controller->getResource($route);
            echo $Resource->getData();
            return;
        }

        // This line is used to get POST contents sent from JS HTTP requests.
        !empty($_POST) ?: $_POST = file_get_contents("php://input");

        $Resource = $Controller->getResource($route, $_GET, $_POST);

        $data = null;
        if ($Resource->getType() !== null) $data = json_encode($Resource->getData());
        else $data = $Resource->getData();
        echo $data;
    }

    private function isApiRequest($first_URI_value) {
        if ($first_URI_value === "api") return true;
        else return false;
    }

    /**
     * Fetches resource from cache.
     * @param Resource $Resource
     * 
     * =+= This function may be included in a future update including a template engine. =+=
     */
    // private function fetchFromCache($Resource) : Resource {
    //     // Try to refrain using include_once as much as possible on dynamic or mutable resources.
    //     return include_once("views/cache/".$Resource->getName().".php");
    // }

}

$Main = new Main();