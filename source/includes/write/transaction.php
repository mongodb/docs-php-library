<?php
require 'vendor/autoload.php'; 

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// begin-callback
$receipts = $client->bank->receipts;
$checking = $client->bank->checking_accounts;
$saving = $client->bank->saving_accounts;

$accountId = '5678';
$transferAmount = 1000.00;

$callback = function (MongoDB\Driver\Session $session) 
    use ($checking, $saving, $receipts, $accountId, $transferAmount): void {

    $checking->updateOne(
           ['account_id' => $accountId],
           ['$inc' => ['balance' => -$transferAmount]],
           ['session' => $session]
    );
    
    $saving->updateOne(
        ['account_id' => $accountId],
        ['$inc' => ['balance' => $transferAmount]],
        ['session' => $session]
    );

    $summary = sprintf(
        "SAVINGS +%u CHECKING -%u.", $transferAmount, $transferAmount
    );

    $receipts->insertOne([
        'account_id' => $accountId,
        'description' => $summary,
        'timestamp' => new MongoDB\BSON\UTCDateTime((new DateTime())->getTimestamp()*1000),
    ], ['session' => $session]);

    echo 'Successfully performed transaction!\n';
};
// end-callback

// begin-txn
$session = $client->startSession();

try {
    MongoDB\with_transaction($session, $callback);
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '\n';
}
// end-txn