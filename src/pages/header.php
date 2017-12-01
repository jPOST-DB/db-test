<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo Config::$APPLICATION_NAME; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        <li id="search-panel-menu-item" class="menu-item active">
          <a href="javascript:jPost.showPanel('search-panel')">Search</a>
        </li>
        <li id="picked-datasets-panel-menu-item" class="menu-item">
          <a href="javascript:jPost.showPanel('picked-datasets-panel')">Datasets (Picked Up)</a>
        </li>
        <li id="picked-proteins-panel-menu-item" class="menu-item">
          <a href="javascript:jPost.showPanel('picked-proteins-panel')">Proteins (Picked Up)</a>
        </li>
        <li id="excepted-datasets-panel-menu-item" class="menu-item">
          <a href="javascript:jPost.showPanel('excepted-datasets-panel')">Datasets (Excepted)</a>
        </li>
        <li id="excepted-proteins-panel-menu-item" class="menu-item">
          <a href="javascript:jPost.showPanel('excepted-proteins-panel')">Proteins (Excepted)</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
