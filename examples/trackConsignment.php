<?php
require_once ('settings.php');

$application = new Dx\Application(DX_ACCOUNT_NUMBER, DX_SERVICE_CENTER, DX_PASSWORD, false);

$consignment = new \Dx\Models\Consignment($application);
$consignment->setConsignmentNumber(DX_CONSIGNMENT_EXAMPLE['number']);
$deliveryAddress = new \Dx\Models\Address();
$deliveryAddress->setPostcode(DX_CONSIGNMENT_EXAMPLE['postcode']);
$consignment->setDeliveryAddress($deliveryAddress);

$consignment->track();
echo 'Status = ' . $consignment->getStatus() . '<br />' . "\n";
foreach($consignment->getLogs() as $log) {
    echo $log->getStage() . '<br />' . "\n";
}

$consignment = new \Dx\Models\Consignment($application);
$consignment->setConsignmentNumber(DX_CONSIGNMENT_EXAMPLE_DELIVERED['number']);
$deliveryAddress = new \Dx\Models\Address();
$deliveryAddress->setPostcode(DX_CONSIGNMENT_EXAMPLE_DELIVERED['postcode']);
$consignment->setDeliveryAddress($deliveryAddress);

$consignment->track();
echo $consignment->getStatus() . '<br />';
foreach($consignment->getLogs() as $log) {
    echo $log->getStage() . '<br />';
}