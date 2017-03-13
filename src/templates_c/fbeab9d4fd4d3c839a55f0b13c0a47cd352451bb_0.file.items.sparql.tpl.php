<?php
/* Smarty version 3.1.30, created on 2017-03-13 04:14:35
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\items.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c60e9bd20eb2_38300262',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fbeab9d4fd4d3c839a55f0b13c0a47cd352451bb' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\items.sparql.tpl',
      1 => 1489374872,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c60e9bd20eb2_38300262 (Smarty_Internal_Template $_smarty_tpl) {
?>
PREFIX jpo: <http://rdf.jpostdb.org/ontology/jpost.owl#>
PREFIX ms: <http://purl.obolibrary.org/obo/MS_>
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX sio: <http://semanticscience.org/resource/SIO_>
PREFIX mod: <http://purl.obolibrary.org/obo/MOD_>
PREFIX bto: <http://purl.obolibrary.org/obo/BTO_>
PREFIX doid: <http://purl.obolibrary.org/obo/DOID_>
PREFIX unimod: <http://www.unimod.org/obo/unimod.obo#UNIMOD_>
PREFIX tax: <http://identifiers.org/taxonomy/>
PREFIX : <http://rdf.jpostdb.org/entry/>

SELECT DISTINCT ?object ?label
WHERE {
    ?project a jpo:Project ;
        jpo:hasDataset/jpo:hasProfile/jpo:hasSample/jpo:<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
 ?object .
    ?object rdfs:seeAlso*/rdfs:label ?label .
}
<?php }
}
