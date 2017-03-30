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
  <tr>
    <th>#Rawdata</th>
    <td>{$rawdata_num}</td>
  </tr>
  <tr>
    <th>#Protein</th>
    <td>{$protein_num}</td>
  </tr>
  <tr>
    <th>#Peptide</th>
    <td>{$peptide_num}</td>
  </tr>
  <tr>
    <th>#Psm</th>
    <td>{$psm_num}</td>
  </tr>
</table>

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
