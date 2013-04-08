<?php

namespace MageTool;

class MageContainer
{
    private $app;
    private $magePath = 'app/Mage.php';

    public function setApp($app)
    {
        $this->app = $app;
    }

    public function getApp()
    {
        return $this->app ? $this->app : $this->create(function(){return \Mage::app();});
    }

    public function create(\Closure $factory)
    {
        if (!$this->includeIfExists($this->magePath)) {
            throw new \RuntimeException("Unable to locate Mage.php");
        }
        return $factory();
    }

    private function includeIfExists($file)
    {
        if (file_exists($file)) {
            return include $file;
        }
    }
}
