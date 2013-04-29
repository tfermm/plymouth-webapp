<script type="text/javascript" src="{$PHP.BASE_URL}/js/behavior.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css">
<div id="tp-accordion">
	{foreach from=$questions item=question}
		{if !$question->user_response($user->wp_id)}
			<h3 class="tp-question-header" id="tp-question-header-{$question->id}">{$question->text}</h3>
			<div class="tp-question" id="tp-question-{$question->id}">
				<div class="tpq-form-container">
					<form id="tpq-form-{$question->id}" class="tpq-form" method="post" action="{$PHP.BASE_URL}/answer/{$question->id}/">
					{html_radios name='tp_response' options=$question->radio_answers() seperator='<br />'}
					<input type="submit" value="Answer!" />
					</form>
				</div>
		{else}
			<h3 class="tp-question-header tp-question-answered" id="tp-question-header-{$question->id}">{$question->text} (Answered)</h3>
			<div class="tp-question" id="tp-question-{$question->id}">
				<div class="tpq-form-container">
					{capture name=response assign=user_response}{$question->user_response($user->wp_id)->answer_id}{/capture}
					{if $admin}
					<ul class="tpq-results">
					{foreach from=$question->answers() item=answer}
						<li{if $user_response==$answer->id} class="tpq-result user-selected" style="color: green" {else} class="tpq-result"{/if}>{$answer->text} - {$answer->percent_response()}% ( {$answer->responses()->count()} )</li>
					{/foreach}
					</ul>
					{else}
						{capture name=response_name assign=user_response_name}tp_response_{$question->id}{/capture}
						{html_radios name=$user_response_name options=$question->radio_answers() selected=$user_response disabled=disabled}
					{/if}
				</div>
		{/if}
		</div>
	{foreachelse}
		<h3>There are currently no polls available to you at this time.</h3>
	{/foreach}
</div>
