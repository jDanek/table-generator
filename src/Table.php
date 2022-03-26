<?php

declare(strict_types=1);

namespace Danek\TableGenerator;

use Danek\TableGenerator\Element\Body;
use Danek\TableGenerator\Element\Footer;
use Danek\TableGenerator\Element\Header;

class Table
{
    /** @var string|null */
    public $id = null;

    /** @var Header */
    protected $header;

    /** @var Body */
    protected $body;

    /** @var Footer */
    protected $footer;

    /**
     * max lenght of rows insert
     */
    /** @var int */
    protected $maxRowCells = 0;

    /** @var array custom classes for the table */
    protected $tableClasses = [];

    /**
     * Table constructor.
     * @param string|null $id
     * @param array $tableClasses
     */
    public function __construct(string $id = null, array $tableClasses = [])
    {
        $this->id = $id;
        $this->addTableClasses($tableClasses);
    }

    /**
     * Create new instance
     *
     * @param string|null $id
     * @param array $tableClasses
     * @return self
     */
    public static function create(string $id = null, array $tableClasses = []): self
    {
        return new self($id, $tableClasses);
    }

    /**
     * Add extra classes to the table
     *
     * @param array $classes
     */
    public function addTableClasses(array $classes)
    {
        $this->tableClasses = array_merge($this->tableClasses, $classes);
    }

    /**
     * @param array $columns columns of the header
     * @return $this
     */
    public function setHeaderColumns(array $columns): self
    {
        $this->header = $this->header()->addRows($columns);
        return $this;
    }

    /**
     * @param array $rows [[col,col,col], [col,col,col], ...]
     * @return $this
     */
    public function setBodyRows(array $rows): self
    {
        $this->body = $this->body()->addRows($rows);
        return $this;
    }

    /**
     * @param array $rows [[col,col,col], [col,col,col], ...]
     * @return $this
     */
    public function setFooterRows(array $rows): self
    {
        $this->footer = $this->footer()->addRows($rows);
        return $this;
    }

    /**
     * @return Header
     */
    public function header(): Header
    {
        return $this->header ?? new Header($this);
    }

    /**
     * @return Body
     */
    public function body(): Body
    {
        return $this->body ?? new Body($this);
    }

    /**
     * @return Footer
     */
    public function footer(): Footer
    {
        return $this->footer ?? new Footer($this);
    }

    /**
     * Return the table as Html
     *
     * @return string $html
     */
    public function render(): string
    {
        $output = "<table " . $this->getTagId() . " class='table " . $this->composeTableClasses() . "'>\n";

        // table header
        if (isset($this->header)) {
            $output .= $this->header->render();
        }

        // table body
        if (isset($this->body)) {
            $output .= $this->body->render();
        }

        // table footer
        if (isset($this->footer)) {
            $output .= $this->footer->render();
        }

        $output .= "</table>\n";

        return $output;
    }

    /**
     * @return string
     */
    protected function getTagId(): string
    {
        return $this->id === null ? '' : 'id="' . $this->id . '"';
    }

    /**
     * Get the classes in string format
     * separated by a space
     *
     * @return string $classes
     */
    protected function composeTableClasses(): string
    {
        return empty($this->tableClasses) ? '' : implode(' ', $this->tableClasses);
    }

    /**
     * Update the max lenght of rows in the table
     *
     * @param int $count
     * @return int
     */
    public function updateMaxCells(int $count): int
    {
        if ($count > $this->maxRowCells) {
            $this->maxRowCells = $count;
        }
        return $this->maxRowCells;
    }

    /**
     * @return int
     */
    public function getMaxRowCells(): int
    {
        return $this->maxRowCells;
    }
}
