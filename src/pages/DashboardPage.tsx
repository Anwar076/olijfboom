import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { API_URL } from '../context/AuthContext';
import Header from '../components/Header';

interface Team {
  id: number;
  name: string;
  description: string;
  target_label: string;
  target_amount: number;
  members: Array<{
    id: number;
    user_id: number;
    name: string;
    email: string;
    role: string;
  }>;
  teamTotal: number;
  lampStatus: boolean;
  progressRatio: number;
}

const DashboardPage: React.FC = () => {
  const { user, token, logout } = useAuth();
  const navigate = useNavigate();
  const [team, setTeam] = useState<Team | null>(null);
  const [loading, setLoading] = useState(true);
  const [inviteUrl, setInviteUrl] = useState('');
  const [showAddMember, setShowAddMember] = useState(false);
  const [newMember, setNewMember] = useState({ name: '', email: '' });

  useEffect(() => {
    if (user?.team) {
      fetchTeam(user.team.id);
    }
  }, [user]);

  const fetchTeam = async (teamId: number) => {
    try {
      const response = await fetch(`${API_URL}/api/teams/${teamId}`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });

      if (response.ok) {
        const data = await response.json();
        setTeam(data);
      }
    } catch (error) {
      console.error('Failed to fetch team:', error);
    } finally {
      setLoading(false);
    }
  };

  const generateInvite = async () => {
    if (!team) return;

    try {
      const response = await fetch(`${API_URL}/api/teams/${team.id}/invites`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      });

      if (response.ok) {
        const data = await response.json();
        setInviteUrl(data.inviteUrl || `${window.location.origin}/invite/${data.token}`);
      }
    } catch (error) {
      console.error('Failed to generate invite:', error);
    }
  };

  const addMember = async () => {
    if (!team || !newMember.name || !newMember.email) return;

    try {
      const response = await fetch(`${API_URL}/api/teams/${team.id}/members`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(newMember)
      });

      if (response.ok) {
        await fetchTeam(team.id);
        setNewMember({ name: '', email: '' });
        setShowAddMember(false);
      }
    } catch (error) {
      console.error('Failed to add member:', error);
    }
  };

  const removeMember = async (memberId: number) => {
    if (!team) return;
    if (!confirm('Weet je zeker dat je dit lid wilt verwijderen?')) return;

    try {
      await fetch(`${API_URL}/api/teams/${team.id}/members/${memberId}`, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
      });

      await fetchTeam(team.id);
    } catch (error) {
      console.error('Failed to remove member:', error);
    }
  };

  const copyInviteLink = () => {
    navigator.clipboard.writeText(inviteUrl);
    alert('Uitnodigingslink gekopieerd!');
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-dark-bg">
        <Header />
        <div className="pt-32 text-center text-gold text-xl">Laden...</div>
      </div>
    );
  }

  if (!team) {
    return (
      <div className="min-h-screen bg-dark-bg">
        <Header />
        <div className="pt-32 text-center text-red-400">Team niet gevonden</div>
      </div>
    );
  }

  const percentage = Math.round(team.progressRatio);

  return (
    <div className="min-h-screen bg-dark-bg">
      <Header />
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto max-w-6xl">
          <div className="flex justify-between items-center mb-8">
            <h1 className="text-4xl font-bold text-gold">Team Dashboard</h1>
            <button
              onClick={logout}
              className="text-gray-400 hover:text-gold transition-colors"
            >
              Uitloggen
            </button>
          </div>

          {/* Team Info */}
          <div className="bg-dark-surface/50 rounded-2xl p-6 mb-6 border border-gray-800 backdrop-blur-sm">
            <div className="flex items-start justify-between mb-4">
              <div>
                <h2 className="text-2xl font-bold mb-2 text-gold">{team.name}</h2>
                {team.description && <p className="text-gray-400">{team.description}</p>}
              </div>
              {/* Lampje indicator */}
              <div className={`w-8 h-8 rounded-full ${team.lampStatus ? 'bg-gold' : 'bg-gray-600'} flex items-center justify-center`}>
                {team.lampStatus && (
                  <svg className="w-5 h-5 text-dark-bg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z" />
                  </svg>
                )}
              </div>
            </div>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
              <div>
                <div className="text-sm text-gray-400">Teamdoel</div>
                <div className="text-xl font-bold text-gold">{team.target_label}: €{team.target_amount.toLocaleString('nl-NL')}</div>
              </div>
              <div>
                <div className="text-sm text-gray-400">Totaal opgehaald</div>
                <div className="text-xl font-bold text-gold">€{team.teamTotal.toLocaleString('nl-NL')}</div>
              </div>
              <div>
                <div className="text-sm text-gray-400">Leden</div>
                <div className="text-xl font-bold text-gold">{team.members.length}</div>
              </div>
            </div>
            <div className="w-full bg-gray-800 rounded-full h-2 overflow-hidden">
              <div
                className="bg-gradient-to-r from-gold to-gold-dark h-2 rounded-full transition-all duration-500"
                style={{ width: `${Math.min(percentage, 100)}%` }}
              />
            </div>
            <div className="text-xs text-gray-500 mt-2">
              {percentage}% naar doel
            </div>
          </div>

          {/* Invite Section */}
          {user?.role === 'admin' && (
            <div className="bg-dark-surface/50 rounded-2xl p-6 mb-6 border border-gray-800 backdrop-blur-sm">
              <h3 className="text-xl font-bold mb-4 text-gold">Uitnodigingen</h3>
              {inviteUrl ? (
                <div className="flex gap-4 items-center">
                  <input
                    type="text"
                    value={inviteUrl}
                    readOnly
                    className="flex-1 bg-dark-surface border border-gray-700 rounded-lg px-4 py-2 text-white text-sm"
                  />
                  <button
                    onClick={copyInviteLink}
                    className="bg-gold text-dark-bg px-6 py-2 rounded-lg font-semibold hover:bg-gold-dark transition-colors"
                  >
                    Kopieer link
                  </button>
                  <button
                    onClick={() => setInviteUrl('')}
                    className="border border-gray-700 text-gray-400 px-4 py-2 rounded-lg hover:border-gold hover:text-gold transition-colors"
                  >
                    Nieuw
                  </button>
                </div>
              ) : (
                <button
                  onClick={generateInvite}
                  className="bg-gold text-dark-bg px-6 py-2 rounded-lg font-semibold hover:bg-gold-dark transition-colors"
                >
                  Genereer uitnodigingslink
                </button>
              )}
            </div>
          )}

          {/* Add Member */}
          {user?.role === 'admin' && (
            <div className="bg-dark-surface/50 rounded-2xl p-6 mb-6 border border-gray-800 backdrop-blur-sm">
              <div className="flex justify-between items-center mb-4">
                <h3 className="text-xl font-bold text-gold">Lid toevoegen</h3>
                <button
                  onClick={() => setShowAddMember(!showAddMember)}
                  className="text-gold hover:underline"
                >
                  {showAddMember ? 'Annuleren' : 'Lid toevoegen'}
                </button>
              </div>

              {showAddMember && (
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <input
                    type="text"
                    placeholder="Naam"
                    value={newMember.name}
                    onChange={(e) => setNewMember({ ...newMember, name: e.target.value })}
                    className="bg-dark-surface border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-gold focus:outline-none"
                  />
                  <input
                    type="email"
                    placeholder="Email"
                    value={newMember.email}
                    onChange={(e) => setNewMember({ ...newMember, email: e.target.value })}
                    className="bg-dark-surface border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-gold focus:outline-none"
                  />
                  <button
                    onClick={addMember}
                    className="bg-gold text-dark-bg px-4 py-2 rounded-lg font-semibold hover:bg-gold-dark transition-colors"
                  >
                    Toevoegen
                  </button>
                </div>
              )}
            </div>
          )}

          {/* Members List */}
          <div className="bg-dark-surface/50 rounded-2xl p-6 border border-gray-800 backdrop-blur-sm">
            <h3 className="text-xl font-bold mb-4 text-gold">Teamleden</h3>
            <div className="space-y-4">
              {team.members.map((member) => (
                <div
                  key={member.id}
                  className="bg-dark-surface/50 rounded-lg p-4 border border-gray-700 flex flex-col md:flex-row md:items-center gap-4"
                >
                  <div className="flex-1">
                    <div className="font-semibold text-white">{member.name}</div>
                    <div className="text-sm text-gray-400">{member.email}</div>
                    <div className="text-xs text-gray-500 mt-1">
                      {member.role === 'admin' ? 'Beheerder' : 'Lid'}
                    </div>
                  </div>

                  {user?.role === 'admin' && member.user_id !== user.id && (
                    <button
                      onClick={() => removeMember(member.id)}
                      className="text-red-400 hover:text-red-300 transition-colors"
                    >
                      Verwijderen
                    </button>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DashboardPage;
