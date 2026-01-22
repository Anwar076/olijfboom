import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { API_URL } from '../context/AuthContext';

interface Team {
  id: number;
  name: string;
  targetLabel: string;
  targetAmount: number;
  teamTotal: number;
  lampStatus: boolean;
  progressRatio: number;
}

const Teams: React.FC = () => {
  const navigate = useNavigate();
  const [teams, setTeams] = useState<Team[]>([]);
  const [displayedCount, setDisplayedCount] = useState(6);
  const [totalTeams, setTotalTeams] = useState(0);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchTeams();
  }, []);

  const fetchTeams = async () => {
    try {
      const response = await fetch(`${API_URL}/api/teams?limit=100`);
      if (response.ok) {
        const data = await response.json();
        setTeams(data);
        setTotalTeams(data.length);
      }
    } catch (error) {
      console.error('Failed to fetch teams:', error);
    } finally {
      setLoading(false);
    }
  };

  const loadMore = () => {
    setDisplayedCount(prev => prev + 6);
  };

  const displayedTeams = teams.slice(0, displayedCount);
  const hasMore = displayedCount < totalTeams;

  if (loading) {
    return (
      <section id="teams" className="py-20 px-4 bg-slate-100/60">
        <div className="container mx-auto max-w-6xl">
          <div className="text-center text-slate-600">Teams laden...</div>
        </div>
      </section>
    );
  }

  return (
    <section id="teams" className="py-20 px-4 bg-slate-100/60">
      <div className="container mx-auto max-w-6xl">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4 title-gradient">Teams van Licht</h2>
          <p className="text-xl text-slate-700 mb-8">
            Samen bereiken we meer. Start of sluit je aan bij een team
          </p>
          <button
            onClick={() => navigate('/teams/new')}
            className="btn btn-primary"
          >
            Maak een team aan
          </button>
        </div>

        {teams.length === 0 ? (
          <div className="text-center text-slate-600">
            <p>Teams worden hier weergegeven zodra ze zijn aangemaakt.</p>
            <p className="mt-2">Start een team om te beginnen!</p>
          </div>
        ) : (
          <>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              {displayedTeams.map((team) => {
                const percentage = Math.round(team.progressRatio || 0);
                const targetAmount = team.targetAmount || 0;
                const teamTotal = team.teamTotal || 0;
                return (
                  <div
                    key={team.id}
                    onClick={() => navigate(`/teams/${team.id}`)}
                    className="bg-white/80 rounded-2xl p-6 border border-slate-200 backdrop-blur-sm cursor-pointer hover:border-gold transition-colors"
                  >
                    <div className="flex items-start justify-between mb-4">
                      <h3 className="text-xl font-bold text-gold">{team.name}</h3>
                      {/* Lampje indicator */}
                      <div className={`w-6 h-6 rounded-full ${team.lampStatus ? 'bg-gold' : 'bg-slate-400'} flex items-center justify-center`}>
                        {team.lampStatus && (
                          <svg className="w-4 h-4 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z" />
                          </svg>
                        )}
                      </div>
                    </div>
                    <div className="mb-4">
                      <div className="flex justify-between text-sm mb-2">
                        <span className="text-slate-600">Opgehaald</span>
                        <span className="text-gold font-semibold">€{teamTotal.toLocaleString('nl-NL')}</span>
                      </div>
                      <div className="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div
                          className="bg-gradient-to-r from-gold to-gold-dark h-2 rounded-full transition-all duration-500"
                          style={{ width: `${Math.min(percentage, 100)}%` }}
                        />
                      </div>
                      <div className="text-xs text-slate-500 mt-1">
                        Doel: €{targetAmount.toLocaleString('nl-NL')} ({percentage}%)
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>

            {hasMore && (
              <div className="text-center">
                <button
                  onClick={loadMore}
                  className="btn btn-secondary"
                >
                  Bekijk meer teams
                </button>
              </div>
            )}
          </>
        )}
      </div>
    </section>
  );
};

export default Teams;
