<?php
class PayPal {
	public $settings = array(
		'description' => 'Accept payments via PayPal.',
	);
	function payment_features() {
		return '<img src="data:image/png;base64,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">';	
	}
	function payment_button($params) {
		global $billic, $db;
		$html = '';
		if (get_config('paypal_email') == '') {
			return $html;
		}
		if ($billic->user['verified'] == 0 && get_config('paypal_require_verification') == 1) {
			return 'verify';
		} else {
			// One-time payment button
			$html.= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">' . PHP_EOL;
			$html.= '<input type="hidden" name="cmd" value="_xclick">' . PHP_EOL;
			$html.= '<input type="hidden" name="business" value="' . get_config('paypal_email') . '"><input type="hidden" name="item_name" value="Invoice #' . $params['invoice']['id'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="amount" value="' . $params['charge'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="tax" value="' . $params['vat'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="no_note" value="1">' . PHP_EOL;
			$html.= '<input type="hidden" name="no_shipping" value="1">' . PHP_EOL;
			$html.= '<input type="hidden" name="first_name" value="' . $billic->user['firstname'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="last_name" value="' . $billic->user['lastname'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="address1" value="' . $billic->user['address1'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="city" value="' . $billic->user['city'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="state" value="' . $billic->user['state'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="zip" value="' . $billic->user['postcode'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="country" value="' . $billic->user['country'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="H_PhoneNumber" value="' . $billic->user['phonenumber'] . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="charset" value="utf-8">' . PHP_EOL;
			$html.= '<input type="hidden" name="currency_code" value="' . get_config('billic_currency_code') . '">' . PHP_EOL;
			$html.= '<input type="hidden" name="return" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/User/Invoices/ID/' . $params['invoice']['id'] . '/Status/Complete/">' . PHP_EOL;
			$html.= '<input type="hidden" name="cancel_return" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/User/Invoices/ID/' . $params['invoice']['id'] . '/Status/Cancelled/">' . PHP_EOL;
			$html.= '<input type="hidden" name="notify_url" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/Gateway/PayPal/">' . PHP_EOL;
			$html.= '<input type="hidden" name="rm" value="1">' . PHP_EOL;
			$html.= '<input type="submit" class="btn btn-default" name="submit" value="Pay by PayPal">' . PHP_EOL;
			$html.= '</form>';
			// get service if applicable
			$serviceid = false;
			$items = $db->q('SELECT * FROM `invoiceitems` WHERE `invoiceid` = ?', $params['invoice']['id']);
			foreach ($items as $item) {
				if ($item['relid'] > 0) {
					$serviceid = $item['relid'];
				}
			}
			if ($serviceid !== false) {
				// get days of billing cycle
				$billingcycle = $db->q('SELECT `billingcycle` FROM `services` WHERE `id` = ?', $serviceid);
				$billingcycle = $billingcycle[0]['billingcycle'];
				if (empty($billingcycle)) {
					$serviceid = false;
				} else {
					$billingcycle = $db->q('SELECT * FROM `billingcycles` WHERE `name` = ?', $billingcycle);
					$billingcycle = $billingcycle[0];
					if (empty($billingcycle)) {
						$serviceid = false;
					} else {
						$days = ceil($billingcycle['seconds'] / 60 / 60 / 24);
						$pp_a3 = 'D';
						if ($days < 1) {
							$serviceid = false;
						}
					}
				}
			}
			if ($serviceid !== false) {
				// Subscription payment button
				$html.= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">' . PHP_EOL;
				$html.= '<input type="hidden" name="cmd" value="_xclick-subscriptions">' . PHP_EOL;
				$html.= '<input type="hidden" name="business" value="' . get_config('paypal_email') . '"><input type="hidden" name="item_name" value="Service #' . $serviceid . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="src" value="1">' . PHP_EOL;
				$html.= '<input type="hidden" name="a3" value="' . $params['charge'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="p3" value="' . $days . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="t3" value="' . $pp_a3 . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="no_note" value="1">' . PHP_EOL;
				$html.= '<input type="hidden" name="no_shipping" value="1">' . PHP_EOL;
				$html.= '<input type="hidden" name="first_name" value="' . $billic->user['firstname'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="last_name" value="' . $billic->user['lastname'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="address1" value="' . $billic->user['address1'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="city" value="' . $billic->user['city'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="state" value="' . $billic->user['state'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="zip" value="' . $billic->user['postcode'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="country" value="' . $billic->user['country'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="H_PhoneNumber" value="' . $billic->user['phonenumber'] . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="charset" value="utf-8">' . PHP_EOL;
				$html.= '<input type="hidden" name="currency_code" value="' . get_config('billic_currency_code') . '">' . PHP_EOL;
				$html.= '<input type="hidden" name="return" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/User/Invoices/ID/' . $params['invoice']['id'] . '/Status/Complete/">' . PHP_EOL;
				$html.= '<input type="hidden" name="cancel_return" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/User/Invoices/ID/' . $params['invoice']['id'] . '/Status/Cancelled/">' . PHP_EOL;
				$html.= '<input type="hidden" name="notify_url" value="http' . (get_config('billic_ssl') == 1 ? 's' : '') . '://' . get_config('billic_domain') . '/Gateway/PayPal/">' . PHP_EOL;
				$html.= '<input type="hidden" name="rm" value="1">' . PHP_EOL;
				$html.= '<input type="submit" class="btn btn-default" name="submit" value="Subscribe via PayPal">' . PHP_EOL;
				$html.= '</form>';
			}
		}
		return $html;
	}
	function payment_callback() {
		global $billic, $db;
		if ($_POST['payment_status'] != 'Completed') {
			return 'payment_status != Completed';
		}
		if ($_POST['receiver_email'] != get_config('paypal_email') && $_POST['business'] != get_config('paypal_email')) {
			return 'receiver_email does not match paypal email';
		}
		// post back to PayPal system to validate
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$req.= '&' . $key . '=' . urlencode(stripslashes($value));
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr');
		$data = curl_exec($ch);
		if ($data === false) {
			$error = curl_error($ch);
			return 'Curl Error: ' . $error;
		}
		curl_close($ch);
		if (strcmp($data, 'VERIFIED') == 0) {
			$billic->module('Invoices');
			if (strpos($_POST['item_name'], 'Invoice #') !== false) {
				preg_match('~Invoice #([0-9]+)~', $_POST['item_name'], $invoiceid);
				$invoiceid = $invoiceid[1];
			} else if (strpos($_POST['item_name'], 'Service #') !== false) {
				preg_match('~Service \#([0-9]+)~', $_POST['item_name'], $serviceid);
				$serviceid = $serviceid[1];
				$invoiceid = $db->q('SELECT `invoiceid` FROM `invoiceitems` WHERE `relid` = ? ORDER BY `id` DESC', $serviceid);
				$invoiceid = $invoiceid[0]['invoiceid'];
				$generate = false;
				if (empty($invoiceid)) {
					$generate = true;
				} else {
					$invoice = $db->q('SELECT * FROM `invoices` WHERE `id` = ? AND `status` = ?', $invoiceid, 'Unpaid');
					$invoice = $invoice[0];
					if (empty($invoice) || $invoice['status'] != 'Unpaid') {
						$generate = true;
					}
				}
				if ($generate) {
					$service = $db->q('SELECT * FROM `services` WHERE `id` = ?', $serviceid);
					$service = $service[0];
					$user = $db->q('SELECT * FROM `users` WHERE `id` = ?', $service['userid']);
					$user = $service[0];
					$invoiceid = $billic->modules['Invoices']->generate(array(
						'service' => $service,
						'user' => $user,
						'duedate' => $service['nextduedate'],
					));
				}
			}
			if (!is_numeric($invoiceid)) {
				return 'Unable to determine the Invoice ID';
			}
			return $billic->modules['Invoices']->addpayment(array(
				'gateway' => 'PayPal',
				'invoiceid' => $invoiceid,
				'amount' => ($_POST['mc_gross'] + $_POST['tax']) ,
				'currency' => $_POST['mc_currency'],
				'transactionid' => $_POST['txn_id'],
			));
		} else if (strcmp($data, 'INVALID') == 0) {
			return 'invalid transaction hash';
		}
		return 'Invalid data from PayPal';
	}
	function settings($array) {
		global $billic, $db;
		if (empty($_POST['update'])) {
			echo '<form method="POST"><input type="hidden" name="billic_ajax_module" value="PayPal"><table class="table table-striped">';
			echo '<tr><th>Setting</th><th>Value</th></tr>';
			echo '<tr><td>Require Verification</td><td><input type="checkbox" name="paypal_require_verification" value="1"' . (get_config('paypal_require_verification') == 1 ? ' checked' : '') . '></td></tr>';
			echo '<tr><td>PayPal Email</td><td><input type="text" class="form-control" name="paypal_email" value="' . safe(get_config('paypal_email')) . '"></td></tr>';
			echo '<tr><td colspan="2" align="center"><input type="submit" class="btn btn-default" name="update" value="Update &raquo;"></td></tr>';
			echo '</table></form>';
		} else {
			if (empty($billic->errors)) {
				set_config('paypal_require_verification', $_POST['paypal_require_verification']);
				set_config('paypal_email', $_POST['paypal_email']);
				$billic->status = 'updated';
			}
		}
	}
}
