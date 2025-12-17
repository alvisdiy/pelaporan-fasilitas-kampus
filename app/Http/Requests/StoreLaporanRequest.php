<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreLaporanRequest extends FormRequest
{
    // 1. Izinkan akses
    public function authorize(): bool
    {
        return true; 
    }
    // 2. Aturan validasi
    public function rules(): array
    {
        return [
            'gedung'    => ['required', 'string', 'max:100'],
            'ruang'     => ['required', 'string', 'max:50'],
            'fasilitas' => ['required', 'string'],
            'kerusakan' => ['required', 'string', 'min:10'],
            'foto'      => ['nullable', 'image', 'max:2048'],
        ];
    }
    // 3. Pesan validasi kustom
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Ups, isian tidak valid',
            'errors' => $validator->errors()
        ], 422));
    }
}