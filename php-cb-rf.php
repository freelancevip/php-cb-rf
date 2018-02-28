<?php

/**
 * Class PHP_CB_RF
 */
class PHP_CB_RF {
	/**
	 * @var string
	 */
	private $cache_path;

	/**
	 * PHP_CB_RF constructor.
	 */
	function __construct() {
		$this->cache_path = dirname( __FILE__ ) . "/cache.dat";
	}

	/**
	 * Return courses for currencies
	 * function_name('USD', 'EUR')
	 *
	 * @param array ...$char_codes
	 *
	 * @return array
	 */
	function get( ...$char_codes ) {
		$data = $this->_get_cache();

		if ( empty( $data ) ) {
			return array();
		}

		$array = array();
		foreach ( $char_codes as $code ) {
			// TODO: Тут добавлять остальные данные отсюда https://www.cbr-xml-daily.ru/daily_json.js
			$array[] = array(
				'charCode'   => $code,
				'actual'     => $data->Valute->{$code}->Value,
				'yesterdays' => $data->Valute->{$code}->Previous,
				'units'      => $data->Valute->{$code}->Nominal
			);
		}

		return $array;
	}

	/**
	 * Update courses
	 */
	function update() {
		$data = $this->_remote_get();
		if ( $this->validate( $data ) ) {
			$this->_save_cache( $data );
		}
	}

	/**
	 * Save data to cache
	 *
	 * @param $data
	 */
	private function _save_cache( $data ) {
		file_put_contents( $this->cache_path, serialize( $data ) );
	}

	/**
	 * Get data from cache
	 * @return mixed
	 */
	private function _get_cache() {
		if ( ! file_exists( $this->cache_path ) ) {
			file_put_contents( $this->cache_path, serialize( array() ) );
		}

		return unserialize( file_get_contents( $this->cache_path ) );
	}

	/**
	 * Load remote data
	 * @return bool|mixed
	 */
	private function _remote_get() {
		$content = @file_get_contents( 'https://www.cbr-xml-daily.ru/daily_json.js' );
		$json    = json_decode( $content );
		if ( json_last_error() === JSON_ERROR_NONE ) {
			return $json;
		}

		return false;
	}

	/**
	 * Check data is valid
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	private function validate( $data ) {
		if ( ! $data ) {
			return false;
		}
		if ( ! isset( $data->Valute ) ) {
			return false;
		}

		return true;
	}
}
