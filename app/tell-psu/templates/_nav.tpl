<ul class="grid_16">
	<li><a href="{$PHP.BASE_URL}">Home</a></li>
	{if $admin}
	<li>
		<a href="{$PHP.BASE_URL}/admin">Administer</a>
		<ul>
			<li><a href="{$PHP.BASE_URL}/admin/view-answers">View Answers</a></li>
			<li><a href="{$PHP.BASE_URL}/admin/manage-questions">Manage Questions</a></li>
		</ul>
		</li>
	{/if}
</ul>
