<?php
	$aCus	= $call->fn_getCus('','',$_SESSION['cid']);
?>
<div class="container mt-2" style="">
	<div class="card bg-home rounded-4 border-0 mb-2" style="">
		<div class="card-header menu-box fs-4 border-0">
			<a href="<?=$link_home?>/" class=""><i class="fa-duotone fa-square-arrow-left pt-1"></i> <?=$_lang['home_page']?></a>
		</div>
	</div>
	<div class="card rounded bg-home p-3" style="">
		<div class="row " style="">
			
			<div class="col-12 ">
				<h3 class=""><img src="https://raw.githubusercontent.com/blackxs0001s/Bank/refs/heads/main/icon/icon_cash.png" style="height:50px" class="me-2"> รับเงินคืน </h3>
				<hr class="mt-2">
			</div>
			<div class="col-12">
				<div class="div_res">
					<div class="div_res_head" style="font-size:24px"><?=$_lang['price_return']?></div>
					<div class="div_res_body pt-3">
						<font class="h3 text-main" id="wallet_cashback"><?=number_format($aCus['wallet_backx'],2)?></font>
					</div>
					<div class="div_res_foot text-center">
						<a class="btn btn-success rounded-pill" id="btn_wit"><?=$_lang['wit_sp']?></a>	
					</div>
				</div>
			</div>
			<div class="col-12 mt-3">
				<h4 ><i class="fas fa-share-alt-square"></i> <?=$_lang['his_wl']?> </h4>
			</div>
			<div class="col-12 text-center">
				<div class="form-group clearfix">
					<div class="icheck-primary d-inline mr-3">
						<input type="radio" id="r1" name="search" value="D" checked>
						<label for="r1"><?=$_lang['day']?></label>
					</div>
					<div class="icheck-primary d-inline mr-3">
						<input type="radio" id="r2" name="search" value="W">
						<label for="r2"><?=$_lang['week']?></label>
					</div>
					<div class="icheck-primary d-inline ">
						<input type="radio" id="r3" name="search" value="M">
						<label for="r3"><?=$_lang['month']?></label>
					</div>
				</div>
			</div>
			<div class="col-12 mt-3">
				<table class="table table-bordered table-striped table-hover">
					<thead class="">
						<th class="text-center" style="background:#abf7f7"><?=$_lang['date_play']?></th>
						<th class="text-center" style="background:#abf7f7"><?=$_lang['win_lose']?></th>
						<th class="text-center" style="background:#abf7f7"><?=$_lang['price_return']?></th>
					</thead>
					<tbody id="t_report">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		PageCashback.fnJquery();
	});
</script>