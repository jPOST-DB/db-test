PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX jpo: <http://rdf.jpostdb.org/ontology/jpost.owl#>
PREFIX ms: <http://purl.obolibrary.org/obo/MS_>
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX sio: <http://semanticscience.org/resource/SIO_>
PREFIX mod: <http://purl.obolibrary.org/obo/MOD_>
PREFIX bto: <http://purl.obolibrary.org/obo/BTO_>
PREFIX doid: <http://purl.obolibrary.org/obo/DOID_>
PREFIX unimod: <http://www.unimod.org/obo/unimod.obo#UNIMOD_>
PREFIX tax: <http://identifiers.org/taxonomy/>
PREFIX owl: <http://www.geneontology.org/formats/oboInOwl#>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX : <http://rdf.jpostdb.org/entry/>


select {$columns} where {
    values $protein { {$proteins} } .

	?protein uniprot:recommendedName/uniprot:fullName ?full_name .

    optional {
        ?protein uniprot:mnemonic ?mnemonic .
    }

    optional {
        ?protein uniprot:sequence/rdf:value ?sequence .
    }
    optional {
        ?protein uniprot:sequence/uniprot:mass ?mass .
    }
}

{if isset( $order )}
    ORDER BY {$order}
{/if}

{if isset( $limit )}
    LIMIT {$limit}
{/if}

{if isset( $offset )}
    OFFSET {$offset}
{/if}
