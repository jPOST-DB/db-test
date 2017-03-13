<?php
/* Smarty version 3.1.30, created on 2017-03-14 00:41:12
  from "C:\Users\Satoshi\workspace\jPOST\src\templates\html\protein.html.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c72e18e62ec2_68479287',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfcf60a9e8f944a3f1bac86c87411fd1968c20cd' => 
    array (
      0 => 'C:\\Users\\Satoshi\\workspace\\jPOST\\src\\templates\\html\\protein.html.tpl',
      1 => 1489448459,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c72e18e62ec2_68479287 (Smarty_Internal_Template $_smarty_tpl) {
?>
<h2>Dataset: <?php echo $_smarty_tpl->tpl_vars['protein_id']->value;?>
</h2>
<table class="table table-striped">
  <tr>
    <th>ID</th>
    <td><?php echo $_smarty_tpl->tpl_vars['protein_id']->value;?>
</td>
  </tr>
  <tr>
    <th>Label</th>
    <td><?php echo $_smarty_tpl->tpl_vars['protein_label']->value;?>
</td>
  </tr>
  <tr>
    <th>Mnemonic</th>
    <td><?php echo $_smarty_tpl->tpl_vars['mnemonic']->value;?>
</td>
  </tr>
  <tr>
    <th>Mass</th>
    <td><?php echo $_smarty_tpl->tpl_vars['mass']->value;?>
</td>
  </tr>
  <tr>
    <th>Sequence</th>
    <td style="word-break: break-all;"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</td>
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
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['protein_id']->value;?>
" id="item_id">
</form>
<?php }
}
