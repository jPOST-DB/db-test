<h2>Dataset: {$protein_id}</h2>
<table class="table table-striped">
  <tr>
    <th>ID</th>
    <td>{$protein_id}</td>
  </tr>
  <tr>
    <th>Label</th>
    <td>{$protein_label}</td>
  </tr>
  <tr>
    <th>Mnemonic</th>
    <td>{$mnemonic}</td>
  </tr>
  <tr>
    <th>Mass</th>
    <td>{$mass}</td>
  </tr>
  <tr>
    <th>Sequence</th>
    <td style="word-break: break-all;">{$value}</td>
  </tr>
</table>

<ul class="nav nav-tabs">
  <li class="nav-item active"><a class="nav-link bg-primary" href="#dataset-table-tab" data-toggle="tab">Dataset</a></li>
  <li class="nav-item"><a class="nav-link bg-primary" href="#protein-table-tab"  data-toggle="tab">Related Protein</a></li>
  <li class="nav-item"><a class="nav-link bg-primary" href="#peptide-table-tab"  data-toggle="tab">Peptide</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane fade in active table-panel" id="dataset-table-tab">
    <table id="dataset-table" class="display"></table>
  </div>
  <div class="tab-pane fade table-panel" id="protein-table-tab">
    <table id="protein-table" class="display"></table>
  </div>
  <div class="tab-pane fade table-panel" id="peptide-table-tab">
    <table id="peptide-table" class="display"></table>
  </div>
</div>

<form>
    <input type="hidden" value="{$protein_id}" id="item_id">
</form>
