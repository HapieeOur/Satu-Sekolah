<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('academic.manage') || $this->user()?->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'grade_level' => ['required', 'integer', 'min:10', 'max:12'],
            'major' => ['required', 'string', 'max:50'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama rombel/kelas wajib diisi.',
            'grade_level.required' => 'Tingkat kelas wajib diisi (10, 11, atau 12).',
            'major.required' => 'Jurusan/kompetensi keahlian wajib diisi.',
            'academic_year_id.required' => 'Tahun ajaran wajib dipilih.',
            'academic_year_id.exists' => 'Tahun ajaran tidak valid.',
            'teacher_id.exists' => 'Wali kelas tidak valid.',
        ];
    }
}
