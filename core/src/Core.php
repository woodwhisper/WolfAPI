<?php
/**
 * Created by PhpStorm.
 * User: wolfie
 * Date: 21/02/2016
 * Time: 3:23 PM
 */

namespace WolfAPI;


class Core
{
    protected $myself;

    private function __construct()
    {
        // Initalization functions live here.
    }

    static function getInstance() {
        if (empty(self::$myself)) {
            self::$myself = new Core();
        }
        return self::$myself;
    }

    function run()
    {
        $router = Router::getInstance();
        $this->output = $router->runModule();
    }

    function output()
    {
        $output_string = json_encode(['status' => 'success', 'response' => $this->output]);
        if (!empty($output_string)) {

        } else {
            $output_string = json_encode(['status' => 'failure']);
        }
        header('Content-Type: application/json');
        echo $output_string;
    }
}