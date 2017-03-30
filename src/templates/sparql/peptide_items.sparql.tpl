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

select distinct ?psm ?mascot_expected_value ?mascot_score ?jpost_expected_value ?charge ?calculated_mass ?experimental_mass ?project_label where {
    VALUES ?peptide { <{$object}> }

    ?peptide jpo:hasPsm ?psm .

    optional {
        ?psm sio:000552 ?mascot_expected_value_parameter .
        ?mascot_expected_value_parameter a ms:1001172 ;
            sio:000300 ?mascot_expected_value .
    }
    optional {
        ?psm sio:000552 ?mascot_score_parameter .
        ?mascot_score_parameter a ms:1001171 ;
            sio:000300 ?mascot_score .
    }
    optional {
        ?psm sio:000552 ?jpost_expected_value_parameter .
        ?jpost_expected_value_parameter a jpo:JpostExpectedValue ;
            sio:000300 ?jpost_expected_value .
    }
    optional {
        ?psm sio:000552 ?charge_parameter .
        ?charge_parameter a ms:1000041 ;
            sio:000300 ?charge .
    }
    optional {
        ?psm sio:000552 ?calculated_mass_parameter .
        ?calculated_mass_parameter a jpo:CalculatedMassToCharge ;
            sio:000300 ?calculated_mass .
    }
    optional {
        ?psm sio:000552 ?experimental_mass_parameter .
        ?experimental_mass_parameter a jpo:ExperimentalMassToCharge ;
            sio:000300 ?experimental_mass .
    }
    optional {
        ?psm jpo:hasSpectrum ?spectrum .
        ?spectrum jpo:inRawData ?rawdata .
        ?project jpo:hasRawData ?rawdata ;
            rdfs:label ?project_label .
    }


}