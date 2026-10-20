<?php

namespace App\Http\Requests\Admin;

use App\Enums\InternshipPlacementStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInternshipPlacementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('internships.manage');
    }

    protected function prepareForValidation(): void
    {
        if (empty($this->teacher_id) && ! empty($this->internship_company_id)) {
            $company = \App\Models\InternshipCompany::find($this->internship_company_id);
            if ($company?->teacher_id) {
                $this->merge(['teacher_id' => $company->teacher_id]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('internship_placements')->where(function ($query) {
                    return $query->where('academic_year_id', $this->academic_year_id);
                }),
            ],
            'internship_company_id' => ['required', 'exists:internship_companies,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'department' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::enum(InternshipPlacementStatus::class)],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.unique' => 'Siswa ini sudah memiliki penempatan PKL pada tahun ajaran yang dipilih.',
            'end_date.after_or_equal' => 'Tanggal berakhir PKL harus sama atau setelah tanggal mulai.',
        ];
    }
}
