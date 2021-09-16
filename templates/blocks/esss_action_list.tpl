<ul class="list-group">
    <{foreach from=$block item=action}>
        <li class="list-group-item">
            <span class="badge badge-info">報名</span>
            <span>
                <a href="<{$xoops_url}>/modules/es_stud_sign/index.php?id=<{$action.id}>"><{$action.title}></a>
            </span>
        </li>
    <{/foreach}>
</ul>