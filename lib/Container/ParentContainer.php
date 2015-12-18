<?php

namespace Neirda24\Composer\ParentDependencyPlugin\Container;

/**
 * Class ParentContainer
 *
 * @author Adrien Schaegis <adrien@iron-mail.net>
 *
 * Contain informations about the parent <code>composer.json</code>
 */
class ParentContainer
{
    /**
     * Relative path to the parent vendor directory.
     *
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
