<?php
/* Smarty version 3.1.30, created on 2017-03-13 05:44:04
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\dataset.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c623947c9570_07632482',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6a9e248cf17a37e5e8cb132b6dabae0aedb9aabb' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\dataset.sparql.tpl',
      1 => 1489380242,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c623947c9570_07632482 (Smarty_Internal_Template $_smarty_tpl) {
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

SELECT ?dataset_id ?project_id ?project_title ?project_desc ?project_date ?rawdata_num ?protein_num ?peptide_num ?psm_num WHERE {

    VALUES ?dataset_id { "<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" }

    ?dataset a jpo:Dataset ;
        dct:identifier ?dataset_id ;
        jpo:hasProfile ?profile .

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
            dct:description ?project_desc ;
            dct:date ?project_date .
    }
}
<?php }
}
