<?php

namespace Elazar\TravisBuildGrid;

class Runner
{
    /**
     * @var \Elazar\TravisBuildGrid\GridBuilder
     */
    protected $gridBuilder;

    /**
     * @var \Elazar\TravisBuildGrid\GridRenderer
     */
    protected $gridRenderer;

    /**
     * Returns the grid builder.
     *
     * @return \Elazar\TravisBuildGrid\GridBuilder
     */
    public function getGridBuilder()
    {
        if (!$this->gridBuilder) {
            $this->gridBuilder = new GridBuilder;
        }
        return $this->gridBuilder;
    }

    /**
     * Sets the grid builder.
     *
     * @param \Elazar\TravisBuildGrid\GridBuilder $gridBuilder
     */
    public function setGridBuilder(GridBuilder $gridBuilder)
    {
        $this->gridBuilder = $gridBuilder;
    }

    /**
     * Returns the grid renderer.
     *
     * @return \Elazar\TravisBuildGrid\GridRenderer
     */
    public function getGridRenderer()
    {
        if (!$this->gridRenderer) {
            $this->gridRenderer = new GridRenderer;
        }
        return $this->gridRenderer;
    }

    /**
     * Sets the grid renderer.
     *
     * @param \Elazar\TravisBuildGrid\GridRenderer $gridRenderer
     */
    public function setGridRenderer(GridRender $gridRenderer)
    {
        $this->gridRenderer = $gridRenderer;
    }

    /**
     * Outputs the result of rendering the grid.
     */
    public function run()
    {
        $builder = $this->getGridBuilder();
        $renderer = $this->getGridRenderer();
        $grid = $builder->getGridData();
        $renderer->setGridData($grid);
        echo $renderer->render();
    }
}
