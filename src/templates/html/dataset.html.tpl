<!DOCTYPE html>
<html>
  <head>
    <title>{$dataset_id} - jPOST</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="/ts/stanza/assets/components/webcomponentsjs/webcomponents.min.js"></script>
    <link href="/ts/stanza/kegg_global_map/" rel="import">
    <link href="/ts/stanza/dataset_chromosome/" rel="import">
    <link href="/ts/stanza/protein_evidence/" rel="import">
  </head>
  <body>
    <div class="container">
      <h2>Dataset: {$dataset_id}</h2>
      <table class="table table-striped">
        <tr>
          <th>ID</th>
          <td>{$dataset_id}</td>
        </tr>
        <tr>
          <th>Project ID</th>
          <td>{$project_id}</td>
        </tr>
        <tr>
          <th>Project Title</th>
          <td>{$project_title}</td>
        </tr>
        <tr>
          <th>Project Description</th>
          <td>{$project_desc}</td>
        </tr>
        <tr>
          <th>Project Date</th>
          <td>{$project_date}</td>
        </tr>
      </table>
      <h2>KEGG Global Pathway</h2>
      <togostanza-kegg_global_map dataset="{$dataset_id}"></togostanza-kegg_global_map>
      <h2>Chromosome Info.</h2>
      <togostanza-dataset_chromosome dataset="{$dataset_id}"></togostanza-dataset_chromosome>
      <h2>Protein Existence</h2>
      <togostanza-protein_evidence dataset="{$dataset_id}"></togostanza-protein_evidence>
    <div class="component">
  </body>
</html>

<!--
<ul class="nav nav-tabs">
  <li class="nav-item active"><a class="nav-link bg-primary" href="#profile-table-tab" data-toggle="tab">Profile</a></li>
  <li class="nav-item"><a class="nav-link bg-primary" href="#protein-table-tab"  data-toggle="tab">Protein</a></li>
  <li class="nav-item"><a class="nav-link bg-primary" href="#peptide-table-tab"  data-toggle="tab">Peptide</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane fade in active table-panel" id="profile-table-tab">
    <table id="profile-table" class="display"></table>
  </div>
  <div class="tab-pane fade table-panel" id="protein-table-tab">
    <table id="protein-table" class="display"></table>
  </div>
  <div class="tab-pane fade table-panel" id="peptide-table-tab">
    <table id="peptide-table" class="display"></table>
  </div>
</div>

<form>
    <input type="hidden" value="{$dataset}" id="item_object">
</form>
-->