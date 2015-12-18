<?php

namespace Neirda24\Composer\ParentDependencyPlugin\Dumper;

use Neirda24\Bundle\ToolsBundle\Utils\StringUtils;
use Neirda24\Composer\ParentDependencyPlugin\Container\ParentContainer;

/**
 * Class AutoloadDumper
 *
 * @author Adrien Schaegis <adrien@iron-mail.net>
 *
 * Dump the autoload files.
 */
class AutoloadDumper
{
    /**
     * @var ParentContainer
     */
    protected $parentContainer;

    /**
     * Relative path to the vendor directory of the current project.
     *
     * @var string
     */
    protected $vendorDir;

    /**
     * AutoloadDumper constructor.
     *
     * @param ParentContainer $parentContainer
     * @param string          $vendorDir
     */
    public function __construct(ParentContainer $parentContainer, $vendorDir)
    {
        $this->parentContainer = $parentContainer;
        $this->vendorDir       = $vendorDir;
    }

    /**
     * Dump all files.
     *
     * @return void
     */
    public function run()
    {
        $this->dumpAutoloadClassmap();
        $this->dumpAutoloadFiles();
        $this->dumpAutoloadNamespaces();
        $this->dumpAutoloadPsr4();
    }

    /**
     * @return string
     */
    protected function getParentVendorDir()
    {
        $parentVendorDir = '../../' . rtrim($this->parentContainer->getPathToParentVendor(), '/');
        if (!StringUtils::endsWith($parentVendorDir, '/vendor')) {
            $parentVendorDir .= '/vendor';
        }

        return $parentVendorDir;
    }

    /**
     * Dump the file "autoload_classmap.php".
     *
     * @return void
     */
    protected function dumpAutoloadClassmap()
    {
        $parentVendorDir      = $this->getParentVendorDir();
        $autoloadClassmapFile = <<<EOF
<?php

\$composer = require_once __DIR__  . '/autoload_classmap_child.php';

\$parent = require __DIR__ . '/$parentVendorDir/composer/autoload_classmap.php';

\$diff = array_diff_key(\$composer, \$parent);

return \$diff;

EOF;
        file_put_contents($this->vendorDir . '/composer/autoload_classmap.php', $autoloadClassmapFile);
    }

    /**
     * Dump the file "autoload_files.php".
     *
     * @return void
     */
    protected function dumpAutoloadFiles()
    {
        $parentVendorDir   = $this->getParentVendorDir();
        $autoloadFilesFile = <<<EOF
<?php

\$composer = require_once __DIR__  . '/autoload_files_child.php';

\$parent = require __DIR__ . '/$parentVendorDir/composer/autoload_files.php';

\$diff = array_diff_key(\$composer, \$parent);

return \$diff;

EOF;
        file_put_contents($this->vendorDir . '/composer/autoload_files.php', $autoloadFilesFile);
    }

    /**
     * Dump the file "autoload_psr4.php".
     *
     * @return void
     */
    protected function dumpAutoloadPsr4()
    {
        $parentVendorDir  = $this->getParentVendorDir();
        $autoloadPsr4File = <<<EOF
<?php

\$composer = require_once __DIR__  . '/autoload_psr4_child.php';

\$parentPsr4       = require __DIR__ . '/$parentVendorDir/composer/autoload_psr4.php';
\$parentNamespaces = require __DIR__ . '/$parentVendorDir/composer/autoload_namespaces.php';
\$parent           = array_merge(\$parentPsr4, \$parentNamespaces);

\$declaredClasses = get_declared_classes();
\$namespaces      = array();
array_walk(\$declaredClasses, function (\$class) use (&\$namespaces) {
    \$namespace = preg_replace('/(.*)\\\\.*/', '$1', \$class);
    if (!array_key_exists(\$namespace, \$namespaces)) {
        \$namespaces[\$namespace] = \$namespace;
    }
});

\$diff = array_diff_key(\$composer, \$parent);
\$diff = array_filter(\$diff, function (\$path, \$namespace) use (\$namespaces) {
    return (!array_key_exists(\$namespace, \$namespaces));
}, ARRAY_FILTER_USE_BOTH);


return \$diff;

EOF;
        file_put_contents($this->vendorDir . '/composer/autoload_psr4.php', $autoloadPsr4File);
    }

    /**
     * Dump the file "autoload_namespaces.php".
     *
     * @return void
     */
    protected function dumpAutoloadNamespaces()
    {
        $parentVendorDir        = $this->getParentVendorDir();
        $autoloadNamespacesFile = <<<EOF
<?php

\$composer = require_once __DIR__  . '/autoload_namespaces_child.php';

\$parentPsr4 = require __DIR__ . '/$parentVendorDir/composer/autoload_psr4.php';
\$parentNamespaces = require __DIR__ . '/$parentVendorDir/composer/autoload_namespaces.php';
\$parent = array_merge(\$parentPsr4, \$parentNamespaces);

\$declaredClasses = get_declared_classes();
\$namespaces = array();
array_walk(\$declaredClasses, function (\$class) use (&\$namespaces) {
    \$namespace = preg_replace('/(.*)\\\\.*/', '$1', \$class);
    if (!array_key_exists(\$namespace, \$namespaces)) {
        \$namespaces[\$namespace] = \$namespace;
    }
});

\$diff = array_diff_key(\$composer, \$parent);
\$diff = array_filter(\$diff, function (\$path, \$namespace) use (\$namespaces) {
    return (!array_key_exists(\$namespace, \$namespaces));
}, ARRAY_FILTER_USE_BOTH);


return \$diff;

EOF;
        file_put_contents($this->vendorDir . '/composer/autoload_namespaces.php', $autoloadNamespacesFile);
    }
}
