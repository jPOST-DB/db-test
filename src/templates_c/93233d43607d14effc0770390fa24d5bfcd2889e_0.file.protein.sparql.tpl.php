<?php
/* Smarty version 3.1.30, created on 2017-03-14 00:35:23
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\protein.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c72cbb0d44d3_20460276',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93233d43607d14effc0770390fa24d5bfcd2889e' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\protein.sparql.tpl',
      1 => 1489448025,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c72cbb0d44d3_20460276 (Smarty_Internal_Template $_smarty_tpl) {
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

SELECT ?protien ?protein_id ?protein_label ?mnemonic ?value ?mass WHERE {
    VALUES ?protein_id { "<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" } .

    ?protein a jpo:Protein ;
        dct:identifier ?protein_id ;
        rdfs:label ?protein_label ;
        jpo:hasDatabaseSequence ?sequence .


    optional {
        ?sequence uniprot:mnemonic ?mnemonic .
    }

    optional {
        ?sequence uniprot:sequence/rdf:value ?value .
    }
    optional {
        ?sequence uniprot:sequence/uniprot:mass ?mass .
    }
}
<?php }
}
