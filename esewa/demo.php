<?php

require __DIR__.'/vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('Esewa_Secure');
$gateway->setMerchantCode('epay_payment'); // Ensure this is your correct merchant code
$gateway->setTestMode(true); // Change to false for live mode

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle initial purchase
    $response = $gateway->purchase([
        'amount'         => $_POST['amount'],
        'deliveryCharge' => $_POST['deliveryCharge'],
        'serviceCharge'  => $_POST['serviceCharge'],
        'taxAmount'      => $_POST['taxAmount'],
        'totalAmount'    => $_POST['totalAmount'],
        'productCode'    => $_POST['productCode'],
        'returnUrl'      => $_POST['returnUrl'],
        'failedUrl'      => $_POST['failedUrl'],
    ])->send();

    if ($response->isRedirect()) {
        $response->redirect();
    } else {
        // Handle failed purchase attempt
        echo 'Error: ' . $response->getMessage();
    }
} elseif (isset($_GET['referenceNumber']) && isset($_GET['status'])) {
    // Handle the callback from Esewa
    $referenceNumber = $_GET['referenceNumber'];
    $status = $_GET['status'];

    // Verify Payment
    $response = $gateway->verifyPayment([
        'amount'          => $_GET['amount'],
        'referenceNumber' => $referenceNumber,
        'productCode'     => $_GET['productCode'],
    ])->send();

    if ($response->isSuccessful()) {
        echo 1; // Indicate success
    } else {
        echo 'Payment verification failed.';
    }
} else {
    // Handle failed payment return or invalid request
    echo 'Invalid request.';
}
