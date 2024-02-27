<?php

declare(strict_types=1);

namespace Lib\Capcha;


interface ICapcha
{
	public function service(string $token);
}

