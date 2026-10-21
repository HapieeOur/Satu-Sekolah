import React, { useState } from 'react';
import { useNavigate, useLocation, Link } from 'react-router-dom';
import { Lock, Mail, ArrowRight, AlertCircle, Eye, EyeOff } from 'lucide-react';
import { useAuth } from '../context/AuthContext';

export const LoginPage: React.FC = () => {
  const [loginInput, setLoginInput] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);

  const { login } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();

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
    <div className="min-h-full py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto my-auto">
      {/* Main Modal Split Container matching Blade Design */}
      <div className="bg-white rounded-[32px] sm:rounded-[36px] border border-slate-200/90 shadow-2xl shadow-slate-900/10 p-4 sm:p-6 lg:p-7 grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        {/* Left Column: Authentication Form */}
        <div className="lg:col-span-6 flex flex-col justify-between py-2 sm:py-4 px-2 sm:px-6">
          {/* Logo Section */}
          <div className="w-full max-w-md mx-auto pt-2 pb-5 flex items-center justify-start select-none">
            <Link to="/" className="flex items-center gap-2.5 group">
              <span className="font-black text-2xl tracking-tight text-[#171B61] group-hover:text-[#233DFF] transition-colors">
                SATU<span className="text-[#233DFF]">SEKOLAH</span><span className="text-[#F4CF52]">.</span>
              </span>
              <span className="text-[10px] font-semibold text-slate-400 tracking-wider uppercase border-l pl-2 border-slate-300">
                Portal Masuk
              </span>
            </Link>
          </div>

          {/* Form Body */}
          <div className="my-auto py-4 max-w-md w-full mx-auto">
            <div className="space-y-1.5 mb-6">
              <h1 className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Masuk ke Satu-Sekolah
              </h1>
              <p className="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                Silakan masukkan kredensial akun Anda untuk mengakses sistem akademik & administrasi.
              </p>
            </div>

            {error && (
              <div className="mb-5 rounded-2xl bg-rose-50 border border-rose-300 p-3.5 text-xs text-rose-900 shadow-xs flex items-center gap-2.5">
                <AlertCircle className="w-4 h-4 text-rose-700 shrink-0" />
                <span className="font-medium">{error}</span>
              </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-4">
              {/* Login Field */}
              <div>
                <label className="block text-xs font-extrabold text-slate-800 mb-1.5">
                  Email / NISN / NIS / NIP <span className="text-rose-600">*</span>
                </label>
                <div className="relative">
                  <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <Mail className="w-4 h-4" />
                  </span>
                  <input
                    type="text"
                    value={loginInput}
                    onChange={(e) => setLoginInput(e.target.value)}
                    required
                    autoFocus
                    placeholder="Masukkan email, NIS, atau NIP"
                    className="block w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 bg-white text-slate-900 text-xs sm:text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] transition shadow-xs"
                  />
                </div>
              </div>

              {/* Password Field */}
              <div>
                <div className="flex items-center justify-between mb-1.5">
                  <label className="block text-xs font-extrabold text-slate-800">
                    Password <span className="text-rose-600">*</span>
                  </label>
                </div>
                <div className="relative">
                  <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <Lock className="w-4 h-4" />
                  </span>
                  <input
                    type={showPassword ? 'text' : 'password'}
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                    placeholder="Masukkan kata sandi Anda"
                    className="block w-full pl-10 pr-11 py-3 rounded-xl border border-slate-300 bg-white text-slate-900 text-xs sm:text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] transition shadow-xs"
                  />
                  <button
                    type="button"
                    onClick={() => setShowPassword(!showPassword)}
                    aria-label="Toggle password"
                    className="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer"
                  >
                    {showPassword ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                  </button>
                </div>
              </div>

              {/* Submit Button */}
              <div className="pt-2">
                <button
                  type="submit"
                  disabled={isSubmitting}
                  className="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl text-sm font-extrabold text-white bg-[#233DFF] hover:bg-[#1B30D9] active:bg-[#1524A3] shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/45 hover:-translate-y-0.5 transition duration-150 cursor-pointer disabled:opacity-50"
                >
                  {isSubmitting ? (
                    <span>Memproses...</span>
                  ) : (
                    <>
                      <span>Masuk ke Portal</span>
                      <ArrowRight className="w-4 h-4" />
                    </>
                  )}
                </button>
              </div>
            </form>

            {/* Quick Demo Fill Chips */}
            <div className="mt-6 pt-5 border-t border-slate-100">
              <span className="text-[11px] font-bold text-slate-500 block mb-2">
                Pilih Akun Demo Cepat:
              </span>
              <div className="grid grid-cols-2 gap-2 text-xs">
                <button
                  type="button"
                  onClick={() => setSampleAccount('admin@example.com', 'password')}
                  className="p-2.5 rounded-xl border border-slate-200 text-left hover:border-[#233DFF] hover:bg-blue-50/50 transition cursor-pointer"
                >
                  <span className="font-extrabold text-slate-800 block text-[11px]">Administrator</span>
                  <span className="text-slate-400 text-[10px] block">admin@example.com</span>
                </button>
                <button
                  type="button"
                  onClick={() => setSampleAccount('guru@example.com', 'password')}
                  className="p-2.5 rounded-xl border border-slate-200 text-left hover:border-[#233DFF] hover:bg-blue-50/50 transition cursor-pointer"
                >
                  <span className="font-extrabold text-slate-800 block text-[11px]">Guru / Walas</span>
                  <span className="text-slate-400 text-[10px] block">guru@example.com</span>
                </button>
              </div>
            </div>
          </div>

          {/* Footer */}
          <div className="w-full max-w-md mx-auto pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 font-medium gap-2">
            <span>&copy; Satu-Sekolah Platform</span>
            <Link to="/" className="hover:text-slate-700">
              Kembali ke Beranda
            </Link>
          </div>
        </div>

        {/* Right Column: Showcase Card (Matching Blade Showcase) */}
        <div
          className="lg:col-span-6 rounded-[28px] p-6 sm:p-8 lg:p-9 flex flex-col justify-between relative overflow-hidden shadow-2xl border border-[#1C206B] text-white select-none min-h-[520px]"
          style={{
            background: 'linear-gradient(180deg, #131652 0%, #0E103D 50%, #171B61 100%)',
          }}
        >
          {/* Ambient Glows */}
          <div className="absolute -top-24 -right-24 w-80 h-80 bg-[#233DFF]/30 rounded-full blur-3xl pointer-events-none" />
          <div className="absolute -bottom-24 -left-24 w-80 h-80 bg-[#171B61]/80 rounded-full blur-3xl pointer-events-none" />

          {/* Badge */}
          <div className="relative z-20 flex items-center justify-between pb-2">
            <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/10 text-white border border-white/20 backdrop-blur-md">
              <span className="w-1.5 h-1.5 rounded-full bg-[#F4CF52]" />
              <span>Fitur Unggulan Vokasi</span>
            </div>
          </div>

          {/* Floating feature showcase cards */}
          <div className="relative z-10 space-y-4 my-auto py-6">
            <div className="bg-white text-slate-900 rounded-2xl p-4 shadow-xl border border-white/90 transform -rotate-1 hover:rotate-0 transition duration-300">
              <div className="flex items-center justify-between text-xs mb-2">
                <span className="font-extrabold text-[#171B61]">Presensi QR &amp; Face Detect</span>
                <span className="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                  Real-Time
                </span>
              </div>
              <p className="text-xs text-slate-600 leading-relaxed">
                Pencatatan presensi siswa dan guru secara otomatis terhubung langsung ke dashboard wali kelas dan orang tua.
              </p>
            </div>

            <div className="bg-white text-slate-900 rounded-2xl p-4 shadow-xl border border-white/90 transform rotate-1 hover:rotate-0 transition duration-300">
              <div className="flex items-center justify-between text-xs mb-2">
                <span className="font-extrabold text-[#171B61]">Monitoring PKL &amp; Geofence</span>
                <span className="text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">
                  Radius Map
                </span>
              </div>
              <p className="text-xs text-slate-600 leading-relaxed">
                Validasi kehadiran siswa magang di lokasi perusahaan mitra DUDI dengan sistem geofencing peta interaktif.
              </p>
            </div>
          </div>

          {/* Bottom text */}
          <div className="relative z-10 pt-4 border-t border-white/10 text-xs text-indigo-200 flex items-center justify-between">
            <span>Satu Akses Semua Peran</span>
            <span className="text-[#F4CF52] font-bold">Terintegrasi Cloud</span>
          </div>
        </div>
      </div>
    </div>
  );
};
