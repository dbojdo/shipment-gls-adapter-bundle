<?php
/**
 * File Configuration.php
 * Created at: 2014-12-26 06-07
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\ShipmentGlsAdapterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('webit_shipment_gls_adapter');

        $root->children()
            ->scalarNode('vendor_class')->defaultValue('Webit\Shipment\Vendor\Vendor')->cannotBeEmpty()->end()
            ->scalarNode('ade_account')->cannotBeEmpty()->isRequired()->end()
            ->scalarNode('trace_account')->cannotBeEmpty()->isRequired()->end()
            ->arrayNode('default_sender_address')
                ->children()
                    ->scalarNode('name1')->cannotBeEmpty()->isRequired()->end()
                    ->scalarNode('name2')->defaultNull()->end()
                    ->scalarNode('name3')->defaultNull()->end()
                    ->scalarNode('address')->cannotBeEmpty()->isRequired()->end()
                    ->scalarNode('post_code')->cannotBeEmpty()->isRequired()->end()
                    ->scalarNode('post')->cannotBeEmpty()->isRequired()->end()
                    ->scalarNode('country')->cannotBeEmpty()->isRequired()->end()
                ->end()
            ->end()
            ->scalarNode('default_sender_address_provider')->end()
        ->end();

        return $treeBuilder;
    }
}
