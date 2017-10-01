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
PREFIX uniprot: <http://purl.uniprot.org/core/>
PREFIX tax: <http://identifiers.org/taxonomy/>
PREFIX owl: <http://www.geneontology.org/formats/oboInOwl#>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX : <http://rdf.jpostdb.org/entry/>


SELECT {$columns} WHERE {
{if isset($datasets)}
    values ?dataset { {$datasets} }
{/if}

{if isset($proteins)}
    values ?protein { {$proteins} }
{/if}

    ?dataset a jpo:Dataset ;
{if ( strpos( $columns, "dataset" ) != false && isset( $modification ) ) || isset( $psm ) || strpos( $columns, "psm" ) != false }
        jpo:hasPeptide/jpo:hasPsm ?psm ;
{/if}

        dct:identifier ?dataset_id ;
        jpo:hasProfile ?profile .

{if isset( $excludedDatasets )}
    filter( $dataset not in ( {$excludedDatasets} ) ).
{/if}

    ?profile jpo:hasSample ?sample .

{if strpos( $columns, "psm" )}
    ?psm dct:identifier ?psm_id .
{/if}

{if strpos( $columns, "project" ) != false || isset( $keywords )}
    ?project jpo:hasDataset ?dataset ;
        dct:identifier ?project_id ;
        dct:title ?project_title ;
        dct:date ?project_date ;
        dct:description ?project_desc .
{/if}

{if isset($species)}
    ?sample jpo:species/rdfs:seeAlso*/skos:prefLabel ?species_label .
     filter( str( ?species_label ) in ( {$species} ) ) .
{/if}

{if isset($tissue)}
    ?sample jpo:tissue/rdfs:seeAlso*/rdfs:label ?tissue_label .
	filter( str( ?tissue_label ) in ( {$tissue} ) ) .
{/if}

{if isset( $disease )}
    ?sample jpo:disease/rdfs:seeAlso*/rdfs:label ?disease_label .
    filter( str( ?disease_label ) in ( {$disease} ) ) .
{/if}

{if isset( $celltype )}
    ?sample jpo:cellType/rdfs:seeAlso*/rdfs:label ?celltype_label .
    filter( str( ?celltype_label ) in ( {$celltype} ) ) .
{/if}

{if isset( $modification )}
    {
        select ?modification where {
            ?modification rdfs:subClassOf unimod:0 ;
                rdfs:label ?modification_label .

            filter( ?modification_label in ( {$modification} ) ) .
        }
    }

    ?psm jpo:hasModification/rdf:type ?modification .
{/if}

{if isset( $instrument )}
    ?profile jpo:hasMsMode/jpo:instrument/rdfs:label ?instrument_label .
    filter( str( ?instrument_label ) in ( {$instrument} ) ) .
{/if}

{if isset( $instrumentMode )}
     ?profile jpo:hasMsMode/jpo:instrumentMode/rdfs:label ?instrument_mode_label .
     filter( str( ?instrument_mode_label ) in ( {$instrumentMode} ) ) .
{/if}


{if strpos( $columns, "mnemonic" ) != false || isset( $excludedProteins ) || isset( $keywords ) }
    ?dataset jpo:hasProtein ?dataprotein .

    ?dataprotein
  {if isset( $psm ) || isset( $modification )}
        jpo:hasPeptideEvidence/jpo:hasPeptide/jpo:hasPsm ?psm ;
  {/if}
        jpo:hasDatabaseSequence ?protein .


    ?protein uniprot:recommendedName/uniprot:fullName ?full_name ;
        uniprot:mnemonic ?mnemonic ;
        uniprot:sequence ?sequenceObject .

  {if isset( $excludedProteins )}
      filter( ?protein not in ( {$excludedProteins} ) ).
  {/if}

    ?sequenceObject a uniprot:Simple_Sequence ;
        uniprot:mass ?mass ;
        rdf:value ?sequence .
{/if}

{if strpos( $columns, "peptide" ) != false}
    ?dataset jpo:hasPeptide ?peptide .

    ?peptide a jpo:Peptide ;
        rdfs:label ?peptide_label .

    ?dataprotein jpo:hasPeptideEvidence/jpo:hasPeptide ?peptide .
{/if}

{if isset( $keywords ) }
    filter(
      ( true
        {foreach $keywords as $keyword}
            && contains( lcase( str( ?project_title ) ), lcase( '{$keyword}' ) )
        {/foreach}
      )

      ||

      ( true
        {foreach $keywords as $keyword}
            && contains( lcase( str( ?project_desc ) ), lcase( '{$keyword}' ) )
        {/foreach}
      )

      ||

      ( true
        {foreach $keywords as $keyword}
            && contains( lcase( str( ?full_name ) ), lcase( '{$keyword}' ) )
        {/foreach}
      )

      ||

      ( true
        {foreach $keywords as $keyword}
            && contains( lcase( str( ?mnemonic ) ), lcase( '{$keyword}' ) )
        {/foreach}
      )
    ).
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

