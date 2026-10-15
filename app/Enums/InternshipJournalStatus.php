<?php

namespace App\Enums;

enum InternshipJournalStatus: string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case RevisionRequested = 'revision_requested';
    case Approved = 'approved';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draf',
            self::Submitted => 'Menunggu Review',
            self::RevisionRequested => 'Perlu Revisi',
            self::Approved => 'Disetujui',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'bg-slate-100 text-slate-800 border-slate-300',
            self::Submitted => 'bg-amber-50 text-amber-800 border-amber-300',
            self::RevisionRequested => 'bg-rose-50 text-rose-800 border-rose-300',
            self::Approved => 'bg-emerald-50 text-emerald-800 border-emerald-300',
        };
    }
}
