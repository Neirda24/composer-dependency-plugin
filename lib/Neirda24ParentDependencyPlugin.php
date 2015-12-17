<?php

namespace Neirda24\Composer\ParentDependencyPlugin;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\InstallerEvent;
use Composer\Installer\InstallerEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Neirda24\Composer\ParentDependencyPlugin\Container\ParentContainer;
use Neirda24\Composer\ParentDependencyPlugin\Dumper\AutoloadDumper;
use Neirda24\Composer\ParentDependencyPlugin\Manipulator\AutoloadManipulator;
use Symfony\Component\Console\ConsoleEvents;

class Neirda24ParentDependencyPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var string
     */
    const COMPOSER_CONFIG_KEY_EXTRA = 'neirda24-parent-dependency';

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @var ParentContainer
     */
    protected $parentContainer;

    /**
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $extra = $composer->getPackage()->getExtra();
        if (!array_key_exists(static::COMPOSER_CONFIG_KEY_EXTRA, $extra)) {
            // Throw exception
        } elseif (!array_key_exists('path', $extra[static::COMPOSER_CONFIG_KEY_EXTRA])) {
            // throw execption
        }
        $this->composer        = $composer;
        $this->io              = $io;
        $this->parentContainer = new ParentContainer($extra[static::COMPOSER_CONFIG_KEY_EXTRA]['path']);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'post-autoload-dump' => [
                ['moveFiles', 0],
                ['dumpFiles', 0],
            ],
        ];
    }

    /**
     * Move the old files.
     *
     * @param Event $event
     */
    public function moveFiles(Event $event)
    {
        $manipulator = new AutoloadManipulator($this->composer->getConfig()->get('vendor-dir'));
        $manipulator->run();
    }

    /**
     * Dump the new files
     *
     * @param Event $event
     */
    public function dumpFiles(Event $event)
    {
        $dumper = new AutoloadDumper($this->parentContainer, $this->composer->getConfig()->get('vendor-dir'));
        $dumper->run();
    }

}
