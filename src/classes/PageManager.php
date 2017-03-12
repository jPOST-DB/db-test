<?php

require_once( __DIR__ . '/../conf/config.php' );
require_once( __DIR__ . '/Manager.php' );


/**
 *  ページ管理クラス
 */
class PageManager extends Manager {
	/**
	 *  get pages
	 */
	public function getPages()
	{
		$pages = Config::$PAGES;

		$array = array();

		foreach($pages as $page)
		{
			array_push(
				$array,
				array(
					'page' => $page,
					'name' => ucfirst( $page )
				)
			);
		}

		return $array;
	}
}

?>
