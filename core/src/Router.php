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

    protected $routeTable;
    protected $defaultRoute;

    private function __construct()
    {
        $this->core = Core::getInstance();
        $module_list = $this->core->getModuleList();
        foreach ($module_list as $name) {
            $module_name = $name . "\\Base";
            $module_obj = new $module_name();
            $return = $module_obj->route();
            foreach ($return as $match => $route) {
                $this->routeTable[$match] = $route;
            }
        }
        $this->defaultRoute = '\fairypawprints\Fairy::returnValue';
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
        $break = explode(":", $this->matchModule());
        $instantiate = new $break[0];
        $method = $break[2];
        if (!method_exists($instantiate, $method)) {
            throw new \Exception ('Unable to execute matched route');
        }
        return $instantiate->{$method}();
    }

    protected function matchModule() {
        $current_path = $_SERVER['REQUEST_URI'];
        $breakdown = explode("/", $current_path);
        $initial = "";
        foreach ($breakdown as $component) {
            if (!empty($component)) {
                if ($component !== "wolfapi") {
                    $match[] = $initial . $component;
                    $initial = $component . "/";
                }
            }
        }

        krsort($match);
        foreach ($match as $lookfor) {
            if (!empty($this->routeTable[$lookfor])) {
                return $this->routeTable[$lookfor];
            }
        }
        return $this->defaultRoute;
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
        ob_clean();
        header('Content-Type: application/json');
        echo $output_string;
        exit;
    }
}
