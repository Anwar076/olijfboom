import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { API_URL } from '../context/AuthContext';
import Header from '../components/Header';

const InvitePage: React.FC = () => {
  const { token } = useParams<{ token: string }>();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState(false);
  const [inviteInfo, setInviteInfo] = useState<any>(null);

  const [formData, setFormData] = useState({
    name: '',
    email: ''
  });

  useEffect(() => {
    if (token) {
      fetchInviteInfo();
    }
  }, [token]);

  const fetchInviteInfo = async () => {
    try {
      const response = await fetch(`${API_URL}/api/invites/${token}`);
      if (response.ok) {
        const data = await response.json();
        setInviteInfo(data);
      } else {
        setError('Ongeldige uitnodigingslink');
      }
    } catch (error) {
      setError('Kon uitnodiging niet laden');
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');

    if (!formData.name || !formData.email) {
      setError('Naam en email zijn verplicht');
      return;
    }

    setLoading(true);

    try {
      const response = await fetch(`${API_URL}/api/invites/${token}/accept`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name: formData.name,
          email: formData.email
        })
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.error || 'Accepteren mislukt');
      }

      setSuccess(true);
      setTimeout(() => {
        navigate('/');
      }, 2000);
    } catch (err: any) {
      setError(err.message || 'Er is iets misgegaan');
    } finally {
      setLoading(false);
    }
  };

  if (loading && !inviteInfo) {
    return (
      <div className="min-h-screen bg-slate-50">
        <Header />
        <div className="pt-32 text-center text-gold text-xl">Laden...</div>
      </div>
    );
  }

  if (error && !inviteInfo) {
    return (
      <div className="min-h-screen bg-slate-50">
        <Header />
        <div className="pt-32 px-4">
          <div className="container mx-auto max-w-md">
            <div className="bg-red-50 border border-red-200 text-red-700 rounded-lg p-6 text-center">
              {error}
            </div>
            <div className="text-center mt-4">
              <button
                onClick={() => navigate('/')}
                className="text-gold hover:underline"
              >
                Terug naar homepage
              </button>
            </div>
          </div>
        </div>
      </div>
    );
  }

  if (success) {
    return (
      <div className="min-h-screen bg-slate-50">
        <Header />
        <div className="pt-32 pb-20 px-4">
          <div className="container mx-auto max-w-md">
            <div className="bg-green-50 border border-green-200 text-green-700 rounded-lg p-6 text-center">
              <h2 className="text-2xl font-bold mb-4">Succesvol toegevoegd!</h2>
              <p>Je bent toegevoegd aan het team {inviteInfo?.teamName}.</p>
              <p className="mt-2 text-sm">Je wordt doorgestuurd naar de homepage...</p>
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-slate-50">
      <Header />
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto max-w-md">
          <div className="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
            <h1 className="text-4xl font-bold mb-4 title-gradient text-center">Uitnodiging Accepteren</h1>
            {inviteInfo && (
              <p className="text-center text-slate-600 mb-8">
                Je bent uitgenodigd voor: <span className="text-gold font-semibold">{inviteInfo.teamName}</span>
              </p>
            )}

            {error && (
              <div className="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                {error}
              </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-6">
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

              <button
                type="submit"
                disabled={loading}
                className="btn btn-primary w-full text-lg disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {loading ? 'Accepteren...' : 'Accepteren & Lid worden'}
              </button>

              <p className="text-sm text-slate-600 text-center">
                Als lid kun je niet inloggen. Je wordt alleen toegevoegd aan het team.
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default InvitePage;
