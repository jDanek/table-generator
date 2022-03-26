TableGenerator
##############

PHP library for generating simple HTML tables

.. contents::

Requirements
************

- PHP 7.1+

Usage example
*************

.. code:: php

   <?php

   use Danek\TableGenerator\Table;

   $gen = new Table('my-table', ['striped', 'hover', 'bordered', 'small']);
   $gen->setHeaderColumns(['#', 'Name', 'Category', 'Autor']);
   $gen->setBodyRows([
       [1, 'Lorem ipsum', 'Foo', 'John Doe'],
       [2, 'Sed ut perspiciatis', 'Bar', 'Jane Down'],
   ]);

   echo $gen->render();