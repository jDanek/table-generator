<?php

declare(strict_types=1);

namespace Danek\TableGenerator\Element;

use Danek\TableGenerator\Table;

class Body extends AbstractSection
{
    /**
     * Body constructor.
     * @param Table $table
     * @param string $sectionName
     * @param string $cellTag
     */
    public function __construct(Table $table, string $sectionName = self::TBODY, string $cellTag = 'td')
    {
        parent::__construct($table, $sectionName, $cellTag);
    }
}