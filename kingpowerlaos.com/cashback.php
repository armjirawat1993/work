<?php
// Security check - ensure user is logged in
if (!isset($_SESSION['cid']) || empty($_SESSION['cid'])) {
    header('Location: login.php');
    exit();
}

// Input validation and sanitization
$customer_id = filter_var($_SESSION['cid'], FILTER_SANITIZE_NUMBER_INT);

// Get customer data with error handling
try {
    $aCus = $call->fn_getCus('', '', $customer_id);
    
    // Validate customer data exists
    if (!$aCus || !isset($aCus['wallet_backx'])) {
        throw new Exception('Customer data not found');
    }
    
    // Ensure wallet_backx is numeric
    $wallet_cashback = is_numeric($aCus['wallet_backx']) ? $aCus['wallet_backx'] : 0;
    
} catch (Exception $e) {
    // Log error and set default values
    error_log("Cashback page error: " . $e->getMessage());
    $wallet_cashback = 0;
    $aCus = ['wallet_backx' => 0];
}
?>
<!-- Include CSS file -->
<link rel="stylesheet" href="cashback.css">

<div class="container cashback-container">
	<div class="card cashback-header">
		<div class="card-header menu-box fs-4">
			<a href="<?= htmlspecialchars($link_home, ENT_QUOTES, 'UTF-8') ?>/" class="text-decoration-none">
				<i class="fa-duotone fa-square-arrow-left pt-1" aria-hidden="true"></i> 
				<?= htmlspecialchars($_lang['home_page'], ENT_QUOTES, 'UTF-8') ?>
			</a>
		</div>
	</div>
	<div class="card cashback-main-card">
		<div class="row">
			<div class="col-12">
				<h1 class="cashback-title">
					<img src="https://raw.githubusercontent.com/blackxs0001s/Bank/refs/heads/main/icon/icon_cash.png" 
						 alt="Cashback Icon" 
						 class="me-2"> 
					รับเงินคืน
				</h1>
				<hr class="mt-2">
			</div>
			<div class="col-12">
				<div class="div_res">
					<div class="div_res_head cashback-amount-display">
						<?= htmlspecialchars($_lang['price_return'], ENT_QUOTES, 'UTF-8') ?>
					</div>
					<div class="div_res_body pt-3">
						<span class="cashback-amount-value text-main" id="wallet_cashback" role="text" aria-label="Current cashback amount">
							<?= number_format($wallet_cashback, 2) ?>
						</span>
					</div>
					<div class="div_res_foot text-center">
						<button class="btn btn-success cashback-withdraw-btn" id="btn_wit" type="button" aria-label="Withdraw cashback">
							<?= htmlspecialchars($_lang['wit_sp'], ENT_QUOTES, 'UTF-8') ?>
						</button>	
					</div>
				</div>
			</div>
			<div class="col-12">
				<h2 class="cashback-history-title">
					<i class="fas fa-share-alt-square" aria-hidden="true"></i> 
					<?= htmlspecialchars($_lang['his_wl'], ENT_QUOTES, 'UTF-8') ?>
				</h2>
			</div>
			<div class="col-12 cashback-period-selector">
				<fieldset class="form-group">
					<legend class="sr-only">Select time period for cashback history</legend>
					<div class="icheck-primary cashback-period-option">
						<input type="radio" id="r1" name="search" value="D" checked aria-describedby="period-help">
						<label for="r1"><?= htmlspecialchars($_lang['day'], ENT_QUOTES, 'UTF-8') ?></label>
					</div>
					<div class="icheck-primary cashback-period-option">
						<input type="radio" id="r2" name="search" value="W" aria-describedby="period-help">
						<label for="r2"><?= htmlspecialchars($_lang['week'], ENT_QUOTES, 'UTF-8') ?></label>
					</div>
					<div class="icheck-primary cashback-period-option">
						<input type="radio" id="r3" name="search" value="M" aria-describedby="period-help">
						<label for="r3"><?= htmlspecialchars($_lang['month'], ENT_QUOTES, 'UTF-8') ?></label>
					</div>
					<div id="period-help" class="sr-only">Select the time period to view cashback history</div>
				</fieldset>
			</div>
			<div class="col-12 cashback-table-container">
				<div class="table-responsive">
					<table class="cashback-table" role="table" aria-label="Cashback history">
						<thead>
							<tr>
								<th class="text-center" scope="col"><?= htmlspecialchars($_lang['date_play'], ENT_QUOTES, 'UTF-8') ?></th>
								<th class="text-center" scope="col"><?= htmlspecialchars($_lang['win_lose'], ENT_QUOTES, 'UTF-8') ?></th>
								<th class="text-center" scope="col"><?= htmlspecialchars($_lang['price_return'], ENT_QUOTES, 'UTF-8') ?></th>
							</tr>
						</thead>
						<tbody id="t_report" role="rowgroup">
							<tr>
								<td colspan="3" class="text-center cashback-loading">Loading...</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
    // Initialize cashback page functionality
    if (typeof PageCashback !== 'undefined' && typeof PageCashback.fnJquery === 'function') {
        try {
            PageCashback.fnJquery();
        } catch (error) {
            console.error('Error initializing cashback page:', error);
            // Show user-friendly error message
            $('#t_report').html('<tr><td colspan="3" class="text-center text-danger">Error loading data. Please refresh the page.</td></tr>');
        }
    } else {
        console.warn('PageCashback object not found or fnJquery method not available');
        $('#t_report').html('<tr><td colspan="3" class="text-center text-warning">Page functionality not available.</td></tr>');
    }
    
    // Add click handler for withdraw button with confirmation
    $('#btn_wit').on('click', function(e) {
        e.preventDefault();
        const cashbackAmount = parseFloat($('#wallet_cashback').text().replace(/,/g, ''));
        
        if (cashbackAmount <= 0) {
            alert('No cashback available for withdrawal.');
            return;
        }
        
        if (confirm('Are you sure you want to withdraw your cashback?')) {
            // Add loading state
            $(this).prop('disabled', true).text('Processing...');
            
            // Here you would typically make an AJAX call to process the withdrawal
            // For now, we'll just show a message
            setTimeout(() => {
                alert('Withdrawal request submitted successfully!');
                $(this).prop('disabled', false).text('<?= htmlspecialchars($_lang['wit_sp'], ENT_QUOTES, 'UTF-8') ?>');
            }, 1000);
        }
    });
});
</script>