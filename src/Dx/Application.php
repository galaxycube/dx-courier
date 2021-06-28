<?php


namespace Dx;


use Dx\Exceptions\BadRequest;
use Dx\Exceptions\InvalidConsignment;
use Dx\Exceptions\InvalidLabelRequest;
use Dx\Models\Consignment;
use Dx\Models\DxHelper;
use Dx\Models\SessionKey;
use Dx\Models\Consignment\Label;
use Psr\SimpleCache\CacheInterface;

class Application
{
    const CACHE_SESSION_KEY = 'DX_SESSION_KEY';

    /**
     * @var string represents the account number
     */
    private string $_accountNumber;
    /**
     * @var string represents the service center
     */
    private string $_serviceCenter;
    /**
     * @var string represents the password
     */
    private string $_password;

    /**
     * @var string represents the session key
     */
    private string $_sessionKey;

    /**
     * @var CacheInterface
     */
    private CacheInterface $_cache;

    public function __construct(string $accountNumber, string $serviceCenter, string $password, CacheInterface $cache = null)
    {
        $this->_accountNumber = $accountNumber;
        $this->_serviceCenter = $serviceCenter;
        $this->_password = $password;

        if ($cache !== null) {
            $this->_cache = $cache;
        }
    }

    /**
     * @param $property
     * @return false|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getCache($property)
    {
        if (!empty($this->_cache)) {

            return $this->_cache->get($property);
        }
        return false;
    }

    /**
     * @param string $property
     * @param $value
     * @param \DateTime|null $expiration
     */
    public function setCache(string $property, $value, \DateTime $expiration = null)
    {
        if (!empty($this->_cache)) {
            return $this->_cache->set($property, $value, $expiration);
        }
        return false;
    }

    /**
     * Updates the cache with the session key expiration time
     */
    private function updateSessionKeyCache(): void
    {
        $expiration = new \DateTime();
        $expirationTime = new \DateInterval('P30M'); // add 30 minutes
        $expiration->add($expirationTime);

        //check if the time is beyond maintenance
        if ($expiration->format('H') === '00' && $expiration->format('i') < 30) { //if the time is beyondmidnight
            $currentDate = new \DateTime();
            $expiration = new \DateTime($currentDate->format('Y-M-D') . ' 23:59:59'); // set the date to todays date with the expiration at 1 second before midnight
        }

        $this->setCache(self::CACHE_SESSION_KEY, $this->_sessionKey, $expiration);
    }

    /**
     * Returns the session key
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getSessionKey(): string
    {
        if (empty($this->_sessionKey)) {
            $sessionKey = $this->getCache(self::CACHE_SESSION_KEY);
            if (!$sessionKey) { //if session key is false then use API to get session key
                $sessionKey = new SessionKey($this->_accountNumber, $this->_serviceCenter, $this->_password);
                $this->_sessionKey = $sessionKey->getSessionKey(); //@todo throws error on failure
                $this->updateSessionKeyCache(); //update the timeout on the session key in the cache
            } else {
                $this->_sessionKey = $sessionKey;
            }
        }

        return $this->_sessionKey;
    }

    /**
     * Creates the consignment using DX couriers API
     * @param Consignment $consignment
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @todo create body
     */
    public function createConsignment(Consignment $consignment): Consignment
    {
        //create the delivery address
        $deliveryAddress = $consignment->getDeliveryAddress();

        //build packages array
        $packages = $consignment->getPackages();
        $submissionPackages = [];
        foreach ($packages as $package) {

            $submissionPackages[] = [
                "ContentDescription" => $package->getContentDescription(),
                "ContentDescriptionID" => $package->getPackageType(),
                "ContentDimension1" => $package->getWidth(),
                "ContentDimension2" => $package->getHeight(),
                "ContentDimension3" => $package->getLength(),
                "ContentQuantity" => $package->getQuantity(),
                "ContentTotalWeight" => $package->getTotalWeight()
            ];
        }

        $post = [
            "DXAccountNumber" => $this->_accountNumber,
            "PrintingUser" => "",
            "ManifestDate" => "/Date(" . $consignment->getManifestDate()->getTimestamp() * 1000 . ")/",
            "ConsignmentReference1" => $consignment->getConsignmentReference(),
            "OrigServiceCentre" => $this->_serviceCenter,
            "ServiceCode" => $consignment->getServiceCode(),
            "BookInFlag" => $consignment->isBookInFlag(),
            "InsuranceValue" => $consignment->getInsuranceValue(),
            "SpecialInstruction1" => $consignment->getSpecialInstructions(),
            "DeliveryName" => $deliveryAddress->getCompanyName(),
            "DeliveryAddress1" => $deliveryAddress->getAddressLine1(),
            "DeliveryAddress2" => $deliveryAddress->getAddressLine2(),
            "DeliveryAddress3" => $deliveryAddress->getAddressLine3(),
            "DeliveryAddress4" => $deliveryAddress->getAddressLine4(),
            "DeliveryAddress5" => $deliveryAddress->getAddressLine5(),
            "DeliveryPostcode" => $deliveryAddress->getPostcode(),
            "DeliveryPhoneNumber" => $deliveryAddress->getPhoneNumber(),
            "DeliveryEmail" => $deliveryAddress->getEmail(),
            "DeliveryContact" => $deliveryAddress->getContactName(),
            "PrivateAddress" => $deliveryAddress->isResidentialAddress(),
            "Contents" => $submissionPackages
        ];

        /**
         * //if collection
         * if($collectionAddress = $consignment->getCollectionAddress()) {
         * $collection = [
         * "CollectionAddress1" => $collectionAddress->getAddressLine1(),
         * "CollectionAddress2" => $collectionAddress->getAddressLine2(),
         * "CollectionAddress3" => $collectionAddress->getAddressLine3(),
         * "CollectionAddress4" => $collectionAddress->getAddressLine4(),
         * "CollectionAddress5" => $collectionAddress->getAddressLine5(),
         * "CollectionContact" => $collectionAddress->getContactName(),
         * "CollectionName" => $collectionAddress->getCompanyName(),
         * "CollectionEmail" => $collectionAddress->getEmail(),
         * "CollectionPhoneNumber" => $collectionAddress->getPhoneNumber(),
         * "CollectionPostcode" => $collectionAddress->getPostcode(),
         * "CollectionReference" => $consignment->getConsignmentReference(),
         * "DeliveryTo" => $deliveryAddress->getCompanyName(),
         * "DeliveryAddress3" => $deliveryAddress->getAddressLine3(),
         * "DeliveryAddress4" => $deliveryAddress->getAddressLine4(),
         * "DeliveryAddress5" => $deliveryAddress->getAddressLine5(),
         * "DeliveryPostcode" => $deliveryAddress->getPostcode(),
         * "DeliveryPhoneNumber" => $deliveryAddress->getPhoneNumber(),
         * "DeliveryEmail" => $deliveryAddress->getEmail(),
         * "DeliveryContact" => $deliveryAddress->getContactName(),
         * "PrivateAddress" => $deliveryAddress->isResidentialAddress(),
         * "Contents" => $submissionPackages
         * ];
         * }
         */
        // call
        $response = DxHelper::callApi($this->getSessionKey(), 'AddConsignment', $post);

        if (isset($response->Status) && $response->Status !== 0) {

            //print_r($response);

            throw new BadRequest($response->Status, isset($response->StatusMessage) ? $response->StatusMessage : null);
        }

        if (isset($response->ConsignmentNumber)) {

            $consignment->setConsignmentNumber($response->ConsignmentNumber);
        }

        if (isset($response->RoutingStream)) {

            $consignment->setRoutingStream($response->RoutingStream);
        }

        return $consignment;
    }

