<?php

require_once( __DIR__ . '/../conf/config.php' );
require_once( __DIR__ . '/Sparql.php' );
require_once( __DIR__ . '/Messages.php' );
require_once( __DIR__ . '/../libs/smarty/Smarty.class.php' );

/**
 * page tools class
  */
class PageTools {

	/**
	 * shows dataset page
	 */
	public static function showDatasetPage() {
		if( !array_key_exists( 'id', $_REQUEST ) ) {
			echo Messages::$ERROR_PARAMETER_IS_NOT_SET;
			return;
		}
		$id = $_REQUEST[ 'id' ];

		$parameters = array(
			'id' => $id
		);

		$smarty = new Smarty();
		$smarty->assign( $parameters );
		$query = $smarty->fetch( __DIR__ . '/../templates/sparql/dataset.sparql.tpl' );

		$sparql = new Sparql( $query );
		$sparql->execute();

		$result = $sparql->getResultSet();

		if( $result == null || count( $result ) == 0 ) {
			echo Messages::$ERROR_NO_DATA;
			return;
		}

		$smarty = new Smarty();
		$smarty->assign( $result[ 0 ] );
		$smarty->display( __DIR__ . '/../templates/html/dataset.html.tpl' );
	}
}

?>