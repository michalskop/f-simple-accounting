<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">...</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../">{$text['brand']}</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li {if ($page == 'ledger')} class="active"{/if}><a href="../ledger/?y={$year}">{$text['ledger']}</a></li>
        <li {if ($page == 'journal')} class="active"{/if}><a href="../journal/?y={$year}">{$text['journal']}</a></li>
        <li {if ($page == 'financial_statements')} class="active"{/if}><a href="../financial-statements/?y={$year}">{$text['financial_statements']}</a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$year} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                  {foreach $settings->years as $syear}
                  <li><a href="./?y={$syear->year}">{$syear->year}</a>
                  {/foreach}
              </ul>
          <li><a href="{$settings->address_link}">{$settings->address}</a></li>
      </ul>
    </div>
  </div>
</nav>
