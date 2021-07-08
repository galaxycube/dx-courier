<?php
/**
 * Default settings file
 */

const DX_ACCOUNT_NUMBER = 'Account Number';
const DX_SERVICE_CENTER = 'Service Center';
const DX_PASSWORD = 'Password';

/**
 * This should be for an incomplete or not found consignment
 */
const DX_CONSIGNMENT_EXAMPLE = [
    'number' => 'Consignment Number',
    'postcode' => 'Consignment Postcode'
];

/**
 * This should be for a fully completed consignment
 */
const DX_CONSIGNMENT_EXAMPLE_DELIVERED = [
    'number' => 'Consignment Number',
    'postcode' => 'Consignment Postcode'
];

require_once '../vendor/autoload.php';