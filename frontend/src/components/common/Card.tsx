import React from 'react';

interface CardProps {
  title?: string;
  subtitle?: string;
  icon?: React.ReactNode;
  headerAction?: React.ReactNode;
  children: React.ReactNode;
  className?: string;
}

export const Card: React.FC<CardProps> = ({
  title,
  subtitle,
  icon,
  headerAction,
  children,
  className = '',
}) => {
  return (
    <div className={`bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden ${className}`}>
      {(title || headerAction) && (
        <div className="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
          <div className="flex items-center space-x-3">
            {icon && (
              <div className="w-9 h-9 rounded-xl bg-brand-50 border border-brand-100 flex items-center justify-center text-brand-600">
                {icon}
              </div>
            )}
            <div>
              {title && <h3 className="text-sm font-bold text-slate-800">{title}</h3>}
              {subtitle && <p className="text-xs text-slate-500 mt-0.5">{subtitle}</p>}
            </div>
          </div>
          {headerAction && <div>{headerAction}</div>}
        </div>
      )}
      <div className="p-6">{children}</div>
    </div>
  );
};
