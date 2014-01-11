<?php
namespace Melody\Validation\Constraints;

class ContainsDigit extends Constraint
{
    protected $id = 'containsDigit';
    private $min;

    public function __construct($min)
    {
        if (!is_numeric($min)) {
            throw new \InvalidArgumentException("Min must be a number");
        }

        $this->min = $min;
    }

    public function validate($input)
    {
        if (!is_string($input)) {
            throw new \InvalidArgumentException("The input field must be a string");
        }

        return preg_match_all('/\d{1}/', $input, $matches) >= $this->min;
    }

    public function getErrorMessageTemplate()
    {
        return "The input '{{input}}' must contain at least {$this->min} digit(s)";
    }
}
