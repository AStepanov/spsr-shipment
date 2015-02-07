<?php

namespace stp\spsr\tests;

use Codeception\Util\Stub;
use Codeception\Specify;
use stp\spsr\BaseType;

class BaseTypeTest extends \Codeception\TestCase\Test
{
    use Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetterSetters()
    {
        $this->specify("can get and set value", function() {
            $type = Stub::make('stp\spsr\BaseType');
            $type->var = 'test';
            verify($type->var)->equals('test');
        });

        $this->specify("can pass array to constructor", function() {
            $type = Stub::make('stp\spsr\BaseType', ['var1' => 'some', 'var2' => 'some2']);
            verify($type->var1)->equals('some');
            verify($type->var2)->equals('some2');
        });


    }

}