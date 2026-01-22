import React from 'react';
import { useNavigate } from 'react-router-dom';

interface HeroProps {
  totalRaised: number;
  lightsActivated: number;
  progressPercentage: number;
}

const Hero: React.FC<HeroProps> = ({ totalRaised, lightsActivated, progressPercentage }) => {
  const navigate = useNavigate();
  const percentage = Math.round(progressPercentage);

  const scrollToSection = (id: string) => {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
  };

  return (
    <section className="pt-32 pb-20 px-4">
      <div className="container mx-auto max-w-4xl text-center">
        <h1 className="text-5xl md:text-6xl font-bold mb-6 title-gradient">
          Olijfboom van Licht
        </h1>
        <p className="text-xl md:text-2xl text-slate-700 mb-4">
          100 lichten voor €1.000.000
        </p>
        <p className="text-lg text-slate-600 mb-12 max-w-2xl mx-auto">
          Steun het Islamitisch Centrum Barendrecht door een licht te ontsteken. 
          Elk licht vertegenwoordigt €10.000 en brengt ons dichter bij ons doel. 
          Samen bouwen we aan een sterkere gemeenschap.
        </p>

        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-16">
          <button
            onClick={() => scrollToSection('doneer')}
            className="btn btn-primary text-lg"
          >
            Doneer nu
          </button>
          <button
            onClick={() => navigate('/teams/new')}
            className="btn btn-secondary text-lg"
          >
            Start een team
          </button>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
          <div className="bg-white/80 rounded-2xl p-6 backdrop-blur-sm border border-slate-200">
            <div className="text-3xl font-bold text-gold mb-2">
              €{totalRaised.toLocaleString('nl-NL')}
            </div>
            <div className="text-slate-600">Totaal opgehaald</div>
          </div>
          <div className="bg-white/80 rounded-2xl p-6 backdrop-blur-sm border border-slate-200">
            <div className="text-3xl font-bold text-gold mb-2">
              {lightsActivated}
            </div>
            <div className="text-slate-600">Lichten aan</div>
          </div>
          <div className="bg-white/80 rounded-2xl p-6 backdrop-blur-sm border border-slate-200">
            <div className="text-3xl font-bold text-gold mb-2">
              {percentage}%
            </div>
            <div className="text-slate-600">Naar doel</div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;

