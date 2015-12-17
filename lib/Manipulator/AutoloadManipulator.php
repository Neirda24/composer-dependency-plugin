<?php

namespace Neirda24\Composer\ParentDependencyPlugin\Manipulator;

class AutoloadManipulator
{
    /**
     * @var string
     */
    protected $vendorDir;

    /**
     * AutoloadManipulator constructor.
     *
     * @param string $vendorDir
     */
    public function __construct($vendorDir)
    {
        $this->vendorDir = $vendorDir;
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->moveAutoloadClassmap();
        $this->moveAutoloadFiles();
        $this->moveAutoloadNamespaces();
        $this->moveAutoloadPsr4();
    }

    /**
     * @param string $oldName
     * @param string $newName
     *
     * @return bool
     */
    protected function moveFile($oldName, $newName)
    {
        return rename($this->vendorDir . '/composer/' . $oldName, $this->vendorDir . '/composer/' . $newName);
    }

    /**
     * @return bool
     */
    protected function moveAutoloadClassmap()
    {
        return $this->moveFile('autoload_classmap.php', 'autoload_classmap_child.php');
    }

    /**
     * @return bool
     */
    protected function moveAutoloadFiles()
    {
        return $this->moveFile('autoload_files.php', 'autoload_files_child.php');
    }

    /**
     * @return bool
     */
    protected function moveAutoloadNamespaces()
    {
        return $this->moveFile('autoload_namespaces.php', 'autoload_namespaces_child.php');
    }

    /**
     * @return bool
     */
    protected function moveAutoloadPsr4()
    {
        return $this->moveFile('autoload_psr4.php', 'autoload_psr4_child.php');
    }
}
