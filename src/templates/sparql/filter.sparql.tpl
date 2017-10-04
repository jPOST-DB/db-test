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
PREFIX faldo: <http://biohackathon.org/resource/faldo#>
PREFIX : <http://rdf.jpostdb.org/entry/>



SELECT {$columns} WHERE {
{if isset($datasets)}
    values ?dataset { {$datasets} }
{/if}

{if isset($proteins)}
    values ?protein { {$proteins} }
{/if}

{if isset($peptides)}
    values ?peptide { {$peptides} }
{/if}

    ?dataset a jpo:Dataset ;
{if ( strpos( $columns, "dataset" ) != false && isset( $modification ) ) || isset( $psm ) }
        jpo:hasPeptide/jpo:hasPsm ?psm ;
{/if}

        dct:identifier ?dataset_id ;
        jpo:hasProfile ?profile .

{if strpos( $columns, "psm" )}
    ?psm dct:identifier ?psm_id ;
        rdfs:label ?psm_label .
    optional {
        ?psm sio:000552 ?mascot_expected_value_parameter .
        ?mascot_expected_value_parameter a ms:1001172 ;
            sio:000300 ?mascot_ev .
    }
    optional {
        ?psm sio:000552 ?mascot_score_parameter .
        ?mascot_score_parameter a ms:1001171 ;
            sio:000300 ?mascot_score .
    }
    optional {
        ?psm sio:000552 ?jpost_expected_value_parameter .
        ?jpost_expected_value_parameter a jpo:JpostExpectedValue ;
            sio:000300 ?jpost_ev .
    }
    optional {
        ?psm sio:000552 ?charge_parameter .
        ?charge_parameter a ms:1000041 ;
            sio:000300 ?charge .
    }
    optional {
        ?psm sio:000552 ?calculated_mass_parameter .
        ?calculated_mass_parameter a jpo:CalculatedMassToCharge ;
            sio:000300 ?cal_mass .
    }
    optional {
        ?psm sio:000552 ?experimental_mass_parameter .
        ?experimental_mass_parameter a jpo:ExperimentalMassToCharge ;
            sio:000300 ?exp_mass .
    }
{/if}

{if isset( $excludedDatasets )}
    filter( $dataset not in ( {$excludedDatasets} ) ).
{/if}

    ?profile jpo:hasSample ?sample .

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


{if strpos( $columns, "protein" ) != false || isset( $excludedProteins ) || isset( $keywords ) || isset( $proteins ) }
    ?dataset jpo:hasProtein ?dataprotein .

    ?dataprotein
  {if isset( $psm ) || isset( $modification ) || strpos( $columns, 'psm' ) != false}
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

{if strpos( $columns, "peptide" ) != false || isset($peptides)}
    ?dataset jpo:hasPeptide ?peptide .
  {if strpos( $columns, "psm" ) != false}
    ?peptide jpo:hasPsm ?psm .
  {/if}

    ?peptide a jpo:Peptide ;
        rdfs:label ?peptide_label ;
        dct:identifier ?peptide_id .

    ?dataprotein jpo:hasPeptideEvidence/jpo:hasPeptide ?peptide .

{/if}

{if strpos( $columns, "peptide_location" ) != false}
    ?evidence a jpo:PeptideEvidence ;
        jpo:hasPeptide ?peptide ;
        faldo:location ?peptide_location .

    ?peptide_location faldo:begin/faldo:position ?peptide_begin ;
        faldo:end/faldo:position ?peptide_end .
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

      ||

      ( true
        {foreach $keywords as $keyword}
            && contains( lcase( str( ?protein ) ), lcase( '{$keyword}' ) )
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

