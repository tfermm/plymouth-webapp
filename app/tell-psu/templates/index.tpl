<script type="text/javascript" src="{$PHP.BASE_URL}/js/behavior.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css">
<div id="tp-accordion">
	{foreach from=$questions item=question}
		{if !$question->user_response($user->wp_id)}
			<h3>{$question->text}</h3>
			<div class="tp-question" id="tp-question-{$question->id}">
				<div class="tpq-form-container">
					<form id="tpq-form-{$question->id}" class="tpq-form" method="post" action="{$PHP.BASE_URL}/answer/{$question->id}/">
					{html_radios name='tp_response' options=$question->radio_answers() seperator='<br />'}
					<input type="submit" value="Answer!" />
					</form>
				</div>
		{else}
			<h3>{$question->text} (Answered)</h3>
			<div class="tp-question" id="tp-question-{$question->id}">
				<div class="tpq-form-container">
					{capture name=response assign=user_response}{$question->user_response($user->wp_id)->answer_id}{/capture}
					{html_radios name='tp_response' options=$question->radio_answers() selected=$user_response seperator='<br />' disabled=disabled}
				</div>
		{/if}
		{if $admin}
			<div class="tpq-results">
				<p>Hai!</p>
			</div>
		{/if}
		</div>
	{/foreach}
</div>
