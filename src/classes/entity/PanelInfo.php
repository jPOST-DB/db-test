<?php

/**
 * panel information class
 */
class PanelInfo implements JsonSerializable {
	/** panel title */
	private $title;

	/** panel name */
	private $name;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->title = null;
		$this->name = null;
	}

	/**
	 * sets the title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * gets the title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * sets the name
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
	 * json serialize
	 */
	public function jsonSerialize() {
		$vars = get_object_vars( $this );
		return $vars;
	}
}

?>