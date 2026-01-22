import React, { useEffect, useState } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import logo from '../logo.png';

const Header: React.FC = () => {
  const location = useLocation();
  const navigate = useNavigate();
  const { user } = useAuth();
  const isHomePage = location.pathname === '/';
  const [activeSection, setActiveSection] = useState('');

  const scrollToSection = (id: string) => {
    if (isHomePage) {
      document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
      setActiveSection(id);
    } else {
      navigate(`/#${id}`);
    }
  };

  useEffect(() => {
    if (!isHomePage) return;
    const sectionIds = ['doel', 'boom', 'teams', 'doneer', 'faq'];
    const elements = sectionIds
      .map((id) => document.getElementById(id))
      .filter((el): el is HTMLElement => Boolean(el));

    if (elements.length === 0) return;

    const observer = new IntersectionObserver(
      (entries) => {
        const visible = entries
          .filter((entry) => entry.isIntersecting)
          .sort((a, b) => b.intersectionRatio - a.intersectionRatio);
        if (visible.length > 0) {
          setActiveSection(visible[0].target.id);
        }
      },
      {
        rootMargin: '-30% 0px -60% 0px',
        threshold: [0.2, 0.4, 0.6],
      }
    );

    elements.forEach((el) => observer.observe(el));

    return () => {
      observer.disconnect();
    };
  }, [isHomePage]);

  useEffect(() => {
    if (!isHomePage) return;
    const hash = location.hash.replace('#', '');
    if (hash) {
      setActiveSection(hash);
    }
  }, [isHomePage, location.hash]);

  const navButtonClass = (id: string) =>
    `font-semibold transition-opacity ${
      activeSection === id ? 'text-gold opacity-100 underline' : 'text-white opacity-90 hover:opacity-100'
    }`;

  return (
    <>
      <header className="bg-slate-50/95 backdrop-blur-sm border-b border-slate-200">
        <div className="container mx-auto px-4 py-4">
          <div className="flex items-center justify-between gap-6">
            <Link to="/" className="hover:opacity-80 transition-opacity">
              <img
                src={logo}
                alt="Islamitisch Centrum Barendrecht"
                className="h-auto w-auto max-w-[215px]"
              />
            </Link>

            <div className="flex items-center gap-4">
              {user ? (
                <Link
                  to="/dashboard"
                  className="btn btn-secondary"
                >
                  Dashboard
                </Link>
              ) : (
                <>
                  {isHomePage && (
                    <button
                      onClick={() => scrollToSection('doneer')}
                      className="hidden sm:inline-flex btn btn-primary"
                    >
                      Doneer nu
                    </button>
                  )}
                  <Link
                    to="/login"
                    className="btn btn-secondary"
                  >
                    Inloggen
                  </Link>
                </>
              )}
            </div>
          </div>
        </div>
      </header>

      {isHomePage && (
        <div className="nav-gradient sticky top-0 z-50">
          <div className="container mx-auto px-4">
            <nav className="flex flex-wrap items-center gap-6 py-4 text-white">
              <button onClick={() => scrollToSection('boom')} className={navButtonClass('boom')}>
                Boom
              </button>
              <button onClick={() => scrollToSection('doel')} className={navButtonClass('doel')}>
                Doel
              </button>
              <button onClick={() => scrollToSection('teams')} className={navButtonClass('teams')}>
                Teams
              </button>
              <button onClick={() => scrollToSection('doneer')} className={navButtonClass('doneer')}>
                Doneer
              </button>
              <button onClick={() => scrollToSection('faq')} className={navButtonClass('faq')}>
                FAQ
              </button>
            </nav>
          </div>
        </div>
      )}
    </>
  );
};

export default Header;
