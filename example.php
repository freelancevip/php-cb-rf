<?php
require_once dirname( __FILE__ ) . '/php-cb-rf.php';

$cbrf = new PHP_CB_RF();

$data = $cbrf->get( 'USD', 'EUR', 'AUD' );

if ( ! empty( $data ) ) {
	echo '<pre>';
	print_r( $data );
}