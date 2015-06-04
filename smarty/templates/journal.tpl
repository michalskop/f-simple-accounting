{extends file='main.tpl'}
{block name=body}
  
    {include "header.tpl"}
  <div class="container">  
    <h1>{$text['journal']}</h1>

    

            {if (count($filter) > 0)}
                <div class="alert alert-info">
                    <h4><i class="fa fa-info-circle"></i> {$text['filter']}</h4>
                    <strong>{$text['filter_explanation']}</strong><br>
                    {foreach $filter as $f}
                        {$text[$f@key]}: {$f}{if !($f@last)}, {/if}
                    {/foreach}
                </div>
            {/if}
            <div class="table-responsive">
            <table class="table table-bordered table-hover table-fixed">
                <thead>
                    <tr>
                    {foreach $text['settings_journal_columns'] as $col}
                        {$jcname = "jc_`$col`"}
                        <th>{$text[$jcname]}
                    {/foreach}
                    {foreach $data->data as $row}
                    <tr>
                        {foreach $text['settings_journal_columns'] as $col}
                            {$item = $row->$col}
                            <td>
                                {if strpos($item,'http') === 0}<a href="{$item}" target="_blank">{/if}
                                {if (($col == 'debit') or ($col == 'credit'))}
                                  {$tooltip = "`$col`_name"}
                                  <span data-toggle="tooltip" title="{$row->$tooltip}" class="tooltip-toggle">
                                {/if}
                                {$item}
                                {if (($col == 'debit') or ($col == 'credit'))}</span>{/if}
                                {if strpos($item,'http') === 0}</a>{/if}
                        {/foreach}
                    {/foreach}
            </table>
            </div>
            

  </div>
{/block}
