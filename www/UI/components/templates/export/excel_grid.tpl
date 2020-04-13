<table border=1>
    <tr>
        {foreach item=Caption from=$HeaderCaptions}
            <td x:str>{$Caption}</td>
        {/foreach}
    </tr>
    {foreach item=Row from=$Rows name=RowsGrid}
        <tr>
            {foreach item=RowColumn from=$Row}
                <td{if $RowColumn.Align != null} align="{$RowColumn.Align}"{/if}>{$RowColumn.Value}</td>
            {/foreach}
        </tr>
    {/foreach}
    {include file='list/totals.tpl'}
</table>