import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import HomePage from './pages/HomePage';
import CreateTeamPage from './pages/CreateTeamPage';
import LoginPage from './pages/LoginPage';
import DashboardPage from './pages/DashboardPage';
import InvitePage from './pages/InvitePage';
import TeamDetailPage from './pages/TeamDetailPage';
import ProtectedRoute from './components/ProtectedRoute';

function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/teams/new" element={<CreateTeamPage />} />
          <Route path="/login" element={<LoginPage />} />
          <Route
            path="/dashboard"
            element={
              <ProtectedRoute>
                <DashboardPage />
              </ProtectedRoute>
            }
          />
          <Route path="/invite/:token" element={<InvitePage />} />
          <Route path="/teams/:id" element={<TeamDetailPage />} />
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  );
}

export default App;
