<?php
/**
 * File WebitShipmentGlsAdapterExtension.php
 * Created at: 2014-12-26 06-07
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\ShipmentGlsAdapterBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class WebitShipmentGlsAdapterExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $vendorFactoryFactory = $container->getDefinition('webit_shipment_gls_adapter.vendor_factory_factory');
        $vendorFactoryFactory->replaceArgument(0, $config['vendor_class']);

        $vendorFactory = $container->getDefinition('webit_shipment_gls_adapter.vendor_factory');
        $vendorFactory->addArgument($config['ade_account']);

        $adapter = $container->getDefinition('webit_shipment_gls_adapter.adapter');
        $adapter->addArgument($config['ade_account']);
        $adapter->addArgument($config['trace_account']);
    }
}
