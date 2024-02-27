<?php


class Autoload
{
    public const ROUTES = 
        [
            // ключ - имя класса с простанством имен, значение - путь относительно корня сайта к файлу
			'Lib\Capcha\ICapcha' => '/local/php_interface/lib/capcha/ICapcha.php',
		    'Lib\Capcha\CapchaFactory' => '/local/php_interface/lib/capcha/CapchaFacroty.php',
		    'Lib\Capcha\YandexCapcha' => '/local/php_interface/lib/capcha/YandexCapcha.php',
		    'Lib\Capcha\ReCapcha' => '/local/php_interface/lib/capcha/ReCapcha.php',
        ];
}
