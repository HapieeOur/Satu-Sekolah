import React from 'react';
import { Routes, Route, useLocation } from 'react-router-dom';
import { Navbar } from './components/common/Navbar';
import { Footer } from './components/common/Footer';
import { AppLayout } from './layouts/AppLayout';
import { LandingPage } from './pages/LandingPage';
import { NewsPage } from './pages/NewsPage';
import { LoginPage } from './pages/LoginPage';
import { DashboardPage } from './pages/DashboardPage';
import { SchoolProfilePage } from './pages/SchoolProfilePage';
import { NotFoundPage } from './pages/NotFoundPage';
import { ProfilePage } from './pages/ProfilePage';
import { NotificationsPage } from './pages/NotificationsPage';
import { SearchPage } from './pages/SearchPage';
import { UsersPage } from './pages/admin/UsersPage';
import { ClassroomsPage } from './pages/admin/ClassroomsPage';
import { CompaniesPage } from './pages/admin/CompaniesPage';
import { PlacementsPage } from './pages/admin/PlacementsPage';
import { AttendancesPage } from './pages/admin/AttendancesPage';
import { ReportsPage } from './pages/admin/ReportsPage';
import { AcademicYearsPage } from './pages/admin/AcademicYearsPage';
import { TeachersPage } from './pages/admin/TeachersPage';
import { StudentsPage } from './pages/admin/StudentsPage';
import { SubjectsPage } from './pages/admin/SubjectsPage';
import { RoomsPage } from './pages/admin/RoomsPage';
import { SchedulesPage } from './pages/admin/SchedulesPage';
import { PostsPage } from './pages/admin/PostsPage';
import { TeacherModulePage } from './pages/modules/TeacherModulePage';
import { HomeroomModulePage } from './pages/modules/HomeroomModulePage';
import { MentorModulePage } from './pages/modules/MentorModulePage';
import { StudentModulePage } from './pages/modules/StudentModulePage';
import { ProtectedRoute } from './components/auth/ProtectedRoute';

export const App: React.FC = () => {
  const location = useLocation();

  // Determine if the current page is an authenticated dashboard/admin page
  const isAuthPage =
    location.pathname.startsWith('/dashboard') ||
    location.pathname.startsWith('/admin') ||
    location.pathname.startsWith('/teacher') ||
    location.pathname.startsWith('/homeroom') ||
    location.pathname.startsWith('/internship-mentor') ||
    location.pathname.startsWith('/student') ||
    location.pathname.startsWith('/profile') ||
    location.pathname.startsWith('/notifications') ||
    location.pathname.startsWith('/search');

  const isLoginPage = location.pathname === '/login';

  return (
    <div className="min-h-full flex flex-col bg-[#F4F6FB] text-slate-800">
      {/* Only show Public Navbar if not in dashboard and not on login page */}
      {!isAuthPage && !isLoginPage && <Navbar />}

      <div className="flex-1 flex flex-col">
        <Routes>
          {/* Public Routes */}
          <Route path="/" element={<LandingPage />} />
          <Route path="/news" element={<NewsPage />} />
          <Route path="/about" element={<SchoolProfilePage />} />
          <Route path="/login" element={<LoginPage />} />

          {/* Authenticated Dashboard */}
          <Route
            path="/dashboard"
            element={
              <ProtectedRoute>
                <AppLayout>
                  <DashboardPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />

          {/* Search, User Profile & Notifications */}
          <Route
            path="/search"
            element={
              <ProtectedRoute>
                <AppLayout>
                  <SearchPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/profile"
            element={
              <ProtectedRoute>
                <AppLayout>
                  <ProfilePage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/notifications"
            element={
              <ProtectedRoute>
                <AppLayout>
                  <NotificationsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />

          {/* Admin Routes */}
          <Route
            path="/admin/users"
            element={
              <ProtectedRoute allowedRoles={['admin']}>
                <AppLayout>
                  <UsersPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/academic-years"
            element={
              <ProtectedRoute allowedRoles={['admin']}>
                <AppLayout>
                  <AcademicYearsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/teachers"
            element={
              <ProtectedRoute allowedRoles={['admin']}>
                <AppLayout>
                  <TeachersPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/students"
            element={
              <ProtectedRoute allowedRoles={['admin']}>
                <AppLayout>
                  <StudentsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/classrooms"
            element={
              <ProtectedRoute allowedRoles={['admin', 'guru']}>
                <AppLayout>
                  <ClassroomsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/subjects"
            element={
              <ProtectedRoute allowedRoles={['admin']}>
                <AppLayout>
                  <SubjectsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/rooms"
            element={
              <ProtectedRoute allowedRoles={['admin']}>
                <AppLayout>
                  <RoomsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/companies"
            element={
              <ProtectedRoute allowedRoles={['admin', 'guru', 'guru_pembimbing_pkl']}>
                <AppLayout>
                  <CompaniesPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/schedules"
            element={
              <ProtectedRoute allowedRoles={['admin', 'guru']}>
                <AppLayout>
                  <SchedulesPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/placements"
            element={
              <ProtectedRoute allowedRoles={['admin', 'guru_pembimbing_pkl', 'pembimbing_dudi']}>
                <AppLayout>
                  <PlacementsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/attendances"
            element={
              <ProtectedRoute allowedRoles={['admin', 'guru_pembimbing_pkl', 'pembimbing_dudi']}>
                <AppLayout>
                  <AttendancesPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/posts"
            element={
              <ProtectedRoute allowedRoles={['admin']}>
                <AppLayout>
                  <PostsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />
          <Route
            path="/admin/reports"
            element={
              <ProtectedRoute allowedRoles={['admin', 'wali_kelas', 'guru_pembimbing_pkl']}>
                <AppLayout>
                  <ReportsPage />
                </AppLayout>
              </ProtectedRoute>
            }
          />

          {/* Guru Module Routes */}
          <Route
            path="/teacher/*"
            element={
              <ProtectedRoute allowedRoles={['guru', 'admin']}>
                <AppLayout>
                  <TeacherModulePage />
                </AppLayout>
              </ProtectedRoute>
            }
          />

          {/* Wali Kelas Module Routes */}
          <Route
            path="/homeroom/*"
            element={
              <ProtectedRoute allowedRoles={['wali_kelas', 'admin']}>
                <AppLayout>
                  <HomeroomModulePage />
                </AppLayout>
              </ProtectedRoute>
            }
          />

          {/* Pembimbing PKL Module Routes */}
          <Route
            path="/internship-mentor/*"
            element={
              <ProtectedRoute allowedRoles={['guru_pembimbing_pkl', 'pembimbing_dudi', 'admin']}>
                <AppLayout>
                  <MentorModulePage />
                </AppLayout>
              </ProtectedRoute>
            }
          />

          {/* Siswa Module Routes */}
          <Route
            path="/student/*"
            element={
              <ProtectedRoute allowedRoles={['siswa', 'admin']}>
                <AppLayout>
                  <StudentModulePage />
                </AppLayout>
              </ProtectedRoute>
            }
          />

          {/* 404 Not Found Catch-All */}
          <Route path="*" element={<NotFoundPage />} />
        </Routes>
      </div>

      {/* Only show Public Footer if not in dashboard and not on login page */}
      {!isAuthPage && !isLoginPage && <Footer />}
    </div>
  );
};

export default App;
