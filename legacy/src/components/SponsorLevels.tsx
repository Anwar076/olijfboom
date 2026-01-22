import React from 'react';

const SponsorLevels: React.FC = () => {
  const levels = [
    {
      name: 'Stam',
      lights: '20 lichten',
      amount: '€200.000',
      incentive: 'Auto',
      description: 'Het fundament van onze boom',
      gradient: 'from-amber-900 to-amber-700'
    },
    {
      name: 'Takken',
      lights: '10 lichten',
      amount: '€100.000',
      incentive: 'Mini-auto (Fiat Topolino-achtig)',
      description: 'Sterke ondersteuning voor groei',
      gradient: 'from-amber-800 to-amber-600'
    },
    {
      name: 'Wortels',
      lights: '5 lichten',
      amount: '€50.000',
      incentive: 'Family Corendon all-inclusive vakantie',
      description: 'Diepe verbinding met de gemeenschap',
      gradient: 'from-amber-700 to-amber-500'
    },
    {
      name: 'Olijven',
      lights: '2,5 lichten',
      amount: '€25.000',
      incentive: 'ICB Umrah-ticket',
      description: 'Vruchtbare bijdrage aan het centrum',
      gradient: 'from-amber-600 to-amber-400'
    },
    {
      name: 'Bladeren (groot)',
      lights: '1 licht',
      amount: '€10.000',
      incentive: 'Islamitische VIP-ervaring',
      description: 'Elk blad draagt bij aan de boom',
      gradient: 'from-green-700 to-green-500'
    },
    {
      name: 'Bladeren (klein)',
      lights: '0,5 licht',
      amount: '€5.000',
      incentive: 'Islamitische belevingen & kenniservaringen',
      description: 'Elk blad draagt bij aan de boom',
      gradient: 'from-green-600 to-green-400'
    },
  ];

  return (
    <section id="incentives" className="py-20 px-4">
      <div className="container mx-auto max-w-6xl">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4 title-gradient">Boom van Licht - Incentives</h2>
          <p className="text-xl text-slate-700 mb-4">
            Iedereen (individu, familie, bedrijf of team) krijgt de incentive zodra het bijbehorende bedrag is ingezameld
          </p>
          <p className="text-lg text-slate-600 max-w-3xl mx-auto">
            Uitgangspunt: <span className="font-bold text-gold">1 licht = €10.000</span>. Er is geen loterij en geen puntensysteem.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {levels.map((level, index) => (
            <div
              key={index}
              className="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group"
            >
              {/* Gradient accent */}
              <div className={`absolute top-0 left-0 right-0 h-1 bg-gradient-to-r ${level.gradient}`} />
              
              <div className="relative z-10">
                <div className="flex items-center justify-between mb-3">
                  <div className="text-2xl font-bold text-gold">{level.name}</div>
                  <div className="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                    {level.lights}
                  </div>
                </div>
                
                <div className="text-3xl font-bold text-slate-900 mb-4">{level.amount}</div>
                
                <div className="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                  <div className="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                  <div className="text-lg font-bold text-slate-900">{level.incentive}</div>
                </div>
                
                <p className="text-slate-600 text-sm leading-relaxed">{level.description}</p>
              </div>
            </div>
          ))}
        </div>

        <div className="mt-12 text-center">
          <div className="bg-gold/10 border border-gold/30 rounded-xl p-6 max-w-3xl mx-auto">
            <p className="text-slate-700 text-lg">
              <strong className="text-gold">Let op:</strong> De metafoor van de boom werkt met lichten. Elk niveau wordt bereikt zodra het team het bijbehorende bedrag heeft ingezameld.
            </p>
          </div>
        </div>
      </div>
    </section>
  );
};

export default SponsorLevels;

