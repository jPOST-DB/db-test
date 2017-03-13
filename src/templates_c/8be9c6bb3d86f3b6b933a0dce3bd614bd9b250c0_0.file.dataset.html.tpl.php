<?php
/* Smarty version 3.1.30, created on 2017-03-13 08:28:15
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\html\dataset.html.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c64a0fd4e883_66473067',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8be9c6bb3d86f3b6b933a0dce3bd614bd9b250c0' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\html\\dataset.html.tpl',
      1 => 1489389978,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c64a0fd4e883_66473067 (Smarty_Internal_Template $_smarty_tpl) {
?>
<h2>Dataset: <?php echo $_smarty_tpl->tpl_vars['dataset_id']->value;?>
</h2>
<table class="table table-striped">
  <tr>
    <th>ID</th>
    <td><?php echo $_smarty_tpl->tpl_vars['dataset_id']->value;?>
</td>
  </tr>
  <tr>
    <th>Project ID</th>
    <td><?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
</td>
  </tr>
  <tr>
    <th>Project Title</th>
    <td><?php echo $_smarty_tpl->tpl_vars['project_title']->value;?>
</td>
  </tr>
  <tr>
    <th>Project Description</th>
    <td><?php echo $_smarty_tpl->tpl_vars['project_desc']->value;?>
</td>
  </tr>
  <tr>
    <th>Project Date</th>
    <td><?php echo $_smarty_tpl->tpl_vars['project_date']->value;?>
</td>
  </tr>
  <tr>
    <th>#Rawdata</th>
    <td><?php echo $_smarty_tpl->tpl_vars['rawdata_num']->value;?>
</td>
  </tr>
  <tr>
    <th>#Protein</th>
    <td><?php echo $_smarty_tpl->tpl_vars['protein_num']->value;?>
</td>
  </tr>
  <tr>
    <th>#Peptide</th>
    <td><?php echo $_smarty_tpl->tpl_vars['peptide_num']->value;?>
</td>
  </tr>
  <tr>
    <th>#Psm</th>
    <td><?php echo $_smarty_tpl->tpl_vars['psm_num']->value;?>
</td>
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
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['dataset_id']->value;?>
" id="item_id">
</form>
<?php }
}
