<?php
/**
 * File VendorFactoryFactory.php
 * Created at: 2014-12-27 18-17
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\ShipmentGlsAdapterBundle\Factory;

use Webit\Bundle\GlsBundle\Account\AccountManagerInterface;
use Webit\Bundle\GlsBundle\Api\ApiProvider;
use Webit\Shipment\GlsAdapter\Mapper\ServiceOptionMapper;
use Webit\Shipment\GlsAdapter\VendorFactory;

/**
 * Class VendorFactoryFactory
 * Be in hell for this class
 */
class VendorFactoryFactory
{
    /**
     * @var string
     */
    private $vendorClass;

    /**
     * @var ServiceOptionMapper
     */
    private $serviceOptionMapper;

    /**
     * @var ApiProvider
     */
    private $apiProvider;

    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    /**
     * @param string $vendorClass
     * @param ServiceOptionMapper $serviceOptionMapper
     * @param ApiProvider $apiProvider
     * @param AccountManagerInterface $accountManager
     */
    public function __construct(
        $vendorClass,
        ServiceOptionMapper $serviceOptionMapper,
        ApiProvider $apiProvider,
        AccountManagerInterface $accountManager
    ) {
        $this->vendorClass = $vendorClass;
        $this->serviceOptionMapper = $serviceOptionMapper;
        $this->apiProvider = $apiProvider;
        $this->accountManager = $accountManager;
    }

    /**
     * @param string $adeAccountAlias
     * @return VendorFactory
     */
    public function createVendorFactory($adeAccountAlias)
    {
        $adeAccount = $this->accountManager->getAdeAccount($adeAccountAlias);
        if (! $adeAccount) {
            throw new \UnexpectedValueException(sprintf('Cannot find GLS ADE account for alias "%s"', $adeAccountAlias));
        }

        return new VendorFactory(
            $this->vendorClass,
            $this->serviceOptionMapper,
            $this->apiProvider->getAdeServiceApi($adeAccount)
        );
    }
}