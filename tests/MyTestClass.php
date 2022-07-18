<?php
/**
 * Class SampleTest
 *
 * @package Unit_Test_Plugin
 */
/**
 * Sample test case.
 */
class MyTestClass extends \WP_Mock\Tools\TestCase {
    public function setUp() : void  {
        \WP_Mock::setUp();
    }
    public function tearDown() : void  {
        \WP_Mock::tearDown();
    }
    /**
     * A single example test.
     */
    public function test_sample() {
        // Replace this with some actual testing code.
        $this->assertTrue( true );
    }
}