<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValidYear implements DataAwareRule, ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $tahunAkhir;

    public function setData($data)
    {
        $this->tahunAkhir = $data['tahunAkhir'];
    }

    public function validate(string $attribute, mixed $tahunAwal, Closure $fail): void
    {
        if ((int) $tahunAwal + 1 !== (int)$this->tahunAkhir) {
            $fail('Invalid Tahun Ajaran');
        }
    }
}
