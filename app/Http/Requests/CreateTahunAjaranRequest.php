<?php

namespace App\Http\Requests;

use App\Rules\IsValidYear;
use Illuminate\Foundation\Http\FormRequest;

class CreateTahunAjaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public $tahunAwal;
    public $tahunAkhir;
    public $semester;
    public $semesterAktif;

    // public function rules(): array
    // {
    //     return [
    //         'tahunAwal' => ['required', 'min:4', new IsValidYear($this->tahunAkhir)],
    //         'tahunAkhir' => 'required|min:4',
    //         'semester' => 'required',
    //         'semester' => 'required',
    //     ];
    // }
}
