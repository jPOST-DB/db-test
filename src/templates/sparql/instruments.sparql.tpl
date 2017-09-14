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
PREFIX : <http://rdf.jpostdb.org/entry/>

SELECT DISTINCT ?label
WHERE {
    ?project a jpo:Project;
        jpo:hasDataset/jpo:hasProfile/jpo:hasMsMode/jpo:{$item}  ?object .
    ?object rdfs:label ?label .
}
