<?php
/**
 * Created by PhpStorm.
 * User: wolfie
 * Date: 21/02/2016
 * Time: 3:23 PM
 */

namespace WolfAPI;


class Base
{
    protected $loadFiles;
    protected $module = '';

    public function __construct()
    {
        foreach ($this->loadFiles as $filename) {
            $path = 'module/' . $this->module. '/src/' . $filename;
            if (file_exists($path)) {
                include_once $path;
            }
        }
    }

}
