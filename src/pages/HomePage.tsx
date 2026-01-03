import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Header from '../components/Header';
import Hero from '../components/Hero';
import OliveTreeSection from '../components/OliveTreeSection';
import GoalCards from '../components/GoalCards';
import SponsorLevels from '../components/SponsorLevels';
import Teams from '../components/Teams';
import Donate from '../components/Donate';
import FAQ from '../components/FAQ';
import Footer from '../components/Footer';
import { API_URL } from '../context/AuthContext';

const HomePage: React.FC = () => {
  const navigate = useNavigate();
  const [stats, setStats] = useState({
    totalRaised: 0,
    lightsActivated: 0,
    totalLights: 100,
    progressPercentage: 0
  });

  useEffect(() => {
    fetchStats();
  }, []);

  const fetchStats = async () => {
    try {
      const response = await fetch(`${API_URL}/api/stats`);
      if (response.ok) {
        const data = await response.json();
        setStats(data);
      }
    } catch (error) {
      console.error('Failed to fetch stats:', error);
    }
  };

  const scrollToSection = (id: string) => {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
  };

  return (
    <div className="min-h-screen bg-slate-50">
      <Header />
      <Hero 
        totalRaised={stats.totalRaised}
        lightsActivated={stats.lightsActivated}
        progressPercentage={stats.progressPercentage}
      />
      <OliveTreeSection 
        lightsActivated={stats.lightsActivated}
        totalLights={100}
      />
      <GoalCards />
      <SponsorLevels />
      <Teams />
      <Donate />
      <FAQ />
      <Footer />
    </div>
  );
};

export default HomePage;

