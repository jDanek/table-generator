<?php

declare(strict_types=1);

namespace Danek\TableGenerator\Element;

use Danek\TableGenerator\Table;

abstract class AbstractSection implements \Countable
{
    public const THEAD = 'thead';
    public const TBODY = 'tbody';
    public const TFOOT = 'tfoot';

    /** @var Table */
    protected $table;

    /** @var string */
    protected $sectionName;

    /** @var string */
    protected $cellTag;

    /** @var Row[] */
    protected $rows = [];

    /**
     * AbstractSection constructor.
     * @param string $sectionName thead/tbody/tfooter
     * @param Table $table
     * @param string $cellTag th/td
     */
    public function __construct(Table $table, string $sectionName, string $cellTag)
    {
        $this->table = $table;
        $this->sectionName = $sectionName;
        $this->cellTag = $cellTag;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $output = "\t<" . $this->sectionName . ">\n";

        foreach ($this->rows as $row) {
            $output .= "\t\t<tr>\n";
            $output .= $row->renderCells();
            $output .= $this->fillWithEmptyCells($row);
            $output .= "\t\t</tr>\n";
        }

        $output .= "\t</" . $this->sectionName . ">\n";

        return $output;
    }

    /**
     * Fill the rest of the row with empty cells
     *
     * @param Row $row
     * @return string
     */
    protected function fillWithEmptyCells(Row $row): string
    {
        $diff = $this->table->getMaxRowCells() - count($row);
        return str_repeat("\t\t\t<" . $this->cellTag . "></" . $this->cellTag . ">\n", $diff);
    }

    /**
     * @param array $rows [[col1, col2, ...], [col21, col22, ...]]
     * @param array $cssClasses
     * @return $this
     */
    public function addRows(array $rows, array $cssClasses = []): self
    {
        if (count($rows) > 0) {
            // multidimensional
            if (is_array($rows[0])) {
                foreach ($rows as $row) {
                    $this->rows[] = $this->addRow($row, $cssClasses);
                }
            } else {
                $this->rows[] = $this->addRow($rows, $cssClasses);
            }
        }
        return $this;
    }

    /**
     * @param array $cells [col1, col2, ...]
     * @param array $cssClasses
     * @return Row
     */
    public function addRow(array $cells, array $cssClasses = []): Row
    {
        $row = new Row($this->cellTag, $cells, $cssClasses);
        $this->table->updateMaxCells(count($row));
        return $row;
    }

    /**
     * Implementation \Countable interface
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->rows);
    }
}