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

SELECT distinct ?peptide ?peptide_id ?peptide_label ?protein ?full_name WHERE {
    VALUES ?peptide { <{$object}> } .

     ?peptide dct:identifier ?peptide_id ;
        rdfs:label ?peptide_label .

    ?dataset_protein jpo:hasPeptideEvidence/jpo:hasPeptide ?peptide ;
        jpo:hasDatabaseSequence ?protein .

    ?protein uniprot:recommendedName/uniprot:fullName ?full_name .
}
