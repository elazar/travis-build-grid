<?php

namespace Elazar\TravisBuildGrid;

class GridRenderer
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var array
     */
    protected $grid;

    /**
     * Returns the Twig templating object in use.
     *
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        if (!$this->twig) {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../templates');
            $this->twig = new \Twig_Environment($loader, array('autoescape' => 'html'));
        }
        return $this->twig;
    }

    /**
     * Sets the Twig templating object to use.
     *
     * @param \Twig_Environment $twig
     */
    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Returns the grid data in use.
     *
     * @return array
     */
    public function getGridData()
    {
        return $this->grid;
    }

    /**
     * Sets the grid data to use.
     *
     * @param array $grid
     */
    public function setGridData(array $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Returns the rendered grid page.
     *
     * @return string
     */
    public function render()
    {
        $twig = $this->getTwig();
        $grid = $this->getGridData();

        $versions = array();
        foreach ($grid as $repo => $repoVersions) {
            foreach (array_keys($repoVersions) as $version) {
                $versions[$version] = true;
            }
        }
        $versions = array_keys($versions);

        return $twig->render('grid.html.twig', array(
            'grid' => $grid,
            'versions' => $versions,
        ));
    }
}
