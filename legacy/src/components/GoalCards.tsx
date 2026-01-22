import React from 'react';

const GoalCards: React.FC = () => {
  const goals = [
    {
      title: 'Lening aflossen',
      description: 'Verminder onze schuld zodat we meer kunnen investeren in de gemeenschap.',
    },
    {
      title: 'Investeren in jongeren & onderwijs',
      description: 'Ondersteun educatieve programma\'s en activiteiten voor de jeugd.',
    },
    {
      title: 'Sterke gemeenschap opbouwen',
      description: 'Bouw samen aan een hechte en bloeiende moslimgemeenschap in Barendrecht.',
    },
  ];

  return (
    <section id="doel" className="py-20 px-4 bg-slate-100/60">
      <div className="container mx-auto max-w-6xl">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4 title-gradient">Ons Doel</h2>
          <p className="text-xl text-slate-700 max-w-2xl mx-auto">
            Waarom we deze campagne hebben gestart
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {goals.map((goal, index) => (
            <div
              key={index}
              className="bg-white/80 rounded-2xl p-8 border border-slate-200 hover:border-gold/50 transition-colors backdrop-blur-sm"
            >
              <h3 className="text-2xl font-bold mb-4 text-gold">{goal.title}</h3>
              <p className="text-slate-600 leading-relaxed">{goal.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default GoalCards;

