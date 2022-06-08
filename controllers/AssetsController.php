<?php
namespace Main\Controllers;

/**
 * Handles view requests made for Arkan integrated views.
 */
class AssetsController {

    /**
     * @method private getAsset()
     * @param string $path
     */
    private static function getAsset($path, $asset_type): void {
        if ($asset_type === "js") header("Content-Type: application/javascript; charset=UTF-8");
        if ($asset_type === "css") header("Content-Type: text/css; charset=UTF-8");
        if ($asset_type === "jpeg") header("Content-Type: image/jpeg;");
        if ($asset_type === "webp") header("Content-Type: image/webp;");
        include_once($path);
    }

    public function js($data): void { self::getAsset("views/assets/js/".$data["name"], "js"); }
    public function css($data): void { self::getAsset("views/assets/css/".$data["name"], "css"); }
    public function img($data): void { self::getAsset("views/assets/img/".$data["name"], $data["type"]); }
}