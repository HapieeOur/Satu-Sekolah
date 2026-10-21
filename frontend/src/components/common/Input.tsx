import React from 'react';

interface InputProps extends React.InputHTMLAttributes<HTMLInputElement> {
  label?: string;
  error?: string;
  helperText?: string;
  icon?: React.ReactNode;
}

export const Input: React.FC<InputProps> = ({
  label,
  error,
  helperText,
  icon,
  className = '',
  id,
  ...props
}) => {
  const inputId = id || props.name;

  return (
    <div className="w-full">
      {label && (
        <label htmlFor={inputId} className="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
          {label}
        </label>
      )}
      <div className="relative rounded-xl shadow-sm">
        {icon && (
          <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            {icon}
          </div>
        )}
        <input
          id={inputId}
          className={`block w-full rounded-xl text-sm transition duration-150 border bg-white ${
            icon ? 'pl-10' : 'pl-3.5'
          } pr-3.5 py-2.5 ${
            error
              ? 'border-rose-300 text-rose-900 placeholder-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500'
              : 'border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 hover:border-slate-300'
          } ${className}`}
          {...props}
        />
      </div>
      {error && <p className="mt-1.5 text-xs text-rose-600 font-medium">{error}</p>}
      {!error && helperText && <p className="mt-1.5 text-xs text-slate-500">{helperText}</p>}
    </div>
  );
};
