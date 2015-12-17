<?php

namespace Neirda24\Composer\ParentDependencyPlugin\Container;

use Neirda24\Bundle\ToolsBundle\Utils\StringUtils;

class ParentContainer
{
    /**
     * @var string
     */
    protected $pathToParentVendor;

    /**
     * ParentContainer constructor.
     *
     * @param string $pathToParentVendor
     */
    public function __construct($pathToParentVendor)
    {
        $this->pathToParentVendor = $pathToParentVendor;
    }

    /**
     * Get PathToParentVendor
     *
     * @return string
     */
    public function getPathToParentVendor()
    {
        return $this->pathToParentVendor;
    }
}
