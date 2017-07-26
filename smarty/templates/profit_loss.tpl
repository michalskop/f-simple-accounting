{extends file='main.tpl'}
{block name=body}

    {include "header.tpl"}
    <div class="container">
        <h1>{$text['pl_short']}</h1>
        <h3>{$text['pl_day']}: {$days['until']|date_format}</h3>


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
                        <th>{$text['pl_row']}
                        <th>{$text['pl_value']} <small>(*1000)</small>
                </thead>
                <tbody>
                    {foreach $data->data as $d}
                        {$val = round($d->value * $d->sign / 1000)}
                        {$size = 1 + (2 - $d->level) / 5}
                        {$color = 255 - 20 * ($d->level - 1)}
                        <tr style='background-color: rgb({$color}, {$color}, {$color});'>
                            <td style='font-size: {$size}em'>{$d->text}
                            <td style='font-size: {$size}em;' class='text-right'>{if $val != 0}{$val}{/if}
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>

{/block}
