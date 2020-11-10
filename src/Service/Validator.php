<?php

namespace App\Service;

class Validator
{
    private string $name;

    private $input;

    private array $errors = [];

    public function __construct(string $name, $input)
    {
        $this->name = $name;
        $this->input = $input;
    }

    public function required()
    {
        if (empty($this->getInput())) {
            $this->errors[] = 'Le champ ' . $this->getName() . ' est obligatoire';
        }
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param mixed $input
     * @return Validator
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Validator
     */
    public function setName(string $name): Validator
    {
        $this->name = $name;

        return $this;
    }

    public function shorterThan(int $length)
    {
        if (strlen($this->getInput()) > $length) {
            $this->errors[] = 'Le champ ' . $this->getName() . ' doit faire moins de ' . $length . ' caractères';
        }
    }

    public function moreThan(float $min)
    {
        if ($this->input <= $min) {
            $this->errors[] = 'Le champ ' . $this->getName() . ' doit être supérieur à  ' . $min;
        }
    }

    public function moreOrEqualThan(float $min)
    {
        if ($this->input < $min) {
            $this->errors[] = 'Le champ ' . $this->getName() . ' doit être supérieur ou égal à  ' . $min;
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return Validator
     */
    public function setErrors(array $errors): Validator
    {
        $this->errors = $errors;

        return $this;
    }
}
