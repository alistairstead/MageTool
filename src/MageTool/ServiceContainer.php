<?php

namespace MageTool;

use Closure;
use ArrayAccess;
use InvalidArgumentException;

class ServiceContainer implements ArrayAccess
{
    private $app;
    private $magePath = 'app/Mage.php';

    private $values = array();

    public function has($id)
    {
        return isset($this->values[$id]);
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new InvalidArgumentException(sprintf(
                "Service/Parameter `%s` not found.", $id
            ));
        }

        $value = $this->values[$id];

        if (is_array($value)) {
            return array_map(array($this, 'unwrapItem'), $value);
        }

        return $this->unwrapItem($value);
    }

    public function set($id, $value)
    {
        return $this->values[$id] = $value;
    }

    public function remove($id)
    {
        unset($this->values[$id]);
    }

    public function extend($id, $extension)
    {
        if (!$this->has($id)) {
            throw new InvalidArgumentException(sprintf(
                "Service collection `%s` not defined.", $id
            ));
        }

        $value = (array) $this->values[$id];
        $value[] = $extension;

        $this->values[$id] = $value;
    }

    public function share(Closure $factory)
    {
        return function($c) use($factory) {
            static $object;
            return $object ?: $object = $factory($c);
        };
    }

    public function offsetExists($id)
    {
        return $this->has($id);
    }

    public function offsetSet($id, $value)
    {
        $this->set($id, $value);
    }

    public function offsetGet($id)
    {
        $this->get($id);
    }

    public function offsetUnset($id)
    {
        $this->remove($id);
    }

    public function __invoke($id, $value = null)
    {
        if (null === $value) {
            return $this->get($id);
        }

        $this->set($id, $value);
    }

    private function unwrapItem($value)
    {
        return $value instanceof Closure ? $value($this) : $value;
    }

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
