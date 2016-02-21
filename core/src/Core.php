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
    protected static $myself;

    // @var float Time started.
    protected $timerStart;
    // @var bool Am I recording time.
    protected $timing;
    protected $output;

    protected $moduleFile = 'modules.data';

    private function __construct()
    {
        // Initalization functions live here.
        $this->timerStart = microtime();
        $this->timing = true;

        $loadList = file($this->moduleFile);
        foreach ($loadList as $line) {
            $temp = explode(":", $line);
            if (count($temp) == 2){
                $file = trim($temp[0])."/src/".trim($temp[1]).".php";
                if (file_exists($file)) {
                    include $file;
                }
            }
        }
    }

    static function getInstance() {
        if (empty(self::$myself)) {
            self::$myself = new Core();
        }
        return self::$myself;
    }

    public function run()
    {
        try {
            $router = Router::getInstance();
            $this->output = $router->runModule();
            $router->runOutput($this->output);
        } catch (\RuntimeException $e) {
            $error_array = ['message' => $e->getMessage()];
            if ($this->debug) {
                $error_array['file'] = $e->getFile();
                $error_array['line'] = $e->getLine();
            }
            $router->runOutput($error_array, FALSE);
        }
    }

    /**
     * Get the time since the beginning of the execution.
     */
    public function getTime() {
        $now = microtime();
        $time = $now - $this->timerStart;
        return $time;
    }

    public function amTiming() {
        return $this->timing;
    }

}
