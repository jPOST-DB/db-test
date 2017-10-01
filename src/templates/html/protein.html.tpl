<!DOCTYPE html>
<html>
  <head>
    <title>{$mnemonic} - jPOST</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="/ts/stanza/assets/components/webcomponentsjs/webcomponents.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h2>Protein: {$mnemonic}</h2>
      <table class="table table-striped">
      <tr>
        <th>Full Name</th>
        <td>{$full_name}</td>
      </tr>
      <tr>
        <th>Mnemonic</th>
        <td><a href="{$protein}" target="_blank">{$mnemonic}</a></td>
      </tr>
      <tr>
        <th>Mass</th>
        <td>{$mass}</td>
      </tr>
      <tr>
        <th>Sequence</th>
        <td style="word-break: break-all;">{$sequence}</td>
      </tr>
    </table>
  </body>
</html>
