<?php

namespace App\Http\Requests\Admin;

use App\Enums\InternshipAttendanceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CorrectInternshipAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('attendance.correct');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(InternshipAttendanceStatus::class)],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
            'correction_reason' => ['required', 'string', 'min:5', 'max:500'],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'correction_reason.required' => 'Alasan koreksi manual wajib diisi untuk keperluan jejak audit sistem.',
            'correction_reason.min' => 'Alasan koreksi harus jelas dan terperinci minimal 5 karakter.',
        ];
    }
}