    /**
     * Updates the consignment date
     * @param Consignment $consignment
     * @return Consignment
     */
    public function updateConsignment(Consignment $consignment): Consignment
    {

        $post = [
            "ConsignmentNumber" => $consignment->getConsignmentNumber(),
            "RoutingStream" => $consignment->getRoutingStream(),
            "ManifestDate" => "/Date(" . $consignment->getManifestDate()->getTimestamp() * 1000 . ")/",
        ];

        // call
        $response = DxHelper::callApi($this->getSessionKey(), 'ReleaseConsignment', $post);

        if (isset($response->Status) && $response->Status !== 0) {

            throw new BadRequest($response->Status, isset($response->StatusMessage) ? $response->StatusMessage : null);
        }

        return $consignment;
    }

    /**
     * Tracks the consignment
     * @param Consignment $consignment
     * @todo create body
     */
    public function trackConsignment(Consignment $consignment): Consignment
    {
        if (!$consignment->getConsignmentNumber() || !$consignment->getRoutingStream()) {
            throw new InvalidConsignment('Cannot track consignment without consignment number or routing stream reference');
        }

        $post = [
            "ConsignmentNumber" => $consignment->getConsignmentNumber(),
            "RoutingStream" => $consignment->getRoutingStream()
        ];

        // call
        $response = DxHelper::callApi($this->getSessionKey(), 'GetConsignmentTrackingInfo', $post);

        print_r($response);

        return $consignment;
    }


    /**
     * Deletes the consignment
     * @param Consignment $consignment
     * @todo create body
     */
    public function deleteConsignment(Consignment $consignment): bool
    {
        return true;
    }


    /**
     * @param Consignment $consignment
     * @param int $labelFormat
     * @param int $labelSetup
     * @param int $labelsStartingPosition
     * @return Label
     * @throws BadRequest
     * @throws InvalidConsignment
     * @throws InvalidLabelRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getConsignmentLabel(Consignment $consignment, $labelFormat = Label::FORMAT_PDF, $labelSetup = Label::LABELS_PER_PAGE_1, $labelsStartingPosition = 1): Label
    {
        if (!$consignment->getConsignmentNumber() || !$consignment->getRoutingStream()) {
            throw new InvalidConsignment('Cannot track consignment without consignment number or routing stream reference');
        }

        if ($labelsStartingPosition < 1 || $labelsStartingPosition > 4) {
            throw new InvalidLabelRequest('Starting Position must be between 0 and 5');
        }

        $post = [
            "ConsignmentNumber" => $consignment->getConsignmentNumber(),
            "LabelReturnType" => $labelFormat,
            "PDFLabelConfig" => [
                "labelSetup" => $labelSetup,
                "startingPosition" => $labelsStartingPosition
            ],
            "PrintSelection" => 0,
            "RoutingStream" => $consignment->getRoutingStream()
        ];

        $response = DxHelper::callApi($this->getSessionKey(), 'GetLabels', $post);

        if (isset($response->Status) && $response->Status !== 0) {

            throw new BadRequest($response->Status, isset($response->StatusMessage) ? $response->StatusMessage : null);
        }



        if (isset($response->label)) {

            $label = new Label();
            $label->setConsignment($consignment);
            $label->setFileFormat($labelFormat);
            $label->setLabelsPerPage($labelSetup);
            $label->setStartingPosition($labelsStartingPosition);

            $label->setContents(base64_decode($response->label));
            $consignment->setLabels($label);

            return $label;
        }

    }
}