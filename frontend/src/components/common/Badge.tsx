import React from 'react';

interface BadgeProps {
  label: string;
  variant?: 'brand' | 'success' | 'warning' | 'danger' | 'info' | 'neutral';
  className?: string;
}

export const Badge: React.FC<BadgeProps> = ({
  label,
  variant = 'neutral',
  className = '',
}) => {
  const variantStyles = {
    brand: 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
    success: 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
    warning: 'bg-amber-50 text-amber-700 border-amber-200/60',
    danger: 'bg-rose-50 text-rose-700 border-rose-200/60',
    info: 'bg-sky-50 text-sky-700 border-sky-200/60',
    neutral: 'bg-slate-100 text-slate-700 border-slate-200/60',
  };

  return (
    <span
      className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border tracking-wide capitalize ${variantStyles[variant]} ${className}`}
    >
      {label}
    </span>
  );
};

/**
 * Helper otomatis memilih warna badge berdasarkan nama role
 */
export const RoleBadge: React.FC<{ role: string }> = ({ role }) => {
  const mapping: Record<string, { label: string; variant: BadgeProps['variant'] }> = {
    admin: { label: 'Administrator', variant: 'danger' },
    guru: { label: 'Guru Mata Pelajaran', variant: 'brand' },
    wali_kelas: { label: 'Wali Kelas', variant: 'success' },
    guru_pembimbing_pkl: { label: 'Pembimbing PKL', variant: 'info' },
    pembimbing_dudi: { label: 'Mentor Industri', variant: 'warning' },
    siswa: { label: 'Siswa', variant: 'neutral' },
  };

  const item = mapping[role] || { label: role, variant: 'neutral' };

  return <Badge label={item.label} variant={item.variant} />;
};
