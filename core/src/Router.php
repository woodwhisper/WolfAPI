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
    static protected $myself;
    protected $core;

    private function __construct()
    {
        $this->core = Core::getInstance();
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

    /**
     * Default output for the moment.
     */
    public function runOutput($output, $success = TRUE)
    {
        $successString = $success ? 'success' : 'failure';
        $output_array = ['status' => $successString, 'response' => $output];
        if ($this->core->amTiming()) {
            $output_array['execution_time'] = $this->core->getTime();
        }
        $output_string = json_encode($output_array);
        if (empty($output_string)) {
            throw new \Exception ('Unable to compile output array');
        }
        header('Content-Type: application/json');
        echo $output_string;
        exit;
    }
}
