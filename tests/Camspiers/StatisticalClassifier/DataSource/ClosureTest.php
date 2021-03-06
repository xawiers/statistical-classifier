<?php

namespace Camspiers\StatisticalClassifier\DataSource;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-04-13 at 11:25:33.
 */
class ClosureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Closure
     */
    protected $object;
    /**
     * @var
     */
    protected $data;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = array(
            'category' => array(
                'This is a test document'
            )
        );
        $this->object = new Closure(
            function () {
                return array(
                    array(
                        'document' => 'This is a test document',
                        'category' => 'category'
                    )
                );
            }
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->data = null;
        $this->object = null;
    }

    public function testRead()
    {
        $this->assertEquals(
            $this->data,
            $this->object->getData()
        );
    }
}
