<?

namespace Lib\Capcha;

use Lib\Capcha\ICapcha;

class YandexCapcha implements ICapcha
{
	private const _SECRET_KEY = 'SECRET_KEY';

	public function service(string $token): bool
	{
		if(0 == strlen($token)){
			return false;
		}
		$this->_checkSecretKey();
        return $this->_makeRequest($token);
    }

	private function _checkSecretKey(): void
	{
		if(self::_SECRET_KEY === 'SECRET_KEY'){
			die('Не установлен секрктный ключ');
		}
    }

	private function _makeRequest(string $token): bool
	{
		$ch = curl_init();
        $args = http_build_query([
			"secret" => self::_SECRET_KEY,
            "token" => $token,
        ]);

        curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?$args");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);

        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpcode == 200)
	}
}


