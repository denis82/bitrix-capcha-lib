<?php

namespace Lib\Capcha;

use Lib\Capcha\ICapcha;

class CapchaFactory
{

    public static function make(string $capchaTitle): ?ICapcha
    {
        $ClassName = self::_getClassWithNamespace(strtoupper($capchaTitle));
		var_dump($ClassName);
        if (class_exists($ClassName)) {
            return new $ClassName;
        }
        return null;
    }

	private static function _getClassWithNamespace($ClassName){

        $class = new \ReflectionClass(__class__);
        return implode('',[$class->getNamespaceName(),'\\', $ClassName]);
    }
}