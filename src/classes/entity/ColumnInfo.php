<?php

/**
 * column information class
 */
class ColumnInfo implements JsonSerializable {
	/** column name */
	private $name;
	/** column title */
	private $title;
	/** sortable */
	private $sortable;
	/** searchable */
	private $searchable;
	/** align */
	private $align;
	/** width */
	private $width;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->name = null;
		$this->title = null;
		$this->sortable = false;
		$this->searchable = false;
		$this->align = 'left';
		$this->width = 100;
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
	 * sets the sortable flag value
	 */
	public function setSortable( $sortable ) {
		$this->sortable = $sortable;
	}

	/**
	 * gets the sortable flag value
	 */
	public function isSortable() {
		return $this->sortable;
	}

	/**
	 * sets the searchable flag value
	 */
	public function setSearchable( $searchable ) {
		$this->searchable = $searchable;
	}

	/**
	 * gets the searchable flag value
	 * @return boolean|unknown
	 */
	public function isSearchable() {
		return $this->searchable;
	}

	/**
	 * sets the alignment
	 */
	public function setAlign( $align ) {
		$this->align = $align;
	}

	/**
	 * gets the alignment
	 * @return string|unknown
	 */
	public function getAlign() {
		return $this->align;
	}

	/**
	 * sets the width
	 */
	public function setWidth( $width ) {
		$this->width = $width;
	}

	/**
	 * gets the width
	 */
	public function getWidth() {
		return $this->getWidth();
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