import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { API_URL } from '../context/AuthContext';
import Header from '../components/Header';

const LoginPage: React.FC = () => {
  const navigate = useNavigate();
  const { login } = useAuth();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const [formData, setFormData] = useState({
    email: '',
    password: ''
  });

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const response = await fetch(`${API_URL}/api/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.error || 'Inloggen mislukt');
      }

      // Fetch full user data
      const userResponse = await fetch(`${API_URL}/api/me`, {
        headers: { 'Authorization': `Bearer ${data.token}` }
      });

      if (userResponse.ok) {
        const userData = await userResponse.json();
        login(data.token, userData);
        navigate('/dashboard');
      } else {
        throw new Error('Kon gebruikersgegevens niet ophalen');
      }
    } catch (err: any) {
      setError(err.message || 'Er is iets misgegaan');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-slate-50">
      <Header />
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto max-w-md">
          <div className="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
            <h1 className="text-4xl font-bold mb-8 title-gradient text-center">Inloggen</h1>

            {error && (
              <div className="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                {error}
              </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-6">
              <div>
                <label className="block text-slate-700 mb-2 font-medium">Email</label>
                <input
                  type="email"
                  required
                  value={formData.email}
                  onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                  className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                />
              </div>

              <div>
                <label className="block text-slate-700 mb-2 font-medium">Wachtwoord</label>
                <input
                  type="password"
                  required
                  value={formData.password}
                  onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                  className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                />
              </div>

              <button
                type="submit"
                disabled={loading}
                className="btn btn-primary w-full text-lg disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {loading ? 'Inloggen...' : 'Inloggen'}
              </button>
            </form>

            <div className="mt-6 text-center text-slate-600">
              <p>
                Nog geen team?{' '}
                <Link to="/teams/new" className="text-gold hover:underline">
                  Start een team
                </Link>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LoginPage;

