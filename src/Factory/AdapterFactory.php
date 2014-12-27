<?php
/**
 * File AdapterFactory.php
 * Created at: 2014-12-27 17-05
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\ShipmentGlsAdapterBundle\Factory;

use Webit\Bundle\GlsBundle\Account\AccountManagerInterface;
use Webit\Bundle\GlsBundle\Api\ApiProviderInterface;
use Webit\GlsTracking\UrlProvider\TrackingUrlProvider;
use Webit\Shipment\GlsAdapter\Mapper\ConsignmentMapper;
use Webit\Shipment\GlsAdapter\Mapper\GlsConsignmentMapper;
use Webit\Shipment\GlsAdapter\Mapper\PickupMapper;
use Webit\Shipment\GlsAdapter\ShipmentGlsAdapter;
use Webit\Shipment\GlsAdapter\VendorFactory;

class AdapterFactory
{
    /**
     * @var ApiProviderInterface
     */
    private $apiProvider;

    /**
     * @var TrackingUrlProvider
     */
    private $trackingUrlProvider;

    /**
     * @var VendorFactory
     */
    private $vendorFactory;

    /**
     * @var ConsignmentMapper
     */
    private $consignmentMapper;

    /**
     * @var GlsConsignmentMapper
     */
    private $glsConsignmentMapper;

    /**
     * @var PickupMapper
     */
    private $pickupMapper;
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    /**
     * @param AccountManagerInterface $accountManager
     * @param ApiProviderInterface $apiProvider
     * @param TrackingUrlProvider $trackingUrlProvider
     * @param VendorFactory $vendorFactory
     * @param ConsignmentMapper $consignmentMapper
     * @param GlsConsignmentMapper $glsConsignmentMapper
     * @param PickupMapper $pickupMapper
     */
    public function __construct(
        AccountManagerInterface $accountManager,
        ApiProviderInterface $apiProvider,
        TrackingUrlProvider $trackingUrlProvider,
        VendorFactory $vendorFactory,
        ConsignmentMapper $consignmentMapper,
        GlsConsignmentMapper $glsConsignmentMapper,
        PickupMapper $pickupMapper
    ) {
        $this->accountManager = $accountManager;
        $this->apiProvider = $apiProvider;
        $this->trackingUrlProvider = $trackingUrlProvider;
        $this->vendorFactory = $vendorFactory;
        $this->consignmentMapper = $consignmentMapper;
        $this->glsConsignmentMapper = $glsConsignmentMapper;
        $this->pickupMapper = $pickupMapper;
    }

    /**
     * @param string $adeAccountAlias
     * @param string $traceAccountAlias
     * @return ShipmentGlsAdapter
     */
    public function createAdapter($adeAccountAlias, $traceAccountAlias)
    {
        $adeAccount = $this->accountManager->getAdeAccount($adeAccountAlias);
        if (! $adeAccount) {
            throw new \UnexpectedValueException(sprintf('Cannot find GLS ADE account for alias "%s"', $adeAccountAlias));
        }

        $traceAccount = $this->accountManager->getTrackAccount($traceAccountAlias);
        if (! $traceAccount) {
            throw new \UnexpectedValueException(sprintf('Cannot find GLS ADE account for alias "%s"', $traceAccountAlias));
        }

        return new ShipmentGlsAdapter(
            $this->apiProvider->getAdeConsignmentPrepareApi($adeAccount),
            $this->apiProvider->getAdePickupApi($adeAccount),
            $this->apiProvider->getTrackingApi($traceAccount),
            $this->trackingUrlProvider,
            $this->vendorFactory,
            $this->consignmentMapper,
            $this->glsConsignmentMapper,
            $this->pickupMapper
        );
    }
}
