<?php
namespace Main\Controllers;

use Main\Resource;

/**
 * Main controller class for retrieving resources.
 */
class Controller {

    /**
     * Returns either a freshly rendered resource or a resource from cache.
     * =+= This function can be paired with data caching in future updates. =+=
     */

    /**
     * @method public getResource()
     * @param array $route
     * @param array $GET_DATA
     * @param array $POST_DATA
     */
    public function getResource($route = null, $GET_DATA = null, $POST_DATA = null): Resource {
        try {
            $Controller = new ("Main\Controllers\\" . $route[0])();
        } catch (\Exception $e) {
            $Controller = null;
        }
        $function = $route[1];
        $request_type = $route[2];
        $data = null;

        if (isset($request_type) || !empty($request_type)){
            if ($request_type == "GET") $data = $GET_DATA;
            if ($request_type == "POST") $data = $POST_DATA;
        }

        $Resource = new Resource();

        if ($Controller === null) return $Resource;

        $Resource->set([
            "data" => $Controller->$function($data),
            "name" => (string)$function,
            "type" => $request_type,
        ]);

        return $Resource;
    }

}