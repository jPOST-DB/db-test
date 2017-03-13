<?php
/* Smarty version 3.1.30, created on 2017-03-13 04:15:47
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\instruments.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c60ee378b942_38087520',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ba26a6d9a394d61c93f57ae2e3b8586ac4f4fba' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\instruments.sparql.tpl',
      1 => 1489374928,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c60ee378b942_38087520 (Smarty_Internal_Template $_smarty_tpl) {
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
    ?project a jpo:Project;
        jpo:hasDataset/jpo:hasProfile/jpo:hasMsMode/jpo:<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
 ?object .
    ?object rdfs:label ?label .
}
<?php }
}
