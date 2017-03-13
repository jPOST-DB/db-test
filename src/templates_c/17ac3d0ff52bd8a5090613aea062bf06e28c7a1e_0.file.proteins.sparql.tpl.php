<?php
/* Smarty version 3.1.30, created on 2017-03-13 07:51:08
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\proteins.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c6415cc43a19_46404047',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '17ac3d0ff52bd8a5090613aea062bf06e28c7a1e' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\proteins.sparql.tpl',
      1 => 1489386191,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c6415cc43a19_46404047 (Smarty_Internal_Template $_smarty_tpl) {
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

<?php if (isset($_smarty_tpl->tpl_vars['species']->value)) {?>
    VALUES ?species { <?php echo $_smarty_tpl->tpl_vars['species']->value;?>
 }
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['tissue']->value)) {?>
    VALUES ?tissue { <?php echo $_smarty_tpl->tpl_vars['tissue']->value;?>
 }
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['disease']->value)) {?>
    VALUES ?disease { <?php echo $_smarty_tpl->tpl_vars['disease']->value;?>
 }
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['modification']->value)) {?>
    VALUES ?modification { <?php echo $_smarty_tpl->tpl_vars['modification']->value;?>
 }
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['instrument']->value)) {?>
    VALUES ?instrument { <?php echo $_smarty_tpl->tpl_vars['instrument']->value;?>
 }
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['instrumentMode']->value)) {?>
    VALUES ?instrumentMode { <?php echo $_smarty_tpl->tpl_vars['instrumentMode']->value;?>
 }
<?php }?>

    ?dataset a jpo:Dataset ;
<?php if (isset($_smarty_tpl->tpl_vars['dataset']->value) && $_smarty_tpl->tpl_vars['dataset']->value == true) {?>
        dct:identifier ?dataset_id ;
<?php }?>
        jpo:hasProfile ?profile ;
        jpo:hasProtein ?protein .

    ?protein a ms:1002401 ;
<?php if (isset($_smarty_tpl->tpl_vars['modification']->value)) {?>
       	jpo:hasPeptideEvidence/jpo:hasPeptide/jpo:hasPsm/jpo:hasModification/rdf:type ?modification ;
<?php }?>
        dct:identifier ?protein_id ;
        rdfs:label ?protein_label ;
        jpo:hasDatabaseSequence ?sequence .

    ?profile jpo:hasSample ?sample .

<?php if (isset($_smarty_tpl->tpl_vars['dataset']->value) && $_smarty_tpl->tpl_vars['dataset']->value == true) {?>
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

<?php if (isset($_smarty_tpl->tpl_vars['protein']->value) && $_smarty_tpl->tpl_vars['protein']->value == true) {?>
    optional {
        ?sequence uniprot:mnemonic ?mnomonic .
    }
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['species']->value)) {?>
    ?sample jpo:species ?species .
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['tissue']->value)) {?>
    ?sample jpo:tissue ?tissue .
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['disease']->value)) {?>
    ?sample jpo:disease ?disease .
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['instrument']->value)) {?>
     ?profile jpo:hasMsMode/jpo:instrument ?instrument .
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['instrumentMode']->value)) {?>
     ?profile jpo:hasMsMode/jpo:instrumentMode ?instrumentMode .
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
