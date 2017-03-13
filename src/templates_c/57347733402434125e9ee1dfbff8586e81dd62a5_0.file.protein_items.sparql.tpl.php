<?php
/* Smarty version 3.1.30, created on 2017-03-14 00:45:52
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\protein_items.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c72f3089c112_60891844',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '57347733402434125e9ee1dfbff8586e81dd62a5' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\protein_items.sparql.tpl',
      1 => 1489448734,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c72f3089c112_60891844 (Smarty_Internal_Template $_smarty_tpl) {
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
    VALUES ?protein_id { "<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" } .

    ?protein a jpo:Protein ;
        dct:identifier ?protein_id .


<?php if ($_smarty_tpl->tpl_vars['table']->value == 'dataset') {?>
    ?dataset jpo:hasProtein ?protein ;
        dct:identifier ?dataset_id .

    optional {
        ?dataset sio:000552 ?rawdata_num_param .
        ?rawdata_num_param a jpo:NumOfRawData ;
            sio:000300 ?rawdata_num .
    }

    optional {
        ?dataset sio:000552 ?protein_num_param .
        ?protein_num_param a jpo:NumOfProteins ;
            sio:000300 ?protein_num .
    }

    optional {
        ?dataset sio:000552 ?peptide_num_param .
        ?peptide_num_param a jpo:NumOfPeptides ;
            sio:000300 ?peptide_num .
    }

    optional {
        ?dataset sio:000552 ?psm_num_param .
        ?psm_num_param a jpo:NumOfPsms ;
            sio:000300 ?psm_num .
    }

    optional {
        ?project jpo:hasDataset ?dataset ;
            dct:identifier ?project_id ;
            dct:title ?project_title ;
            dct:date ?project_date .
    }
<?php }?>

}
<?php }
}
