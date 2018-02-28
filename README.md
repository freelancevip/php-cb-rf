# php-cb-rf
Информер курса валют по api ЦБ РФ.

### Установка
````
git clone https://github.com/freelancevip/php-cb-rf.git
````
Или посмотреть, как в example.php

### Использование

Для обновления курсов по крону:
````php
require_once dirname( __FILE__ ) . '/php-cb-rf.php';
$cbrf = new PHP_CB_RF();
$cbrf->update();
````

Для получения значений
````php
require_once dirname( __FILE__ ) . '/php-cb-rf.php';
$cbrf = new PHP_CB_RF();
$data = $cbrf->get( 'USD', 'EUR', 'AUD' );
if ( ! empty( $data ) ) {
	echo '<pre>';
	print_r( $data );
}
````