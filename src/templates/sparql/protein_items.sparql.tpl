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
PREFIX faldo: <http://biohackathon.org/resource/faldo#>

PREFIX : <http://rdf.jpostdb.org/entry/>

SELECT {$columns} WHERE {
    VALUES ?protein { <{$object}> } .

    ?dataset_protein jpo:hasDatabaseSequence ?protein .

{if $table == 'dataset'}
    ?dataset jpo:hasProtein ?dataset_protein ;
        dct:identifier ?dataset_id .

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
{/if}


{if $table == 'peptide_position'}
    ?dataset_protein jpo:hasPeptideEvidence ?peptide_position .

    ?peptide_position jpo:hasPeptide ?peptide .

    ?peptide dct:identifier ?peptide_id ;
        rdfs:label ?peptide_label .

    optional {
        ?peptide_position faldo:location ?location .

        ?location faldo:begin/faldo:position ?begin ;
             faldo:end/faldo:position ?end .
    }
{/if}

}
