<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('news.manage');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:berita,pengumuman,acara'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'event_date' => ['nullable', 'required_if:category,acara', 'date'],
            'event_time' => ['nullable', 'date_format:H:i'],
            'event_location' => ['nullable', 'required_if:category,acara', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'featured_image' => ['nullable', 'string', 'max:255'],
        ];
    }
}
