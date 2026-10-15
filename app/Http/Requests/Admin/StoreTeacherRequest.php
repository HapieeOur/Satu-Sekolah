<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('academic.manage') || $this->user()?->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id', 'unique:teachers,user_id'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:teachers,nip'],
            'nuptk' => ['nullable', 'string', 'max:30', 'unique:teachers,nuptk'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'subject_ids' => ['nullable', 'array'],
            'subject_ids.*' => ['exists:subjects,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Akun pengguna untuk guru wajib dipilih.',
            'user_id.unique' => 'Akun pengguna ini sudah terdaftar sebagai guru.',
            'nip.unique' => 'NIP sudah digunakan.',
            'nuptk.unique' => 'NUPTK sudah digunakan.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'subject_ids.*.exists' => 'Mata pelajaran yang dipilih tidak valid.',
        ];
    }
}
