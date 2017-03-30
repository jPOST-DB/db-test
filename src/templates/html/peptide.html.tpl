<h2>Peptide: {$peptide_id}</h2>
<table class="table table-striped">
  <tr>
    <th>Peptide ID</th>
    <td>{$peptide_id}</td>
  </tr>
  <tr>
    <th>Label</th>
    <td style="word-break: break-all;">{$peptide_label}</td>
  </tr>
  <tr>
    <th>Protein</th>
    <td><a href="protein.php?object={$protein|escape:"url"}" target="jpost">{$full_name}</a></td>
  </tr>
</table>

<ul class="nav nav-tabs">
  <li class="nav-item active"><a class="nav-link bg-primary" href="#psm-table-tab" data-toggle="tab">PSM</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane fade in active table-panel" id="psm-table-tab">
    <table id="psm-table" class="display"></table>
  </div>
</div>

<form>
    <input type="hidden" value="{$peptide}" id="item_object">
</form>
