import React from 'react';

const SponsorLevels: React.FC = () => {
  const levels = [
    {
      name: 'Stam',
      amount: '€200.000+',
      description: 'Het fundament van onze boom',
    },
    {
      name: 'Tak',
      amount: '€100.000+',
      description: 'Sterke ondersteuning voor groei',
    },
    {
      name: 'Wortel',
      amount: '€50.000+',
      description: 'Diepe verbinding met de gemeenschap',
    },
    {
      name: 'Olijven',
      amount: '€25.000',
      description: 'Vruchtbare bijdrage aan het centrum',
    },
    {
      name: 'Bladeren',
      amount: '€10.000 / €5.000',
      description: 'Elk blad draagt bij aan de boom',
    },
  ];

  return (
    <section className="py-20 px-4">
      <div className="container mx-auto max-w-6xl">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4 text-gold">Sponsorniveaus</h2>
          <p className="text-xl text-gray-300">Kies jouw niveau van ondersteuning</p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {levels.map((level, index) => (
            <div
              key={index}
              className="bg-dark-surface/50 rounded-2xl p-6 border border-gray-800 hover:border-gold transition-colors backdrop-blur-sm"
            >
              <div className="text-3xl font-bold text-gold mb-2">{level.name}</div>
              <div className="text-xl font-semibold text-gray-300 mb-3">{level.amount}</div>
              <p className="text-gray-400 text-sm">{level.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default SponsorLevels;

