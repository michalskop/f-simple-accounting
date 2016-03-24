{extends file='main.tpl'}
{block name=body}

    {include "header.tpl"}
      <div class="container">
        <h2>{$text['ledger']}</h2>
          <div class="row">
            <div class="col-md-6">
                <a href="../ledger/?y={$year}" class="btn btn-primary btn-lg">{$text['ledger']}</a>
            </div>
            <div class="col-md-6">
                <h4>{$text['filter']}:</h4>
                    <form class="form-inline" action="../ledger/">
                        <div class="form-group">
                            <label for="tag">{$text['tag']}:</label>
                            <input type="text" class="form-control" id="tag" name="tag" placeholder="{$text['ex_tag']} ...">
                        </div>
                        <div class="form-group">
                            <label for="account">{$text['account']}:</label>
                            <input type="text" class="form-control" id="account" name="account" placeholder="{$text['ex_account']} ...">
                        </div>
                        <div class="form-group">
                            <label for="since">{$text['since']}:</label>
                            <input type="text" class="form-control" id="since" name="since" placeholder="{$text['ex_since']} ...">
                        </div>
                        <div class="form-group">
                            <label for="until">{$text['until']}:</label>
                            <input type="text" class="form-control" id="until" name="until" placeholder="{$text['ex_until']} ...">
                        </div>
                        <button type="submit" class="btn btn-default">{$text['filter']} ({$text['ledger']})</button>
                        <input type="hidden" name="y" value="{$year}">
                    </form>
              </div>
          </div>

        <h2>{$text['journal']}</h2>
          <div class="col-md-6">
            <a href="../journal/?y={$year}" class="btn btn-primary btn-lg">{$text['journal']}</a>
          </div>
          <div class="col-md-6">
                <h4>{$text['filter']}:</h4>
                    <form class="form-inline" action="../journal/">
                        <div class="form-group">
                            <label for="tag">{$text['tag']}:</label>
                            <input type="text" class="form-control" id="tag" name="tag" placeholder="{$text['ex_tag']} ...">
                        </div>
                        <div class="form-group">
                            <label for="account">{$text['account']}:</label>
                            <input type="text" class="form-control" id="account" name="account" placeholder="{$text['ex_account']} ...">
                        </div>
                        <div class="form-group">
                            <label for="since">{$text['since']}:</label>
                            <input type="text" class="form-control" id="since" name="since" placeholder="{$text['ex_since']} ...">
                        </div>
                        <div class="form-group">
                            <label for="until">{$text['until']}:</label>
                            <input type="text" class="form-control" id="until" name="until" placeholder="{$text['ex_until']} ...">
                        </div>
                        <button type="submit" class="btn btn-default">{$text['filter']} ({$text['journal']})</button>
                        <input type="hidden" name="y" value="{$year}">
                    </form>
            </div>
      </div>
{/block}
