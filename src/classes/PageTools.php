<?php

require_once( __DIR__ . '/../conf/config.php' );
require_once( __DIR__ . '/Sparql.php' );
require_once( __DIR__ . '/Messages.php' );
require_once( __DIR__ . '/../libs/smarty/Smarty.class.php' );

/**
 * page tools class
  */
class PageTools {

	public static $KEY_OBJECT = 'object';

	/**
	 * shows page
	 */
	public static function showPage( $template ) {
		if( !array_key_exists( self::$KEY_OBJECT, $_REQUEST ) ) {
			echo Messages::$ERROR_PARAMETER_IS_NOT_SET;
			return;
		}
		$object = $_REQUEST[ self::$KEY_OBJECT ];

		$parameters = array(
			'object' => $object
		);

		$smarty = new Smarty();
		$smarty->assign( $parameters );
		$query = $smarty->fetch( __DIR__ . '/../templates/sparql/' . $template . '.sparql.tpl' );

		$sparql = new Sparql( $query );
		$sparql->execute();

		$result = $sparql->getResultSet();

		if( $result == null || count( $result ) == 0 ) {
			echo Messages::$ERROR_NO_DATA;
			return;
		}

		$smarty = new Smarty();
		$smarty->assign( $result[ 0 ] );
		$smarty->display( __DIR__ . '/../templates/html/' . $template . '.html.tpl' );
	}
}

?>