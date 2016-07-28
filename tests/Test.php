<?php

/**
 * Created by IntelliJ IDEA.
 * User: rubens
 * Date: 28/07/16
 * Time: 15:43
 */
class Test extends PHPUnit_Framework_TestCase
{

    public function testCcdGenerated()
    {
        $ccd = new \Mystique\CreditCard();
        $this->assertRegExp('/\d+/', $ccd->getNumber());
        $this->assertLessThan(13, $ccd->getValidMonth());
        $this->assertGreaterThan(0, $ccd->getValidMonth());
        $this->assertGreaterThanOrEqual(date('Y'), $ccd->getValidYear());
    }
}
