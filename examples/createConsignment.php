<?php
require_once ('settings.php');

/**
 * Create a new consignment, then output the label
 */

use Dx\Models\Consignment;

// create session key
$application = new Dx\Application(DX_ACCOUNT_NUMBER, DX_SERVICE_CENTER, DX_PASSWORD);

// new Consignment
$consignment = new Consignment($application);
$consignment->setConsignmentReference('Alexandr');
$consignment->setServiceCode(Consignment::SERVICE_OVERNIGHT);

//create address
$address = new \Dx\Models\Address();
$address->setCompanyName('Matic Media')
    ->setAddressLine1('9 Hagmill Road')
    ->setAddressLine2('Coatbridge')
    ->setPostcode('ML5 4XD')
    ->setContactName('Alexandr')
    ->setPhoneNumber('07725197080');
$consignment->setDeliveryAddress($address);

//create packages
$packages = new Consignment\Packages();

//create one package
$package = new \Dx\Models\Package();
$package->setQuantity(1);
$package->setPackageType(\DX\Models\Package::TYPE_CARTONKG);
$package->setContentDescription('Box of signs');
$package->setTotalWeight(30);
$packages->add($package);

//create 3 pallets
$package = new \Dx\Models\Package();
$package->setQuantity(3);
$package->setPackageType(\DX\Models\Package::TYPE_PALLET);
$package->setContentDescription('Big pallet');
$package->setTotalWeight(300);
$packages->add($package);

$consignment->setPackages($packages);

echo $consignment->getConsignmentNumber() ?: 'No Consignment Number Set';

echo "\n";

$consignment->save();

echo $consignment->getConsignmentNumber() ?: "Error we didn't get a consignement number";

$label = $consignment->getLabels();

echo "\nGet the labels.\n";


$myfile = fopen("text.pdf", "w");
fwrite($myfile, $label->getContents());
fclose($myfile);


echo "Update the manifest date\n";
$date = new DateTime();
$interval = new DateInterval('P1D');
$date->add($interval);

$consignment->setManifestDate($date);
$consignment->save();






