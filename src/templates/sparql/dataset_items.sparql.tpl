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

SELECT {$columns} WHERE {
	VALUES ?dataset { <{$object}> } .

    ?dataset a jpo:Dataset ;
        dct:identifier ?dataset_id .

{if $table == 'profile'}
    ?dataset jpo:hasProfile ?profile .

    ?profile rdfs:label ?profile_label .

    optional {
        ?profile jpo:hasFractionation/rdfs:label ?fractionation .
    }

    optional {
        ?profile jpo:hasEnzymeAndModification/rdfs:label ?enzyme .
    }

    optional {
        ?profile jpo:hasMsMode/rdfs:label ?ms .
    }

    optional {
        ?profile jpo:hasSample/rdfs:label ?sample .
    }
{/if}

{if $table == 'protein'}
    ?dataset jpo:hasProtein ?dataset_protein .

    ?dataset_protein dct:identifier ?protein_id ;
        rdfs:label ?protein_label ;
        jpo:hasDatabaseSequence ?protein .

    ?protein uniprot:recommendedName/uniprot:shortName ?short_name ;
   	    uniprot:recommendedName/uniprot:fullName ?full_name .

    optional {
        ?protein uniprot:mnemonic ?mnemonic .
    }

    optional {
        ?protein uniprot:sequence/uniprot:mass ?mass .
    }

{/if}

{if $table == 'peptide'}
    $dataset jpo:hasPeptide ?peptide .

    ?peptide dct:identifier ?peptide_id ;
        rdfs:label ?peptide_label .
{/if}

{if isset( $search )}
	{$search}
{/if}

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