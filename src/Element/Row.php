<?php

declare(strict_types=1);

namespace Danek\TableGenerator\Element;

class Row implements \Countable
{
    /** @var string */
    protected $cellTag = 'td';

    /** @var array */
    protected $cells;

    /** @var array */
    protected $cssClasses = [];

    /**
     * @param string $cellTag
     * @param array $cells
     * @param array $cssClasses
     */
    public function __construct(string $cellTag, array $cells, array $cssClasses = [])
    {
        $this->cellTag = $cellTag;
        $this->cells = $cells;
        $this->cssClasses = $cssClasses;
    }

    /**
     * Implementation \Countable interface
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->cells);
    }

    /**
     * @return string
     */
    public function renderCells(): string
    {
        $output = "";

        $tag = $this->cellTag;
        $css = $this->getCssClasses();
        
        foreach ($this->cells as $data) {
            $output .= "\t\t\t<" . $tag . $css . ">" . $data . "</" . $tag . ">\n";
        }

        return $output;
    }

    /**
     * Return the custom classes as html attribute
     * @return string
     */
    protected function getCssClasses(): string
    {
        if (!empty($this->cssClasses)) {
            return ' class="' . implode(' ', $this->cssClasses) . '"';
        }
        return '';
    }
}