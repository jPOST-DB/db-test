<?php
/* Smarty version 3.1.30, created on 2017-03-13 07:42:08
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\dataset_items.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c63f40e5e1f4_62281897',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '880989cd269d7e240137bf1ca1d2ec39dce275de' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\dataset_items.sparql.tpl',
      1 => 1489387212,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c63f40e5e1f4_62281897 (Smarty_Internal_Template $_smarty_tpl) {
?>
PREFIX jpo: <http://rdf.jpostdb.org/ontology/jpost.owl#>
PREFIX ms: <http://purl.obolibrary.org/obo/MS_>
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX sio: <http://semanticscience.org/resource/SIO_>
PREFIX mod: <http://purl.obolibrary.org/obo/MOD_>
PREFIX bto: <http://purl.obolibrary.org/obo/BTO_>
PREFIX doid: <http://purl.obolibrary.org/obo/DOID_>
PREFIX uniprot: <http://purl.uniprot.org/core/>
PREFIX unimod: <http://www.unimod.org/obo/unimod.obo#UNIMOD_>
PREFIX tax: <http://identifiers.org/taxonomy/>

PREFIX : <http://rdf.jpostdb.org/entry/>

SELECT <?php echo $_smarty_tpl->tpl_vars['columns']->value;?>
 WHERE {
	VALUES ?dataset_id { "<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" } .

    ?dataset a jpo:Dataset ;
        dct:identifier ?dataset_id .

<?php if ($_smarty_tpl->tpl_vars['table']->value == 'profile') {?>
    ?dataset jpo:hasProfile ?profile .

    ?profile rdfs:label ?profile_label .

    optional {
        ?profile jpo:hasFractionation/rdfs:label ?fractionation .
    }

    optional {
        ?profile jpo:hasEnzymeAndModification/rdfs:label ?enzyme .
    }

    optional {
        ?profile jpo:hasMsMode/rdfs:label ?ms .
    }

    optional {
        ?profile jpo:hasSample/rdfs:label ?sample .
    }
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['table']->value == 'protein') {?>
    ?dataset jpo:hasProtein ?protein .

    ?protein dct:identifier ?protein_id ;
        rdfs:label ?protein_label ;
        jpo:hasDatabaseSequence ?sequence .

    optional {
        ?sequence uniprot:mnemonic ?mnomonic .
    }
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['table']->value == 'peptide') {?>
    $dataset jpo:hasPeptide ?peptide .

    ?peptide dct:identifier ?peptide_id ;
        rdfs:label ?peptide_label .
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['search']->value)) {?>
	<?php echo $_smarty_tpl->tpl_vars['search']->value;?>

<?php }?>

}

<?php if (isset($_smarty_tpl->tpl_vars['order']->value)) {?>
    ORDER BY <?php echo $_smarty_tpl->tpl_vars['order']->value;?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['limit']->value)) {?>
    LIMIT <?php echo $_smarty_tpl->tpl_vars['limit']->value;?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['offset']->value)) {?>
    OFFSET <?php echo $_smarty_tpl->tpl_vars['offset']->value;?>

<?php }
}
}
