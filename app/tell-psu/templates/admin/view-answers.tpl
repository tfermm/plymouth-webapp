{foreach from=$questions item=question}
	{capture name=active assign=question_active}({if $question->active}Active{else}Inactive{/if}){/capture}
	{box title=$question->text title_size=8 secondary_title=$question_active size="16"}
		<ul class="tpq-results">
		{foreach from=$question->answers() item=answer}
			<li>{$answer->text} - {$answer->percent_response()}% ( {$answer->responses()->count()} )</li>
		{/foreach}
		</ul>
	{/box}
{foreachelse}
	{box title="Question Answers" size="16"}
		<h3>There are no questions that have been answered at this time.</h3>
	{/box}
{/foreach}
