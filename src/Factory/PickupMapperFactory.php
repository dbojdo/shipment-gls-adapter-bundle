<?php
/**
 * File PickupMapperFactory.php
 * Created at: 2015-03-15 06-55
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\ShipmentGlsAdapterBundle\Factory;

use Webit\GlsAde\Api\PickupApi;
use Webit\Shipment\GlsAdapter\Mapper\ParcelMapper;
use Webit\Shipment\GlsAdapter\Mapper\PickupMapper;

class PickupMapperFactory
{
    /**
     * @var ParcelMapper
     */
    private $parcelMapper;

    public function __construct(ParcelMapper $parcelMapper)
    {
        $this->parcelMapper = $parcelMapper;
    }

    /**
     * @param PickupApi $pickupApi
     * @return PickupMapper
     */
    public function createPickupMapper(PickupApi $pickupApi)
    {
        return new PickupMapper($pickupApi, $this->parcelMapper);
    }
}