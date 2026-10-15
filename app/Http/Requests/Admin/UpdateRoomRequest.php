<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('academic.manage') || $this->user()?->hasRole('admin');
    }

    public function rules(): array
    {
        $id = $this->route('room')?->id ?? $this->route('room');

        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('rooms', 'code')->ignore($id)],
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:200'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode ruangan wajib diisi.',
            'code.unique' => 'Kode ruangan sudah digunakan.',
            'name.required' => 'Nama ruangan wajib diisi.',
            'capacity.required' => 'Kapasitas ruangan wajib diisi.',
            'capacity.min' => 'Kapasitas minimal 1 orang.',
        ];
    }
}
