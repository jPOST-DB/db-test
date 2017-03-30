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
    VALUES ?protein { {$objects} }
{/if}

    ?dataset a jpo:Dataset ;
        jpo:hasProfile ?profile ;
        jpo:hasProtein ?dataset_protein .

    ?dataset_protein a ms:1002401 ;
{if isset( $modification)}
       	jpo:hasPeptideEvidence/jpo:hasPeptide/jpo:hasPsm/jpo:hasModification/rdf:type ?modification ;
{/if}
        jpo:hasDatabaseSequence ?protein .

    ?profile jpo:hasSample ?sample .

   	?protein uniprot:recommendedName/uniprot:shortName ?short_name ;
   	    uniprot:recommendedName/uniprot:fullName ?full_name .

    optional {
        ?protein uniprot:mnemonic ?mnemonic .
    }

    optional {
        ?protein uniprot:sequence/uniprot:mass ?mass .
    }

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
        filter( ?protein != <{$except}> )
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