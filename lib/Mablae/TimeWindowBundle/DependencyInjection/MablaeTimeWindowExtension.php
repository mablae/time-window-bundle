<?php

namespace Mablae\TimeWindowBundle\DependencyInjection;

use Mablae\TimeWindowBundle\NamedTimeWindowCollection;
use Mablae\TimeWindowBundle\TimeWindow;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MablaeTimeWindowExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->loadTimeWindows($container, $config);
    }

    private function loadTimeWindows(ContainerBuilder $container, $config)
    {
        if (!$config['enabled'] || !is_array($config['time_windows'])) {
            return;
        }

        $timeWindowService = $container->getDefinition('mablae_time_window.service');
        foreach ($config['time_windows'] as $name => $timeWindows) {

            $collectionName = 'mablae_time_window.collection.'. $name;
            $collection = new Definition('Mablae\TimeWindowBundle\NamedTimeWindowCollection');
            $collection->addArgument($name);
            $collection->addArgument($timeWindows);
            $container->addDefinitions([$collectionName => $collection]);
            $timeWindowService->addMethodCall('registerNamedTimeWindowCollection' , [new Reference($collectionName)]);
        }


        return true;
    }
}
