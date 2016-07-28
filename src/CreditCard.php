<?php
namespace Mystique;

/*
PHP credit card number generator
Copyright (C) 2006 Graham King graham@darkcoding.net
Copyright (C) 2013 Alex Goretoy alex@goretoy.com
Copyright (C) 2016 Rubens Silva rubens21@gmail.com

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class CreditCard
{
    private $flag;
    private $number;
    private $cvc;
    private $validMonth;
    private $validYear;

    const FLAG_VISA = 'visa';
    const FLAG_MASTER = 'master';
    const FLAG_AMEX = 'amex';

    protected static $visaPrefixList = array("4539", "4556", "4916", "4532", "4929", "40240071", "4485", "4716", "4");
    protected static $mastercardPrefixList = array("51", "52", "53", "54", "55");
    protected static $amexPrefixList = array("34", "37");
    protected static $discoverPrefixList = array("6011");
    protected static $dinersPrefixList = array("300", "301", "302", "303", "36", "38");
    protected static $enRoutePrefixList = array("2014", "2149");
    protected static $jcbPrefixList = array("35");
    protected static $voyagerPrefixList = array("8699");

    public function __construct()
    {
        $this->flag = [self::FLAG_AMEX, self::FLAG_VISA, self::FLAG_MASTER][rand(0, 2)];
        switch ($this->flag) {
            case self::FLAG_MASTER:
                $this->number = self::genMastercardNumber();
                break;
            case self::FLAG_VISA:
                $this->number = rand(0,1)? self::genVisa16Number() : self::genVisa13Number();
                break;
            case self::FLAG_AMEX:
                $this->number = self::genAmexNumber();
                break;
        }
        $this->cvc = rand(100, 999);
        $time = strtotime("+" . rand(2, 12 * 5) . ' MONTH');
        $this->validMonth = date("m", $time);
        $this->validYear = date("Y", $time);
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @return bool|string
     */
    public function getValidMonth()
    {
        return $this->validMonth;
    }

    /**
     * @return bool|string
     */
    public function getValidYear()
    {
        return $this->validYear;
    }

    /**
     * @param array $prefixList List of initial numbers of the credit card number. It defines the brand
     * @param int $length Length of the credit card number
     * @return string A credit card number
     */
    private static function creditCardNumber($prefixList, $length)
    {
        $ccnumber = $prefixList[array_rand($prefixList)];
        # generate digits
        while (strlen($ccnumber) < ($length - 1)) {
            $ccnumber .= rand(0, 9);
        }
        # Calculate sum
        $sum = 0;
        $pos = 0;
        $reversedCCnumber = strrev($ccnumber);
        while ($pos < $length - 1) {
            $odd = $reversedCCnumber[$pos] * 2;
            if ($odd > 9) {
                $odd -= 9;
            }
            $sum += $odd;
            if ($pos != ($length - 2)) {
                $sum += $reversedCCnumber[$pos + 1];
            }
            $pos += 2;
        }
        # Calculate check digit
        $checkdigit = ((floor($sum / 10) + 1) * 10 - $sum) % 10;
        $ccnumber .= $checkdigit;
        return $ccnumber;
    }

    /**
     * @return string Generates a creditcard number of a brand
     */
    public static function genMastercardNumber()
    {
        return self::creditCardNumber(self::$mastercardPrefixList, 16);
    }

    /**
     * @return string Generates a creditcard number of a brand
     */
    public static function genVisa16Number()
    {
        return self::creditCardNumber(self::$visaPrefixList, 16);
    }

    /**
     * @return string Generates a creditcard number of a brand
     */
    public static function genVisa13Number()
    {
        return self::creditCardNumber(self::$visaPrefixList, 13);
    }

    /**
     * @return string Generates a creditcard number of a brand
     */
    public static function genAmexNumber()
    {
        return self::creditCardNumber(self::$amexPrefixList, 15);
    }
}
