import React, { useState, useEffect } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';
import { API_URL } from '../context/AuthContext';

interface Team {
  id: number;
  name: string;
}

const suggestedAmounts = [10, 25, 50, 100, 250];

const Donate: React.FC = () => {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const [teams, setTeams] = useState<Team[]>([]);
  const [selectedTeam, setSelectedTeam] = useState<number | null>(null);
  const [selectedAmount, setSelectedAmount] = useState<number | null>(null);
  const [customAmount, setCustomAmount] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchTeams();
    const teamParam = searchParams.get('team');
    if (teamParam) {
      setSelectedTeam(parseInt(teamParam));
    }
  }, [searchParams]);

  const fetchTeams = async () => {
    try {
      const response = await fetch(`${API_URL}/api/teams?limit=100`);
      if (response.ok) {
        const data = await response.json();
        setTeams(data);
      }
    } catch (error) {
      console.error('Failed to fetch teams:', error);
    }
  };

  const handleDonate = async () => {
    if (!selectedTeam) {
      setError('Selecteer eerst een team');
      return;
    }

    const amount = selectedAmount || (customAmount ? parseFloat(customAmount) : null);
    
    if (!amount || amount < 1) {
      setError('Voer een bedrag in (minimaal €1)');
      return;
    }

    setLoading(true);
    setError('');

    try {
      const response = await fetch(`${API_URL}/api/donations`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          teamId: selectedTeam,
          amount: amount
        })
      });

      if (response.ok) {
        // Placeholder - in real implementation, redirect to payment
        alert(`Donatie van €${amount.toFixed(2)} wordt verwerkt... (placeholder)`);
        // Reset form
        setSelectedTeam(null);
        setSelectedAmount(null);
        setCustomAmount('');
        // Refresh page stats
        window.location.reload();
      } else {
        const data = await response.json();
        setError(data.error || 'Donatie mislukt');
      }
    } catch (err: any) {
      setError(err.message || 'Er is iets misgegaan');
    } finally {
      setLoading(false);
    }
  };

  return (
    <section id="doneer" className="py-20 px-4">
      <div className="container mx-auto max-w-2xl">
        <div className="text-center mb-12">
          <h2 className="text-4xl md:text-5xl font-bold mb-4 title-gradient">Doneer</h2>
          <p className="text-xl text-slate-700">
            Kies een groep en help ons het doel te bereiken
          </p>
        </div>

        <div className="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
          {error && (
            <div className="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
              {error}
            </div>
          )}

          {/* Step 1: Select Team */}
          <div className="mb-8">
            <label className="block text-slate-700 mb-4 font-medium">Stap 1: Kies je groep *</label>
            <select
              required
              value={selectedTeam || ''}
              onChange={(e) => setSelectedTeam(parseInt(e.target.value))}
              className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
            >
              <option value="">-- Selecteer een groep --</option>
              {teams.map(team => (
                <option key={team.id} value={team.id}>{team.name}</option>
              ))}
            </select>
          </div>

          {/* Step 2: Enter Amount */}
          <div className="mb-8">
            <label className="block text-slate-700 mb-4 font-medium">Stap 2: Voer bedrag in *</label>
            
            <div className="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
              {suggestedAmounts.map((amount) => (
                <button
                  key={amount}
                  type="button"
                  onClick={() => {
                    setSelectedAmount(amount);
                    setCustomAmount('');
                  }}
                  className={`py-3 px-4 rounded-lg font-semibold transition-colors ${
                    selectedAmount === amount
                      ? 'bg-gold text-slate-900'
                      : 'bg-white border border-slate-300 text-slate-700 hover:border-gold'
                  }`}
                >
                  €{amount}
                </button>
              ))}
            </div>

            <div>
              <label className="block text-slate-700 mb-2 font-medium">Of kies een ander bedrag</label>
              <input
                type="number"
                value={customAmount}
                onChange={(e) => {
                  setCustomAmount(e.target.value);
                  setSelectedAmount(null);
                }}
                placeholder="€0,00"
                min="1"
                step="0.01"
                className="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
              />
            </div>
          </div>

          {/* Step 3: Confirm */}
          {(selectedAmount || customAmount) && selectedTeam && (
            <div className="mb-8 p-4 bg-gold/10 border border-gold/30 rounded-lg">
              <div className="text-slate-700 mb-2">
                <strong className="text-gold">Bedrag:</strong> €{(selectedAmount || parseFloat(customAmount) || 0).toFixed(2)}
              </div>
              <div className="text-slate-700">
                <strong className="text-gold">Groep:</strong> {teams.find(t => t.id === selectedTeam)?.name}
              </div>
            </div>
          )}

          <button
            onClick={handleDonate}
            disabled={loading || !selectedTeam || (!selectedAmount && !customAmount)}
            className="btn btn-primary w-full text-lg disabled:opacity-50 disabled:cursor-not-allowed mb-4"
          >
            {loading ? 'Verwerken...' : 'Doneer via iDEAL (Mollie)'}
          </button>

          <p className="text-center text-sm text-slate-600">
            Veilig betalen • Direct bevestigd
          </p>
        </div>
      </div>
    </section>
  );
};

export default Donate;
