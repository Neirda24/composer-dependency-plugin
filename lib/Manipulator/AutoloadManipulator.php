<?php

namespace Neirda24\Composer\ParentDependencyPlugin\Manipulator;

/**
 * Class AutoloadManipulator
 *
 * @author Adrien Schaegis <adrien@iron-mail.net>
 *
 * Manipulator of the existing autoload files.
 */
class AutoloadManipulator
{
    /**
     * Relative path to the vendor directory of the current project.
     *
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
     * Move all files.
     *
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
     * Rename one autoload file into something else.
     *
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
     * Rename "autoload_classmap.php" into "autoload_classmap_child.php"
     *
     * @return bool
     */
    protected function moveAutoloadClassmap()
    {
        return $this->moveFile('autoload_classmap.php', 'autoload_classmap_child.php');
    }

    /**
     * Rename "autoload_files.php" into "autoload_files_child.php"
     *
     * @return bool
     */
    protected function moveAutoloadFiles()
    {
        return $this->moveFile('autoload_files.php', 'autoload_files_child.php');
    }

    /**
     * Rename "autoload_namespaces.php" into "autoload_namespaces_child.php"
     *
     * @return bool
     */
    protected function moveAutoloadNamespaces()
    {
        return $this->moveFile('autoload_namespaces.php', 'autoload_namespaces_child.php');
    }

    /**
     * Rename "autoload_psr4.php" into "autoload_psr4_child.php"
     *
     * @return bool
     */
    protected function moveAutoloadPsr4()
    {
        return $this->moveFile('autoload_psr4.php', 'autoload_psr4_child.php');
    }
}
