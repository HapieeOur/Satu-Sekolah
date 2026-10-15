<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternshipCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('internships.manage') || $this->user()?->can('academic.manage') || $this->user()?->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'radius_meters' => ['nullable', 'integer', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama mitra/perusahaan PKL wajib diisi.',
            'address.required' => 'Alamat mitra/perusahaan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'latitude.between' => 'Latitude harus berada dalam rentang -90 hingga 90.',
            'longitude.between' => 'Longitude harus berada dalam rentang -180 hingga 180.',
            'radius_meters.min' => 'Radius presensi minimal 10 meter.',
            'radius_meters.max' => 'Radius presensi maksimal 5000 meter.',
        ];
    }
}
