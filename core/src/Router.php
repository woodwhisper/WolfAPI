<?php
/**
 * Created by PhpStorm.
 * User: wolfie
 * Date: 21/02/2016
 * Time: 3:31 PM
 */

namespace WolfAPI;


class Router
{
    protected $myself;

    private function __construct()
    {
    }

    static function getInstance() {
        if (empty(self::$myself)) {
            self::$myself = new Router();
        }
        return self::$myself;
    }

    /**
     * Based on current settings work out what module needs to be run, load it, then run it.
     */
    public function runModule(){
        return [];
    }
}
