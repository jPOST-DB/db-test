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
    VALUES ?protein_id { "{$id}" } .

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
