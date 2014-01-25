<?php

namespace Melody\Validation\Constraints;

use Melody\Validation\Validator as v;
use DateTime;

class DateTest extends \PHPUnit_Framework_TestCase
{
    public function test_valid_date_without_format_should_work()
    {
        $this->assertTrue(v::date()->validate("today"));
    }

    public function test_valid_datetime_instance_without_format_should_work()
    {
        $date = new DateTime("today");
        $this->assertTrue(v::date()->validate($date));
    }

    /**
     * @dataProvider validDateFormatProvider
     */
    public function test_valid_date_with_custom_format_should_work($format, $date)
    {
        $this->assertTrue(v::date($format)->validate($date));
    }

    /**
     * @dataProvider invalidDateProvider
     */
    public function test_invalid_date_should_not_work($input)
    {
        $dateValidator = v::date();
        $this->assertFalse($dateValidator->validate($input));
        $this->assertEquals($dateValidator->getViolation('date'), "The input must be a valid date");
    }

    /**
     * @dataProvider invalidDateProvider
     */
    public function test_invalid_date_with_custom_violation_message_should_not_work($input)
    {
        $customMessage = "Custom date violation message";
        $dateValidator = v::date();
        $this->assertFalse($dateValidator->validate($input));
        $this->assertEquals($dateValidator->getViolation('date', $customMessage), $customMessage);
    }

    public function validDateFormatProvider()
    {
        return array(
            array(DateTime::ATOM, "2013-12-15T15:52:01+00:00"),
            array(DateTime::COOKIE, "Sunday, 15-Dec-13 15:52:01 UTC"),
            array(DateTime::ISO8601, "2013-12-15T15:52:01+0000"),
            array(DateTime::RFC822, "Sun, 15 Dec 13 15:52:01 +0000"),
            array(DateTime::RFC850, "Sunday, 15-Dec-13 15:52:01 UTC"),
            array(DateTime::RFC1036, "Sun, 15 Dec 13 15:52:01 +0000"),
            array(DateTime::RFC1123, "Sun, 15 Dec 2013 15:52:01 +0000"),
            array(DateTime::RFC2822, "Sun, 15 Dec 2013 15:52:01 +0000"),
            array(DateTime::RFC3339, "2013-12-15T15:52:01+00:00"),
            array(DateTime::RSS, "Sun, 15 Dec 2013 15:52:01 +0000"),
            array(DateTime::W3C, "2013-12-15T15:52:01+00:00"),
        );
    }

    public function invalidDateProvider()
    {
        return array(
            array(new \stdClass),
            array(1.2),
            array("@"),
            array(10 / 3)
        );
    }
}
