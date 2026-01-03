import React from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const Header: React.FC = () => {
  const location = useLocation();
  const navigate = useNavigate();
  const { user } = useAuth();
  const isHomePage = location.pathname === '/';

  const scrollToSection = (id: string) => {
    if (isHomePage) {
      document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
    } else {
      navigate(`/#${id}`);
    }
  };

  return (
    <header className="fixed top-0 left-0 right-0 z-50 bg-dark-bg/95 backdrop-blur-sm border-b border-gray-800">
      <div className="container mx-auto px-4 py-4">
        <div className="flex items-center justify-between">
          <Link to="/" className="text-2xl font-bold text-gold hover:opacity-80 transition-opacity">
            ICB
          </Link>
          
          {isHomePage && (
            <nav className="hidden md:flex items-center gap-8">
              <button onClick={() => scrollToSection('doel')} className="text-gray-300 hover:text-gold transition-colors">
                Doel
              </button>
              <button onClick={() => scrollToSection('boom')} className="text-gray-300 hover:text-gold transition-colors">
                Boom
              </button>
              <button onClick={() => scrollToSection('teams')} className="text-gray-300 hover:text-gold transition-colors">
                Teams
              </button>
              <button onClick={() => scrollToSection('doneer')} className="text-gray-300 hover:text-gold transition-colors">
                Doneer
              </button>
              <button onClick={() => scrollToSection('faq')} className="text-gray-300 hover:text-gold transition-colors">
                FAQ
              </button>
            </nav>
          )}

          <div className="flex items-center gap-4">
            {user ? (
              <Link
                to="/dashboard"
                className="text-gray-300 hover:text-gold transition-colors"
              >
                Dashboard
              </Link>
            ) : (
              <>
                {isHomePage && (
                  <button
                    onClick={() => scrollToSection('doneer')}
                    className="hidden sm:block bg-gold text-dark-bg px-6 py-2 rounded-full font-semibold hover:bg-gold-dark transition-colors"
                  >
                    Doneer nu
                  </button>
                )}
                <Link
                  to="/login"
                  className="text-gray-300 hover:text-gold transition-colors"
                >
                  Inloggen
                </Link>
              </>
            )}
          </div>
        </div>
      </div>
    </header>
  );
};

export default Header;

