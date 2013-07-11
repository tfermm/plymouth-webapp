<style>
  
  #bill-status div ul li a i span{
    padding-top: 4px;
  }
  #bill-status div ul li a{
    background: #eee;
    border: 1px solid #bbb;
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
    color: #c09853 !important;
		height 45px;
  }
  .bill-status-error a i span {
    color: #b94a48 !important;
		height 40px;
  }
  .bill-status-success a i span {
    color: #468847 !important;
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
</style>

<div id="bill-status">
	<div id="bill-status-tab-holder">
		<ul>
			<li class="bill-status-icon bill-status-error{if $status.type == "NOT REGISTERED" || $status.type == "ERROR"} selected{/if}" style="margin-left: 0.5em;"><a>{icon id="ape-no" flat=true size=large class="bill-status-error"}</a></li>
			<li class="bill-status-icon bill-status-warning{if $status.type == "WARNING"} selected{/if}"><a>{icon id="warning-sign" flat=true size=large class="bill-status-warning"}</a></li>
			<li class="bill-status-icon bill-status-success{if $status.type == "PROTECTED"} selected{/if}"><a>{icon id="ape-yes" flat=true size=large class="bill-status-success"}</a></li>
		</ul>
	</div>
  <div class="bill-status-message">
    <p>{$status.message}</p>
  </div>
</div>
