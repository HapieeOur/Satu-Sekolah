<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('academic.manage') || $this->user()?->hasRole('admin');
    }

    public function rules(): array
    {
        $id = $this->route('subject')?->id ?? $this->route('subject');

        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('subjects', 'code')->ignore($id)],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:teachers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode mata pelajaran wajib diisi.',
            'code.unique' => 'Kode mata pelajaran sudah digunakan.',
            'name.required' => 'Nama mata pelajaran wajib diisi.',
            'teacher_ids.*.exists' => 'Guru pengampu tidak valid.',
        ];
    }
}
