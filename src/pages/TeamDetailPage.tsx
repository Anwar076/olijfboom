import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import Header from '../components/Header';
import { API_URL } from '../context/AuthContext';

interface TeamDetail {
  id: number;
  name: string;
  description?: string;
  targetLabel: string;
  targetAmount: number;
  teamTotal: number;
  lampStatus: boolean;
  progressRatio: number;
  members: string[];
}

const TeamDetailPage: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [team, setTeam] = useState<TeamDetail | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    if (id) {
      setLoading(true);
      setError('');
      fetchTeam();
    }
  }, [id]);

  const fetchTeam = async () => {
    try {
      const response = await fetch(`${API_URL}/api/teams/${id}/public`);
      if (response.ok) {
        const data = await response.json();
        console.log('Team data:', data); // Debug log
        setTeam(data);
      } else {
        const errorData = await response.json().catch(() => ({ error: 'Unknown error' }));
        console.error('Failed to fetch team:', response.status, errorData);
        setError(errorData.error || 'Team niet gevonden');
      }
    } catch (error) {
      console.error('Failed to fetch team:', error);
      setError('Kon team niet laden');
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-dark-bg">
        <Header />
        <div className="pt-32 text-center text-gold text-xl">Laden...</div>
      </div>
    );
  }

  if (error || !team) {
    return (
      <div className="min-h-screen bg-dark-bg">
        <Header />
        <div className="pt-32 px-4">
          <div className="container mx-auto max-w-md">
            <div className="bg-red-900/30 border border-red-700 text-red-300 rounded-lg p-6 text-center">
              {error || 'Team niet gevonden'}
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

  const percentage = Math.round(team.progressRatio);

  return (
    <div className="min-h-screen bg-dark-bg">
      <Header />
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto max-w-4xl">
          <button
            onClick={() => navigate('/')}
            className="text-gray-400 hover:text-gold transition-colors mb-8"
          >
            ← Terug naar homepage
          </button>

          <div className="bg-dark-surface/50 rounded-3xl p-8 md:p-12 border border-gray-800 backdrop-blur-sm">
            <div className="flex items-start justify-between mb-4">
              <h1 className="text-4xl md:text-5xl font-bold text-gold">{team.name}</h1>
              {/* Lampje indicator */}
              <div className={`w-8 h-8 rounded-full ${team.lampStatus ? 'bg-gold' : 'bg-gray-600'} flex items-center justify-center`}>
                {team.lampStatus && (
                  <svg className="w-5 h-5 text-dark-bg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z" />
                  </svg>
                )}
              </div>
            </div>
            
            {team.description && (
              <p className="text-gray-300 mb-8 text-lg">{team.description}</p>
            )}

            <div className="mb-8">
              <div className="flex justify-between items-center mb-4">
                <span className="text-gray-400">Totaal opgehaald</span>
                <span className="text-2xl font-bold text-gold">€{team.teamTotal.toLocaleString('nl-NL')}</span>
              </div>
              <div className="w-full bg-gray-800 rounded-full h-4 overflow-hidden mb-2">
                <div
                  className="bg-gradient-to-r from-gold to-gold-dark h-4 rounded-full transition-all duration-500"
                  style={{ width: `${Math.min(percentage, 100)}%` }}
                />
              </div>
              <div className="text-sm text-gray-500">
                Doel: €{team.targetAmount.toLocaleString('nl-NL')} ({percentage}%)
              </div>
            </div>

            <div className="border-t border-gray-700 pt-8">
              <h2 className="text-2xl font-bold mb-6 text-gold">Teamleden</h2>
              {team.members.length === 0 ? (
                <p className="text-gray-400">Nog geen teamleden</p>
              ) : (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {team.members.map((member, index) => (
                    <div
                      key={index}
                      className="bg-dark-surface/50 rounded-lg p-4 border border-gray-700"
                    >
                      <div className="text-white font-medium">{member}</div>
                    </div>
                  ))}
                </div>
              )}
            </div>

            <div className="mt-8 text-center">
              <button
                onClick={() => {
                  navigate(`/?team=${team.id}`);
                  setTimeout(() => {
                    document.getElementById('doneer')?.scrollIntoView({ behavior: 'smooth' });
                  }, 100);
                }}
                className="bg-gold text-dark-bg px-8 py-4 rounded-full font-bold text-lg hover:bg-gold-dark transition-colors"
              >
                Doneer aan dit team
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default TeamDetailPage;
