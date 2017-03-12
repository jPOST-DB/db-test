<?php

require_once( __DIR__ . '/../conf/config.php' );


/**
 *  管理クラス
 */

class Manager {
	public static $KEY_SUCCESS            = 'success';
	public static $KEY_MESSAGE            = 'message';
	public static $KEY_RESULT             = 'result';

	/**
	 * creates result object
	 * @param unknown $success
	 * @param unknown $message
	 * @param unknown $result
	 * @return
	 */
	public static function createResult( $success, $message, $result ) {
		$result = array(
			self::$KEY_SUCCESS => $success,
			self::$KEY_MESSAGE => $message,
			self::$KEY_RESULT  => $result
		);

		return $result;
	}
}

?>