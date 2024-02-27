
## Методы установки виджета Yandex SmartCaptcha

```sh
<script src="https://smartcaptcha.yandexcloud.net/captcha.js?render=onload&onload=onloadFunction" defer></script>

<script>
  let widgetId;

  function onloadFunction() {
    if (!window.smartCaptcha) {
      return;
    }

    widgetId = window.smartCaptcha.render('captcha-container', {
      sitekey: '<ключ_клиентской_части>',
      invisible: true, // Сделать капчу невидимой
      callback: callback,
    });
  }

  function callback(token) {
    if (typeof token === "string" && token.length > 0) {
        // Отправить форму на бекенд
        console.log(token);
        document.querySelector('form').submit()
    }
  }
  
  function handleSubmit(event) {
    if (!window.smartCaptcha) {
      return;
    }

    window.smartCaptcha.execute(widgetId);
  }
</script>

<form id="form">
  <div id="captcha-container"></div>
  <button type="button" onclick="handleSubmit()">Submit</button>
</form>

```



 
# Вывод на сайте RECAPCHA

## Одна капча на странице

Чтобы вывести капчу в форме, нужно подключить api.js и добавить <div> c классом g-recaptcha и атрибутом data-sitekey с открытым ключом.


```sh
<script src="https://www.google.com/recaptcha/api.js"></script>
 
<form method="post" action="#">
	<input type="email">
	<div class="g-recaptcha" data-sitekey="КЛЮЧ_САЙТА"></div>
	<button type="submit">Отправить</button>
</form>
```

## Несколько recaptcha на странице

В таком случаи, в формах вставляется <div id="recaptcha-1"></div> и <div id="recaptcha-2"></div> и более, далее к ним подключается recaptcha JS-скриптом.


```sh
Форма #1
<form method="post" action="#">
	<input type="email">
	<div id="recaptcha-1"></div>
	<button type="submit">Отправить</button>
</form>
 
Форма #2
<form method="post" action="#">
	<input type="email">
	<div id="recaptcha-2"></div>
	<button type="submit">Отправить</button>
</form>
 
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit">
<script>
var onloadCallback = function(){
	var key = 'КЛЮЧ_САЙТА';
	grecaptcha.render('recaptcha-1', {
		'sitekey': key
	});
	grecaptcha.render('recaptcha-2', {
		'sitekey': key
	});
};
</script>
```


### Проверка заполнения капчи в PHP

После отправки формы, на стороне сервера, введённый ответ капчи (будет в $_POST['g-recaptcha-response']) нужно отправить на https://www.google.com/recaptcha/api/siteverify вместе с секретным ключом и получить положительный или отрицательный ответ. Данное действие можно реализовать двумя способами:

#### Вариант на curl (через POST)

```sh
$error = true;
$secret = 'СЕКРЕТНЫЙ_КЛЮЧ';
 
if (!empty($_POST['g-recaptcha-response'])) {
	$curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
	$out = curl_exec($curl);
	curl_close($curl);
	
	$out = json_decode($out);
	if ($out->success == true) {
		$error = false;
	} 
}    
 
if ($error) {
	echo 'Ошибка заполнения капчи.';
}
```
#### Вариант на file_get_contents

```sh
$error = true;
$secret = 'СЕКРЕТНЫЙ_КЛЮЧ';
 
if (!empty($_POST['g-recaptcha-response'])) {
	$out = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
	$out = json_decode($out);
	if ($out->success == true) {
		$error = false;
	} 
}
 
if ($error) {
	echo 'Ошибка заполнения капчи.';
}
```

### Проверка reCAPTCHA в JS/jQuery

Чтобы проверить правильность заполнения капчи перед отправкой формы, можно применить следующий код:

```sh
<script src="https://www.google.com/recaptcha/api.js"></script>
 
<form method="post" action="#" id="form">
	<input type="email">
	<div class="g-recaptcha" data-sitekey="КЛЮЧ_САЙТА"></div>
	<button type="submit">Отправить</button>
</form>
 
<script>
$('#form').submit(function(){
	var response = grecaptcha.getResponse();
	if(response.length == 0) {
		alert('Вы не прошли проверку CAPTCHA должным образом');
		return false;
	}
});
</script>
```


