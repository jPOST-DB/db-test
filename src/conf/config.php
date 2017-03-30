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

	// table columns
	public static $TABLE_COLUMN_MAP = array(
		'protein' => array(
			array(
				'title'   => '<input type="checkbox" id="protein_check{$suffix}" onchange="jPost.toggleCheckboxes(\'protein_check{$suffix}\')">',
				'display' => '<input type="checkbox" class="protein_check{$suffix}" name="protein[]" value="{$protein}">'
			),
			array(
				'title'   => 'Full Name',
				'display' => '<a href="protein.php?object={$protein|escape:"url"}" target="jpost">{$full_name}</a>',
				'name'    => 'full_name',
				'search'  => true
			),
			array(
				'title'   => 'Mnemonic',
				'display' => '{$mnemonic}',
				'name'    => 'mnemonic',
				'search'  => true
			),
			array(
				'title'   => 'Mass',
				'display' => '{$mass}',
				'name'    => 'mass'
			)
		),

		'peptide' => array(
			array(
				'title'   => '<input type="checkbox" id="peptide_check{$suffix}" onchange="jPost.toggleCheckboxes(\'peptide_check{$suffix}\')">',
				'display' => '<input type="checkbox" class="peptide_check{$suffix}" name="peptide[]" value="{$peptide}">'
			),
			array(
				'title'   => 'ID',
				'display' => '<a href="peptide.php?object={$peptide|escape:"url"}" target="jpost">{$peptide_id}</a>',
				'name'    => 'peptide_id',
				'search'  => true
			),
			array(
				'title'   => 'Label',
				'display' => '{$peptide_label}',
				'name'    => 'peptide_label',
				'search'  => true
			)
		),

		'peptide_position' => array(
			array(
				'title'   => '<input type="checkbox" id="peptide_check{$suffix}" onchange="jPost.toggleCheckboxes(\'peptide_check{$suffix}\')">',
				'display' => '<input type="checkbox" class="peptide_check{$suffix}" name="peptide[]" value="{$peptide}">',
				'name'    => 'peptide'
			),
			array(
				'title'   => 'ID',
				'display' => '<a href="peptide.php?object={$peptide|escape:"url"}" target="jpost">{$peptide_id}</a>',
				'name'    => 'peptide_id',
				'search'  => true
			),
			array(
				'title'   => 'Label',
				'display' => '{$peptide_label}',
				'name'    => 'peptide_label',
				'search'  => true
			),
			array(
				'title'   => 'Begin',
				'display' => '{$begin}',
				'name'    => 'begin'
			),
			array(
				'title'   => 'End',
				'display' => '{$end}',
				'name'    => 'end'
			)
		),

		'dataset' => array(
			array(
				'title'   => '<input type="checkbox" id="dataset_check{$suffix}" onchange="jPost.toggleCheckboxes(\'dataset_check{$suffix}\')">',
				'display' => '<input type="checkbox" class="dataset_check{$suffix}" name="peptide[]" value="{$dataset}">'
			),
			array(
				'title'   => 'ID',
				'display' => '<a href="dataset.php?object={$dataset|escape:"url"}" target="jpost">{$dataset_id}</a>',
				'name'    => 'dataset_id',
				'search'  => true
			),
			array(
				'title'   => 'Project ID',
				'display' => '{$project_id}',
				'name'    => 'project_id',
				'search'  => true
			),
			array(
				'title'   => 'Project Title',
				'display' => '{$project_title}',
				'name'    => 'project_title',
				'search'  => true
			),
			array(
				'title'   => 'Project Date',
				'display' => '{$project_date}',
				'name'    => 'project_date'
			),
			array(
				'title'   => '#RawData',
				'display' => '{$rawdata_num}',
				'name'    => 'rawdata_num'
			),
			array(
				'title'   => '#Protein',
				'display' => '{$protein_num}',
				'name'    => 'protein_num'
			),
			array(
				'title'   => '#Peptide',
				'display' => '{$peptide_num}',
				'name'    => 'peptide_num'
			),
			array(
				'title'   => '#Psm',
				'display' => '{$psm_num}',
				'name'    => 'psm_num'
			)
		),

		'profile' => array(
			array(
				'title'   => '<input type="checkbox" id="profile_check{$suffix}" onchange="jPost.toggleCheckboxes(\'profile_check{$suffix}\')">',
				'display' => '<input type="checkbox" class="profile_check" name="profile[]" value="{$profile}">'
			),
			array(
				'title'   => 'Label',
				'display' => '{$profile_label}',
				'name'    => 'profile_label',
				'search'  => true
			),
			array(
				'title'   => 'Enzyme / Modification',
				'display' => '{$enzyme}',
				'name'    => 'enzyme',
				'search'  => true
			),
			array(
				'title'   => 'Fractionation',
				'display' => '{$fractionation}',
				'name'    => 'fractionation',
				'search'  => true
			),
			array(
				'title'   => 'MS Mode',
				'display' => '{$ms}',
				'name'    => 'ms',
				'search'  => true
			),
			array(
				'title'   => 'Sample',
				'display' => '{$sample}',
				'name'    => 'sample',
				'search'  => true
			)
		),

		'psm' => array(
			array(
				'title'   => '<input type="checkbox" id="psm_check{$suffix}" onchange="jPost.toggleCheckboxes(\'psm_check{$suffix}\')">',
				'display' => '<input type="checkbox" class="psm_check" name="psm[]" value="{$psm}">'
			),
			array(
				'title'   => 'Mascot Expected Value',
				'display' => '{$mascot_expected_value}',
				'name'    => 'mascot_expected_value',
				'search'  => false
			),
			array(
				'title'   => 'Mascot Score',
				'display' => '{$mascot_score}',
				'name'    => 'mascot_score',
				'search'  => false
			),
			array(
				'title'   => 'jPOST Expected Value',
				'display' => '{$jpost_expected_value}',
				'name'    => 'jpost_expected_value',
				'search'  => false
			),
			array(
				'title'   => 'Charge',
				'display' => '{$charge}',
				'name'    => 'charge',
				'search'  => false
			),
			array(
				'title'   => 'Calculated Mass',
				'display' => '{$calculated_mass}',
				'name'    => 'calculated_mass',
				'search'  => false
			),
			array(
				'title'   => 'Experimental Mass',
				'display' => '{$experimental_mass}',
				'name'    => 'experimental_mass',
				'search'  => false
			)
		)
	);
}

?>
