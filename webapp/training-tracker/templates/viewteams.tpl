{PSU_JS src="$base_url/js/viewteams.js"}
{PSU_CSS src="$base_url/css/teams.css"}
<script>
	base_url = "{$base_url}";
</script>

{box title="Teams" class="teams" size="16"}
	{foreach from=$teams_array item=team}
		{if $team.mentor.mentor_name != $teams_array.unassigned.mentor.mentor_name}
			<h4 data-type="mentor" data-wpid="{$team.mentor.mentor_wpid}">{$team.mentor.mentor_name}{if is_admin} {icon id="ape-no" class="delete"}{/if}</h4>
			<ul class="clean">
			{foreach from=$team item=mentee}
				<li data-type="mentee" data-wpid="{$mentee.wpid}">
					{if is_admin && isset($mentee.wpid)}{$mentee.name} {icon id="ape-no" class="delete"}{elseif isset($mentee.wpid)}{$mentee.name}{/if}
				</li>
			{/foreach}
			</ul>
		{/if}
	{/foreach}
{/box}
