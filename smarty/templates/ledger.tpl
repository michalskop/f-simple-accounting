{extends file='main.tpl'}
{block name=body}

    {include "header.tpl"}
  <div class="container">
    <h1>{$text['ledger']}</h1>

    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

    {if (count($filter) > 0)}
        <div class="alert alert-info">
            <h4><i class="fa fa-info-circle"></i> {$text['filter']}</h4>
            <strong>{$text['filter_explanation']}</strong><br>
            {foreach $filter as $f}
                {$text[$f@key]}: {$f}
                {if !($f@last)}, {/if}
            {/foreach}
        </div>
    {/if}

    {$i=0}
    {$j=0}
    {foreach $data->data as $ds}
        {if count($ds) > 0}
            {$accounts_name="accounts_`$ds@key`"}
            <h2>{$text[$accounts_name]}</h2>
            {foreach $ds as $account}
                <h3>{$account->account->number} {$account->account->name}
                    {$cs = $account->sums->start + $account->sums->debit - $account->sums->credit}
                    {if !(isset($filter['since']))}
                    <br>
                    <small><strong>{$text['current_state']}: {number_format($cs,2)}</strong>, {$text['1_1']}: {number_format($account->sums->start,2)}</small>
                    {/if}
                </h3>

                <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr><th>{$text['debit']}<th>{$text['credit']}<th>{$text['descript']}

                  <tbody>
                    <tr class="sums">
                        <td class="number-column"><strong>{number_format($account->sums->debit,2)}
                        <td class="number-column"><strong>{number_format($account->sums->credit,2)}
                        <td class="third-column">
                    <tr><td colspan="3">
                        <button type="button" class="btn btn-xs" data-toggle="collapse" data-target="#collapse_{$j}">{$text['details']}</button>


                  <tbody id="collapse_{$j}" class="collapse out">
                        {foreach $account->rows as $row}
                          {if !((strpos($row->debit,'96') === 0) or (strpos($row->credit,'96') === 0))}
                            <tr><td class="number-column">{if strpos($row->debit, $account->account->number) === 0}{number_format($row->amountczk,2)}{/if}
                                <td class="number-column">{if strpos($row->credit, $account->account->number) === 0}{number_format($row->amountczk,2)}{/if}
                                <td class="third-column"><a href="#" data-toggle="modal" data-target="#modal_{$i}">{$row->date} {$row->description}</a>

                                <div class="modal fade" id="modal_{$i}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4>{$text['details']}</h4>
                                      </div>
                                      <div class="modal-body">
                                        {foreach $row as $item}
                                          {$item_name="case_`$item@key`"}
                                          {if (isset($text[$item_name]))}
                                              <strong>{$text[$item_name]}</strong>:
                                              {if strpos($item,'http') === 0}<a href="{$item}" target="_blank">{/if} {$item}
                                              {if strpos($item,'http') === 0}</a>{/if}
                                              <br>
                                          {/if}
                                        {/foreach}
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">{$text['close']}</button>
                                      </div>
                                    </div>
                                  </div>
                                {$i=$i+1}
                          {/if}
                        {/foreach}
                    </tbody>
                    <tbody>
                        <tr><td colspan="3"><button type="button" class="btn btn-xs" data-toggle="collapse" data-target="#collapse_monthly_{$j}">{$text['monthly']}</button>
                    <tbody id="collapse_monthly_{$j}" class="collapse out">
                        {foreach $account->months as $month}
                            <tr><td class="number-column">{number_format($month->credit,2)}
                                <td class="number-column">{number_format($month->debit,2)}
                                {$m = "month_`$month@key`"}
                                <td class="third-column">{$text[$m]}
                        {/foreach}
                    </tbody>
                    {$j=$j+1}
                </table>
                </div>
            {/foreach}
        {/if}
    {/foreach}


        </div>
      </div>
    </div>

  </div>
{/block}
