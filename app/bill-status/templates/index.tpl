<style>
  
  #bill-status div ul li a i span{
    padding-top: 4px;
  }
  #bill-status div ul li a{
    background: #e3e3e3;
    border: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    display: block;
    margin: 0 2px;
		padding: 0px 10px;
    border-top-right-radius: 0.5em;
    border-top-left-radius: 0.5em;
    -moz-top-radius-bottomright: 0.5em;
    -moz-top-radius-bottomleft: 0.5em;
    -webkit-border-top-right-radius: 0.5em;
    -webkit-border-top-left-radius: 0.5em;
  }
  #bill-status-tab-holder ul{
    list-style: none;
    padding-left: 0.45em;
    padding-right: 0.45em;
    border-top: 1px solid #ddd;
    margin: 0;
    padding: 0.5em 0 1.95em 0;
    margin-bottom: 0.5em;
  }

  #bill-status-tab-holder {
		width: 100%;
		float:left;
		background: #ddd;
	}
  #bill-status div ul li{
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
    text-align: center;
  }
  #bill-status div li.selected a{
    background: #fff;
    border-color: #fff;
  }
  .bill-status-warning a i span {
		height 45px;
  }
  .bill-status-error a i span {
		height 40px;
  }
  .bill-status-success a i span {
		height 40px;
  }  
	.bill-status-icon a i {
		height: 43px !important;
	}
	.bill-status-icon a i span {
		display: inline;
	}
  .bill-status-message{
		float:left;
    padding-top: 7px;
    padding-left: 7px;
    padding-right: 7px;
    border-bottom: 3px solid #ddd;
    border-left: 3px solid #ddd;
    border-right: 3px solid #ddd;
  }
	.bill-status-gray a i span{
		color: #bbb !important;
	}
	.bill-status-green a i span{
    color: #468847 !important;
	}
	.bill-status-yellow a i span{
    color: #c09853 !important;
	}
	.bill-status-red a i span{
    color: #b94a48 !important;
	}




	#bill-status-2{
		width: 100%;
		background: #ccc;
		margin-top: 2em;
    border: 1px solid #ccc;
	}
	#bill-status-container{
		margin: 3px 3px 3px 3px;
		background: #d6d6d6;
    border: 3px solid #b6b6b6;
	}
	#div-2{
		margin-left: 77px;
		min-height: 80px;
		margin-bottom: 0px;
		background: #fff;
		padding-top: 10px;
		padding-right: 3px;
		padding-left: 3px;
		padding-bottom: 5px;
		height: 100%;
	}
	#div-1{
		padding-top: 10px;
		float: left;
		height: 100%;
		width: 25%;
	}
	.bill-status-icon-2{
		margin-left: 7px;
	}
	.bill-status-icon-2 span sub{
		background: none !important;
		right: -4% !important;
		line-height: 0.7em !important;
		text-shadow: -1px 4px 0px #d6d6d6 !important;
	}
	.bill-status-icon-3 span sub{
		background: none !important;
		right: -8% !important;
		line-height: 0.6em !important;
		text-shadow: -1px 7px 0px #d6d6d6, 1px 7px 0px #d6d6d6 !important;
	}
	.bill-status-2-green span sub{
    color: #468847 !important;
	}
	.bill-status-2-yellow span sub{
    color: #c09853 !important;
	}
	.bill-status-2-red span sub{
    color: #b94a48 !important;
	}


</style>
<!--
{*
<div id="bill-status">
	<div id="bill-status-tab-holder">
		<ul>
			<li class="bill-status-icon bill-status-error{if $status.type == "NOT REGISTERED" || $status.type == "ERROR"} selected bill-status-red{else} bill-status-gray{/if}" style="margin-left: 0.5em;"><a>{icon id="ape-no" flat=true size=large class="bill-status-error"}</a></li>
			<li class="bill-status-icon bill-status-warning{if $status.type == "WARNING"} selected bill-status-yellow{else} bill-status-gray{/if}"><a>{icon id="warning-sign" flat=true size=large class="bill-status-warning"}</a></li>
			<li class="bill-status-icon bill-status-success{if $status.type == "PROTECTED"} selected bill-status-green{else} bill-status-gray{/if}"><a>{icon id="ape-yes" flat=true size=large class="bill-status-success"}</a></li>
		</ul>
	</div>
  <div class="bill-status-message">
    <p>{$status.message}</p>
  </div>
</div>
*}
-->
<div id="bill-status-2">
	<div id = "bill-status-container">
		<span id="div-1">
			{if $status.type == "NOT REGISTERED" || $status.type == "ERROR"} 
				{icon class="bill-status-icon-2 bill-status-2-red" id="ape-person" sub="ape-no" size=beefy flat=true}
			{elseif $status.type == "WARNING"} 
				{icon class="bill-status-icon-2 bill-status-2-yellow" id="ape-person" sub="ape-yes" size=beefy flat=true}
			{elseif $status.type == "PROTECTED"} 
				{icon class="bill-status-icon-3 bill-status-2-green" id="ape-person" sub="warning-sign" size=beefy flat=true}
			{/if}
		</span>
		<p id="div-2">
			{$status.message}
		</p>
	</div>
</div>
