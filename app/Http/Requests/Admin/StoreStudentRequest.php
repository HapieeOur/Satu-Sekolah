<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('academic.manage') || $this->user()?->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'nis' => ['required', 'string', 'max:30', 'unique:students,nis'],
            'nisn' => ['nullable', 'string', 'max:30', 'unique:students,nisn'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'classroom_id' => ['nullable', 'exists:classrooms,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,alumni,pindah,keluar'],
        ];
    }

    public function messages(): array
    {
        return [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan oleh siswa lain.',
            'nisn.unique' => 'NISN sudah digunakan oleh siswa lain.',
            'name.required' => 'Nama siswa wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus L atau P.',
            'status.required' => 'Status siswa wajib dipilih.',
            'classroom_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
        ];
    }
}
