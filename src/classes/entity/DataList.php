<?php

/**
 * data list class
 */
class DataList implements JsonSerializable {
	/** draw number */
	private $draw;

	/** total records */
	private $recordsTotal;

	/** the number of filtered records */
	private $recordsFiltered;

	/** data list */
	private $data;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->draw = 0;
		$this->recordsTotal = 0;
		$this->recordsFiltered = 0;
		$this->data = array();
	}

	/**
	 * sets the draw number
	 */
	public function setDrawNumber( $draw ) {
		$this->draw = $draw;
	}

	/**
	 * gets the draw number
	 */
	public function getDrawNumber() {
		return $this->draw;
	}

	/**
	 * sets the total record count
	 */
	public function setRecordsTotal( $total ) {
		$this->recordsTotal = $total;
	}

	/**
	 * gets the total record count
	 */
	public function getRecordsTotal() {
		return $this->recordsTotal;
	}

	/**
	 * sets the filtered record count
	 */
	public function setRecordsFiltered( $count ) {
		$this->recordsFiltered = $count;
	}

	/**
	 * gets the filtered record count
	 */
	public function getRecordsFiltered() {
		return $this->recordsFiltered;
	}

	/**
	 * clears data
	 */
	public function clearData() {
		$this->data = array();
	}

	/**
	 * adds data
	 */
	public function addData( $line ) {
		array_push( $this->data, $line );
	}

	/**
	 * gets the data line count
	 */
	public function getDataLineCount() {
		return count( $this->data );
	}

	/**
	 * gets the data line data
	 * @param unknown $index
	 * @return NULL|mixed
	 */
	public function getDataLine( $index ) {
		if( $index < 0 || $index >= count( $this->data ) ) {
			return null;
		}

		return $this->data[ $index ];
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