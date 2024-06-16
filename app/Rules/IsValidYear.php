<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValidYear implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $tahunAkhir;

    public function __construct($tahunAkhir)
    {
        $this->tahunAkhir = $tahunAkhir;
    }

    public function validate(string $attribute, mixed $tahunAwal, Closure $fail): void
    {
        if ((int) $tahunAwal + 1 !== (int)$this->tahunAkhir) {
            $fail('Invalid Tahun Ajaran');
        }
    }
}
