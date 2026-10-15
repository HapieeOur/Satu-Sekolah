<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('academic.manage') || $this->user()?->hasRole('admin');
    }

    public function rules(): array
    {
        $id = $this->route('teacher')?->id ?? $this->route('teacher');

        return [
            'nip' => ['nullable', 'string', 'max:30', Rule::unique('teachers', 'nip')->ignore($id)],
            'nuptk' => ['nullable', 'string', 'max:30', Rule::unique('teachers', 'nuptk')->ignore($id)],
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
            'nip.unique' => 'NIP sudah digunakan.',
            'nuptk.unique' => 'NUPTK sudah digunakan.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'subject_ids.*.exists' => 'Mata pelajaran yang dipilih tidak valid.',
        ];
    }
}
