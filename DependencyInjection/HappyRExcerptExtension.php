<?php

namespace HappyR\ExcerptBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class HappyRExcerptExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config=$this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $excerptServiceDef = $container->getDefinition('happyr.excerpt.service');

        if (defined('HHVM_VERSION')) {
            $excerptServiceDef->setClass($container->getParameter('happyr.excerpt.hack.class'));
        }

        $excerptServiceDef->replaceArgument(0, $config['length']);
        $excerptServiceDef->replaceArgument(1, $config['tail']);
    }
}
