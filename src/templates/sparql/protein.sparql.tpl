PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
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

SELECT ?protein ?protein_id ?protein_label ?mnemonic ?value ?mass ?full_name WHERE {
    VALUES ?protein { <{$object}> } .

	?protein uniprot:recommendedName/uniprot:fullName ?full_name .

    optional {
        ?protein uniprot:mnemonic ?mnemonic .
    }

    optional {
        ?protein uniprot:sequence/rdf:value ?value .
    }
    optional {
        ?protein uniprot:sequence/uniprot:mass ?mass .
    }
}
