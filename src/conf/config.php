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
			'name'   => 'mnemonic',
			'title'  => 'Mnemonic',
			'search' => true
		),
		array(
			'name'   => 'mass',
			'title'  => 'Mass',
			'search' => false
		)
	);

	// peptide columns
	public static $PEPTIDE_COLUMNS = array(
		array(
			'name'   => 'peptide_id',
			'title'  => 'ID',
			'search' => true,
			'url'    => 'peptide.php?id='
		),
		array(
			'name'   => 'peptide_label',
			'title'  => 'Label',
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
			'name'   => 'project_id',
			'title'  => 'Project ID',
			'search' => true
		),
		array(
			'name'   => 'project_title',
			'title'  => 'Project Title',
			'search' => true
		),
		array(
			'name'   => 'project_date',
			'title'  => 'Project Date',
			'search' => false
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

	// profile columns
	public static $PROFILE_COLUMNS = array(
		array(
			'name'   => 'profile_label',
			'title'  => 'Label',
			'search' => true
		),
		array(
			'name'   => 'enzyme',
			'title'  => 'Enzyme / Modification',
			'search' => true
		),
		array(
			'name'   => 'fractionation',
			'title'  => 'Fractionation',
			'search' => true
		),
		array(
			'name'   => 'ms',
			'title'  => 'MS Mode',
			'search' => true
		),
		array(
			'name'   => 'sample',
			'title'  => 'Sample',
			'search' => true
		)
	);
}

?>
