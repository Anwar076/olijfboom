import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { API_URL } from '../context/AuthContext';
import Header from '../components/Header';

const targetOptions = [
  { label: 'Blad', amount: 5000 },
  { label: 'Blad', amount: 10000 },
  { label: 'Olijf', amount: 25000 },
  { label: 'Wortel', amount: 50000 },
  { label: 'Tak', amount: 100000 },
  { label: 'Stam', amount: 200000 }
];

const CreateTeamPage: React.FC = () => {
  const navigate = useNavigate();
  const { login } = useAuth();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const [formData, setFormData] = useState({
    teamName: '',
    teamDescription: '',
    targetLabel: 'Blad',
    targetAmount: 5000,
    name: '',
    email: '',
    password: '',
    confirmPassword: ''
  });

  const handleTargetChange = (label: string, amount: number) => {
    setFormData({ ...formData, targetLabel: label, targetAmount: amount });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');

    if (formData.password !== formData.confirmPassword) {
      setError('Wachtwoorden komen niet overeen');
      return;
    }

    if (formData.password.length < 6) {
      setError('Wachtwoord moet minimaal 6 tekens zijn');
      return;
    }

    setLoading(true);

    try {
      const response = await fetch(`${API_URL}/api/auth/register-admin`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          teamName: formData.teamName,
          teamDescription: formData.teamDescription,
          targetLabel: formData.targetLabel,
          targetAmount: formData.targetAmount,
          name: formData.name,
          email: formData.email,
          password: formData.password
        })
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.error || 'Registratie mislukt');
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
        <div className="container mx-auto max-w-2xl">
          <div className="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
            <h1 className="text-4xl font-bold mb-8 title-gradient text-center">Start een Team</h1>

            {error && (
              <div className="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                {error}
              </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-6">
              <div>
                <label className="block text-slate-700 mb-2 font-medium">Team naam *</label>
                <input
                  type="text"
                  required
                  value={formData.teamName}
                  onChange={(e) => setFormData({ ...formData, teamName: e.target.value })}
                  className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                  placeholder="Bijv. Team Vrijwilligers"
                />
              </div>

              <div>
                <label className="block text-slate-700 mb-2 font-medium">Beschrijving (optioneel)</label>
                <textarea
                  value={formData.teamDescription}
                  onChange={(e) => setFormData({ ...formData, teamDescription: e.target.value })}
                  className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                  rows={3}
                  placeholder="Korte beschrijving van je team..."
                />
              </div>

              <div>
                <label className="block text-slate-700 mb-2 font-medium">Kies teamdoel *</label>
                <select
                  required
                  value={`${formData.targetLabel}-${formData.targetAmount}`}
                  onChange={(e) => {
                    const [label, amount] = e.target.value.split('-');
                    handleTargetChange(label, parseInt(amount));
                  }}
                  className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                >
                  {targetOptions.map((option, index) => (
                    <option key={index} value={`${option.label}-${option.amount}`}>
                      {option.label}: €{option.amount.toLocaleString('nl-NL')}
                    </option>
                  ))}
                </select>
              </div>

              <div className="border-t border-slate-300 pt-6 mt-6">
                <h2 className="text-2xl font-bold mb-6 title-gradient">Beheerder Account</h2>

                <div className="space-y-4">
                  <div>
                    <label className="block text-slate-700 mb-2 font-medium">Naam *</label>
                    <input
                      type="text"
                      required
                      value={formData.name}
                      onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                      className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                    />
                  </div>

                  <div>
                    <label className="block text-slate-700 mb-2 font-medium">Email *</label>
                    <input
                      type="email"
                      required
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                      className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                    />
                  </div>

                  <div>
                    <label className="block text-slate-700 mb-2 font-medium">Wachtwoord *</label>
                    <input
                      type="password"
                      required
                      value={formData.password}
                      onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                      className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                      minLength={6}
                    />
                  </div>

                  <div>
                    <label className="block text-slate-700 mb-2 font-medium">Bevestig wachtwoord *</label>
                    <input
                      type="password"
                      required
                      value={formData.confirmPassword}
                      onChange={(e) => setFormData({ ...formData, confirmPassword: e.target.value })}
                      className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                      minLength={6}
                    />
                  </div>
                </div>
              </div>

              <button
                type="submit"
                disabled={loading}
                className="btn btn-primary w-full text-lg disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {loading ? 'Team aanmaken...' : 'Team aanmaken'}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CreateTeamPage;
