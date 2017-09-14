<?php


/**
 * table information class
 */
class TableInfo implements JsonSerializable {
	/** table name */
	private $name;
	/** table title */
	private $title;
	/** data url */
	private $url;
	/** table columns */
	private $columns;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->name = null;
		$this->title = null;
		$this->url = null;
		$this->columns = array();
	}

	/**
	 *  sets the name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * gets the name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * sets the title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * gets the title
	 * @return NULL|unknown
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * sets the url
	 */
	public function setUrl( $url ) {
		$this->url = $url;
	}

	/**
	 * gets the url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * clears columns
	 */
	public function clearColumns() {
		$this->columns.= array();
	}

	/**
	 * adds column
	 */
	public function addColumn( $column ) {
		array_push( $this->columns, $column );
	}

	/**
	 * gets the number of columns
	 */
	public function getColumnCount() {
		return count( $this->columsns );
	}

	/**
	 * gets the column information
	 */
	public function getColumn( $index ) {
		if( $index < 0 || $index >= count( $this->columns) ) {
			return null;
		}

		return $this->columns[ $index ];
	}

	/**
	 * json serialize
	 */
	public function jsonSerialize() {
		$vars = get_object_vars( $this );
		return $vars;
	}
}

?>
