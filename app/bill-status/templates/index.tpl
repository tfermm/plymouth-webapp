<style>
	
	#bill-status-tabs ul li a i span{
		padding-top: 0.2em;
	}
	#bill-status-tabs ul li a{
		background: #f5f5f5;
		border: 1px solid #ccc;
		border-bottom: 1px solid #f5f5f5;
		display: block;
		margin: 0 2px;
		padding: 0.15em 0.5em;
		border-top-right-radius: 0.5em;
		border-top-left-radius: 0.5em;
		-moz-top-radius-bottomright: 0.5em;
		-moz-top-radius-bottomleft: 0.5em;
		-webkit-border-top-right-radius: 0.5em;
		-webkit-border-top-left-radius: 0.5em;
	}
	#bill-status-tabs ul{
		list-style: none;
		border-top: 1px solid #ddd;
		padding-left: 0.45em;
		padding-right: 0.45em;
		background: #eee;
		margin: 0;
		padding: 0.5em 0 1.95em 0;
		margin-bottom: 0.5em;
	}
	#bill-status-tabs ul li{
		float: left;
		list-style: none;
		margin: 0;
		padding: 0;
		text-align: center;
	}
	#bill-status-tabs li.selected a{
		background: #fff;
		border-color: #fff;
	}
	.bill-status-warning a i span {
		color: #c09853 !important;
	}
	.bill-status-error a i span {
		color: #b94a48 !important;
	}
	.bill-status-success a i span {
		color: #468847 !important;
	}	
	.bill-status-message{
		margin-top: 0.5em;
	}
</style>

<div id="bill-status-tabs">
  <ul>
    <li class="bill-status-error{if $status.type == "NOT REGISTERED" || $status.type == "ERROR"} selected{/if}" style="margin-left: 0.5em;"><a>{icon style="color: #b94a48;" id="ape-no" flat=true size=small class=".bill-status-error"}</a></li>
    <li class="bill-status-warning{if $status.type == "WARNING"} selected{/if}"><a>{icon id="warning-sign" flat=true size=small class=".bill-status-warning"}</a></li>
    <li class="bill-status-success{if $status.type == "PROTECTED"} selected{/if}"><a>{icon id="ape-yes" flat=true size=small class=".bill-status-success"}</a></li>
  </ul>
  <div>
		<span class="bill-status-message">{$status.message}</span>
  </div>
</div>
