<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan semua user (atau sesuaikan logic auth lu)
    }

    public function rules(): array
    {
        return [
            'kerusakan' => ['required', 'string', 'min:10', 'max:500'],
            'status'    => ['required', 'in:Diterima,Diproses,Selesai'],
        ];
    }
    
    // Tambahin ini kalau lu mau validasi ini juga support return JSON buat API
    protected function failedValidation(Validator $validator)
    {
        if ($this->wantsJson() || $this->is('api/*')) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => 'Ups, data update tidak valid',
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}