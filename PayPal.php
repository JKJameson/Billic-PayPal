<?php
class PayPal {
	public $settings = array(
		'description' => 'Accept payments via PayPal.',
	);
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
			$html.= '<input type="submit" class="btn btn-default" name="submit" value="Pay via PayPal">' . PHP_EOL;
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
			//$billic->email('josh@servebyte.com', 'PayPal Debug', json_encode($_POST));
			if (strpos($_POST['item_name'], 'Invoice #') !== false) {
				preg_match('~Invoice #([0-9]+)~', $_POST['item_name'], $invoiceid);
				$invoiceid = $invoiceid[1];
			} else if (strpos($_POST['item_name'], 'Service #') !== false) {
				preg_match('~Service \#([0-9]+)~', $_POST['item_name'], $serviceid);
				$serviceid = $serviceid[1];
				//$billic->email('josh@servebyte.com', 'PayPal Debug', 'Service ID: '.$serviceid);
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
				//$billic->email('josh@servebyte.com', 'PayPal Debug', 'Invoice ID: '.$serviceid);
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
					//$billic->email('josh@servebyte.com', 'PayPal Debug', 'Invoice ID: '.$serviceid);
					
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
