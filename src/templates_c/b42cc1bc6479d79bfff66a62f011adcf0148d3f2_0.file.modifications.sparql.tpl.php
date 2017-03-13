<?php
/* Smarty version 3.1.30, created on 2017-03-13 04:12:53
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\sparql\modifications.sparql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c60e35a398b7_96383635',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b42cc1bc6479d79bfff66a62f011adcf0148d3f2' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\sparql\\modifications.sparql.tpl',
      1 => 1487977994,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c60e35a398b7_96383635 (Smarty_Internal_Template $_smarty_tpl) {
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
    {
        ?s a jpo:Project ;
            jpo:modification ?object .
    }UNION{
        ?s a jpo:PeptideSpectrumMatch ;
            jpo:hasModification/rdf:type ?object .
        FILTER (?object != jpo:Modification)
    }
    ?object rdfs:label ?label .
}
<?php }
}
