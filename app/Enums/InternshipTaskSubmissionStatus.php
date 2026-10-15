<?php

namespace App\Enums;

enum InternshipTaskSubmissionStatus: string
{
    case Submitted = 'submitted';
    case Graded = 'graded';
    case Revision = 'revision';

    public function label(): string
    {
        return match ($this) {
            self::Submitted => 'Menunggu Penilaian',
            self::Graded => 'Dinilai',
            self::Revision => 'Minta Revisi',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Submitted => 'bg-amber-50 text-amber-800 border-amber-300',
            self::Graded => 'bg-emerald-50 text-emerald-800 border-emerald-300',
            self::Revision => 'bg-rose-50 text-rose-800 border-rose-300',
        };
    }
}
