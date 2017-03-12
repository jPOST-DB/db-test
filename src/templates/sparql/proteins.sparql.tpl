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

SELECT <% echo(columns) %> WHERE {

<% def(species) %>
    VALUES ?species { <% echo(species) %> }
<% /def %>

<% def(tissue) %>
    VALUES ?tissue { <% echo(tissue) %> }
<% /def %>

<% def(disease) %>
    VALUES ?disease { <% echo(disease) %> }
<% /def %>

<% def(modification) %>
    VALUES ?modification { <% echo(modification) %> }
<% /def %>

<% def(instrument) %>
    VALUES ?instrument { <% echo(instrument) %> }
<% /def %>

<% def(instrumentMode) %>
    VALUES ?instrumentMode { <% echo(instrumentMode) %> }
<% /def %>

    ?dataset a jpo:Dataset ;
<% def(dataset) %>
<% if(dataset,==,true) %>
        dct:identifier ?dataset_id ;
<% /if %>
<% /def %>
        jpo:hasProfile ?profile ;
        jpo:hasProtein ?protein .

    ?protein a ms:1002401 ;
<% def(modification) %>
       	jpo:hasPeptideEvidence/jpo:hasPeptide/jpo:hasPsm/jpo:hasModification/rdf:type ?modification ;
<% /def %>

<% def(protein) %>
<% if(protein,==,true) %>
        dct:identifier ?protein_id ;
        rdfs:label ?protein_label ;
<% /if %>
<% /def %>

        jpo:hasDatabaseSequence ?sequence .

    ?profile jpo:hasSample ?sample .

<% def(dataset) %>
<% if(dataset,==,true) %>
    optional {
        ?profile jpo:hasMsMode ?ms  .
        ?ms rdfs:label ?ms_label .
    }

    optional {
        ?profile rdfs:label ?profile_label .
    }

    optional {
        ?sample rdfs:label ?sample_label .
    }

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
<% /if %>
<% /def %>

<% def(protein) %>
<% if(protein,==,true) %>
    ?sequence uniprot:mnemonic ?mnomonic .
<% /if %>
<% /def %>

<% def(species) %>
    ?sample jpo:species ?species .
<% /def %>

<% def(tissue) %>
    ?sample jpo:tissue ?tissue .
<% /def %>

<% def(disease) %>
    ?sample jpo:disease ?disease .
<% /def %>

<% def(instrument) %>
     ?profile jpo:hasMsMode/jpo:instrument ?instrument .
<% /def %>

<% def(instrumentMode) %>
     ?profile jpo:hasMsMode/jpo:instrumentMode ?instrumentMode .
<% /def %>

<% def(search) %>
	<% echo(search) %>
<% /def %>

}

<% def(order) %>
    ORDER BY <% echo(order) %>
<% /def %>


<% def(limit) %>
    LIMIT <% echo(limit) %>
<% /def %>

<% def(offset) %>
    OFFSET <% echo(offset) %>
<% /def %>