<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      <a data-toggle="collapse" href="#search-form" id="search-filter-title">Filters</a>
    </h4>
  </div>
  <div class="panel-body collapse.show" id="search-form">
    <form onsubmit="jPost.search(); return false;">
      <div class="form-group">
        <label for="search-form-species">Species</label>
        <select id="species" name="species[]" class="form-control" size="1" style="display: none;" multiple>
        </select>
      </div>
      <div class="form-group">
        <label for="search-form-tissue">Tissue</label>
        <select id="tissue" name="tissue[]" class="form-control" size="1" style="display: none;" multiple>
        </select>
      </div>
      <div class="form-group">
        <label for="search-form-disease">Disease</label>
        <select id="disease" name="disease[]" class="form-control" size="1" style="display: none;" multiple>
        </select>
      </div>
      <div class="form-group">
        <label for="search-form-mod">Modification</label>
        <select id="modification" name="modification[]" class="form-control" size="1" style="display: none;" multiple>
        </select>
      </div>
      <div class="form-group">
        <label for="search-form-instrument">Instrument</label>
        <select id="instrument" name="instrument[]" class="form-control" size="1" style="display: none;" multiple>
        </select>
      </div>
      <div class="form-group">
        <label for="search-form-instmode">Instrument Mode</label>
        <select id="instrumentMode" name="instrumentMode[]" class="form-control" size="1" style="display: none;" multiple>
        </select>
      </div>
    </form>
  </div>
</div>

<div id="search-result">
</div>
