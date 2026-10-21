import React, { useState } from 'react';
import { useNavigate, useLocation, Link } from 'react-router-dom';
import { GraduationCap, Lock, Mail, ArrowRight, AlertCircle, Info } from 'lucide-react';
import { useAuth } from '../context/AuthContext';
import { Input } from '../components/common/Input';
import { Button } from '../components/common/Button';

export const LoginPage: React.FC = () => {
  const [loginInput, setLoginInput] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);

  const { login } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();

  // Redirect destination after successful login
  const from = (location.state as { from?: { pathname: string } })?.from?.pathname || '/dashboard';

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);

    if (!loginInput.trim() || !password) {
      setError('Harap isi akun login dan kata sandi.');
      return;
    }

    setIsSubmitting(true);
    try {
      await login(loginInput.trim(), password);
      navigate(from, { replace: true });
    } catch (err: any) {
      const message =
        err.response?.data?.message ||
        'Gagal masuk. Periksa kembali email/NIS/NIP dan kata sandi Anda.';
      setError(message);
    } finally {
      setIsSubmitting(false);
    }
  };

  const setSampleAccount = (user: string, pass: string) => {
    setLoginInput(user);
    setPassword(pass);
    setError(null);
  };

  return (
    <div className="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-md w-full space-y-8">
        {/* Header */}
        <div className="text-center">
          <Link to="/" className="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-brand-600 text-white shadow-lg shadow-brand-500/20 mb-4 hover:scale-105 transition">
            <GraduationCap className="w-7 h-7" />
          </Link>
          <h1 className="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk ke Portal Satu Sekolah</h1>
          <p className="text-xs text-slate-500 mt-1">
            Gunakan Email, NIS (Siswa), NIP (Guru), atau Nomor HP yang terdaftar
          </p>
        </div>

        {/* Card Form */}
        <div className="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40 p-7 sm:p-8">
          {error && (
            <div className="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 flex items-start space-x-3 text-rose-800">
              <AlertCircle className="w-5 h-5 text-rose-600 shrink-0 mt-0.5" />
              <p className="text-xs font-medium leading-relaxed">{error}</p>
            </div>
          )}

          <form onSubmit={handleSubmit} className="space-y-4">
            <Input
              label="Identitas Akun"
              placeholder="Email / NIP / NIS / No. HP"
              value={loginInput}
              onChange={(e) => setLoginInput(e.target.value)}
              icon={<Mail className="w-4 h-4" />}
              autoComplete="username"
              required
            />

            <Input
              label="Kata Sandi"
              type="password"
              placeholder="••••••••"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              icon={<Lock className="w-4 h-4" />}
              autoComplete="current-password"
              required
            />

            <div className="pt-2">
              <Button type="submit" size="lg" isLoading={isSubmitting} className="w-full space-x-2">
                <span>Masuk Sekarang</span>
                <ArrowRight className="w-4 h-4" />
              </Button>
            </div>
          </form>

          {/* Quick preset credentials for testing/learning */}
          <div className="mt-8 pt-6 border-t border-slate-100">
            <div className="flex items-center space-x-1.5 text-xs font-semibold text-slate-500 mb-2.5">
              <Info className="w-3.5 h-3.5 text-brand-600" />
              <span>Coba Akun Demo Cepat (Klik untuk isi otomatis):</span>
            </div>
            <div className="grid grid-cols-2 gap-2 text-[11px]">
              <button
                type="button"
                onClick={() => setSampleAccount('admin@example.com', 'password')}
                className="p-2 rounded-xl border border-slate-200 text-left hover:border-brand-300 hover:bg-brand-50/50 transition"
              >
                <span className="font-bold text-slate-800 block">Administrator</span>
                <span className="text-slate-400 text-[10px] block">admin@example.com</span>
              </button>

              <button
                type="button"
                onClick={() => setSampleAccount('guru@example.com', 'password')}
                className="p-2 rounded-xl border border-slate-200 text-left hover:border-brand-300 hover:bg-brand-50/50 transition"
              >
                <span className="font-bold text-slate-800 block">Guru / Walas</span>
                <span className="text-slate-400 text-[10px] block">guru@example.com</span>
              </button>
            </div>
          </div>
        </div>

        <p className="text-center text-xs text-slate-400">
          Mengalami kendala akun? Hubungi staf tata usaha sekolah.
        </p>
      </div>
    </div>
  );
};
