<?

namespace Lib\Capcha;

use Lib\Capcha\ICapcha;

class ReCapcha implements ICapcha
{

	private const _SECRET_KEY = '6Lcob3kpAAAAAMRKFAbMqISGBYtrRIy5MRW4NvpP';

	public function service(string $token): bool
	{
		if( 0 === strlen($token) ){
			return false;
		}
		$this->_checkSecretKey();
		return $this->_makeRequest($token);
    }

	public function _checkSecretKey(): void
	{
		if(self::_SECRET_KEY === 'SECRET_KEY'){
			die('Не установлен секрктный ключ');
		}
    }

	public function _makeRequest(string $token): bool
	{
		$out = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . self::_SECRET_KEY . '&response=' . $token);
		$out = json_decode($out);
		return ($out->success == true);
    }
}