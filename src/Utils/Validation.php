<?php

namespace App\Utils;

class Validation
{
    public function required(string $name, string $value): string
    {
        if (empty($value)) {
            $error = 'Le champ ' . $name . ' est obligatoire';
        }

        return $error ?? '';
    }

    public function maxLength(string $name, string $value, int $length): string
    {
        if (strlen($value) > $length) {
            $error = 'Le champ ' . $name . ' doit faire moins de ' . $length . ' caractères';
        }

        return $error ?? '';
    }

    public function moreThan(string $name, string $value, int $min): string
    {
        if ($value < $min) {
            $error = 'Le champ ' . $name . ' doit faire plus de ' . $min . ' caractères';
        }

        return $error ?? '';
    }

    public function lessThan(string $name, string $value, int $max): string
    {
        if ($value > $max) {
            $error = 'Le champ ' . $name . ' doit faire moins de ' . $max . ' caractères';
        }

        return $error ?? '';
    }
}
