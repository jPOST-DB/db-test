<?php


/**
 * config class
 *
 */
class Config {
	// application name
	public static $APPLICATION_NAME = 'jPOST';


	// endpoint
	public static $SPARQL_ENDPOINT = 'http://db-dev.jpostdb.org/sparql2/';


	// protein columns
	public static $PROTEIN_COLUMNS = array(
		array(
			'name'   => 'protein_id',
			'title'  => 'ID',
			'search' => true,
			'url'    => 'protein.php?id='
		),
		array(
			'name'   => 'protein_label',
			'title'  => 'Label',
			'search' => true
		),
		array(
			'name'   => 'mnomonic',
			'title'  => 'Mnomonic',
			'search' => true
		)
	);

	// dataset columns
	public static $DATASET_COLUMNS = array(
		array(
			'name'   => 'dataset_id',
			'title'  => 'ID',
			'search' => true,
			'url'    => 'dataset.php?id='
		),
		array(
			'name'   => 'profile_label',
			'title'  => 'Profile',
			'search' => true
		),
		array(
			'name'   => 'ms_label',
			'title'  => 'MS Mode',
				'search' => true
		),
		array(
			'name'   => 'sample_label',
			'title'  => 'Sample',
			'search' => true
		),
		array(
			'name'   => 'rawdata_num',
			'title'  => '#RawData',
			'search' => false
		),
		array(
			'name'   => 'protein_num',
			'title'  => '#Protein',
			'search' => false
		),
		array(
			'name'   => 'peptide_num',
			'title'  => '#Peptide',
			'search' => false
		),
		array(
			'name'   => 'psm_num',
			'title'  => '#Psm',
			'search' => false
		)
	);
}

?>
