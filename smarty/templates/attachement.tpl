{extends file='main.tpl'}
{block name=body}

    {include "header.tpl"}
    <div class="container">
        <h1>{$text['att_short']}</h1>
        {$attachement}
    </div>

{/block}
