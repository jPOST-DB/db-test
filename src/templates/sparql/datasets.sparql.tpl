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

{if isset( $species )}
    VALUES ?species { {$species} }
{/if}

{if isset( $tissue )}
    VALUES ?tissue { {$tissue} }
{/if}

{if isset( $disease ) }
    VALUES ?disease { {$disease} }
{/if}

{if isset( $modification )}
    VALUES ?modification { {$modification} }
{/if}

{if isset( $instrument ) }
    VALUES ?instrument { {$instrument} }
{/if}

{if isset( $instrumentMode ) }
    VALUES ?instrumentMode { {$instrumentMode} }
{/if}

{if isset( $objects ) }
    VALUES ?dataset { {$objects} }
{/if}

    ?dataset a jpo:Dataset ;
        dct:identifier ?dataset_id ;
        jpo:hasProfile ?profile ;
        jpo:hasProtein ?protein ;
        sio:000552 ?rawdata_num_param ;
        sio:000552 ?protein_num_param ;
        sio:000552 ?peptide_num_param ;
        sio:000552 ?psm_num_param .

    ?profile jpo:hasSample ?sample .

    ?rawdata_num_param a jpo:NumOfRawData ;
        sio:000300 ?rawdata_num .

    ?protein_num_param a jpo:NumOfProteins ;
        sio:000300 ?protein_num .

    ?peptide_num_param a jpo:NumOfPeptides ;
        sio:000300 ?peptide_num .

    ?psm_num_param a jpo:NumOfPsms ;
        sio:000300 ?psm_num .

    ?project jpo:hasDataset ?dataset ;
        dct:identifier ?project_id ;
        dct:title ?project_title ;
        dct:date ?project_date .

{if isset( $modification )}
    ?protein a ms:1002401 ;
       	jpo:hasPeptideEvidence/jpo:hasPeptide/jpo:hasPsm/jpo:hasModification/rdf:type ?modification ;
        jpo:hasDatabaseSequence ?sequence .
{/if}

{if isset( $species )}
    ?sample jpo:species ?species .
{/if}

{if isset( $tissue )}
    ?sample jpo:tissue ?tissue .
{/if}

{if isset( $disease )}
    ?sample jpo:disease ?disease .
{/if}

{if isset( $instrument )}
     ?profile jpo:hasMsMode/jpo:instrument ?instrument .
{/if}

{if isset( $instrumentMode )}
     ?profile jpo:hasMsMode/jpo:instrumentMode ?instrumentMode .
{/if}

{if isset( $search )}
	{$search}
{/if}


{if isset( $minus )}
    {foreach $minus as $except}
        filter( ?dataset != <{$except}> )
    {/foreach}
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