<?php

declare(strict_types=1);

namespace Danek\TableGenerator\Element;

use Danek\TableGenerator\Table;

class Header extends AbstractSection
{
    /**
     * Header constructor.
     * @param Table $table
     * @param string $sectionName
     * @param string $cellTag
     */
    public function __construct(Table $table, string $sectionName = self::THEAD, string $cellTag = 'th')
    {
        parent::__construct($table, $sectionName, $cellTag);
    }
}