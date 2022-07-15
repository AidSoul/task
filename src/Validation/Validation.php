<?php

namespace Task\Validation;

/**
 * Data validation class
 */
class Validation
{
    /**
     * Check and error output function
     *
     * @param string $pattern
     * @param string|integer $str
     * @param string $errorName
     * 
     * @return void
     */
    private function checkPattern(string $pattern, string|int $str, string $errorName = ''): void
    {
        if (preg_match($pattern, str_replace(' ', '', $str))) {
            throw new \Exception("Doesn't fit the {$errorName} pattern", 0);
        }
    }

    /**
     * Additional template validation
     *
     * @param string $pattern
     * @param string|integer $str
     * @param string $errorMessage
     * 
     * @return void
     */
    private function additionalVerificationPattern(string $pattern, string|int $str, string $errorMessage = ''): void
    {
        if (!preg_match($pattern, $str)) {
            die($errorMessage);
        }
    }

    /**
     * Cyrillic Matching Function
     * 
     * @param string $str
     * 
     * @return void
     */
    public function сyrillic(string $str): void
    {
        $this->checkPattern('/[^А-Яа-я]{1,30}/u', $str, 'сyrillic');
        $this->additionalVerificationPattern('/[А-Я]{1}[а-я]{1,30}/u', $str, 'Must begin with a capital letter');
    }

    /**
     * Function for checking the date against the template
     *
     * @param string $str
     * @return void
     */
    public function date(string $str): void
    {
        $this->checkPattern('/[^0-9-]+/', $str, 'date');
        $this->additionalVerificationPattern(
            '/(17|19|20)\d\d-((0[1-9]|1[012])-(0[1-9]|[12]\d)|(0[13-9]|1[012])-30|(0[13578]|1[02])-31)/',
            $str,
            "Does not match the date pattern: YYYY-MM-DD"
        );
    }

    /**
     * Check against a binary number
     *
     * @param integer $str
     * @return void
     */
    public function binary(int $str): void
    {
        $pattern = '/[^0-1]+/';
        $this->checkPattern($pattern, $str, 'gender');
    }
}
