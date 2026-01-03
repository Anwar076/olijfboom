import React from 'react';
import logo from '../logo.png';

const Footer: React.FC = () => {
  return (
    <footer className="py-12 px-4 border-t border-slate-200">
      <div className="container mx-auto max-w-6xl">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <img
              src={logo}
              alt="Islamitisch Centrum Barendrecht"
              className="h-12 w-auto mb-4"
            />
            <p className="text-slate-600 text-sm">
              Samen bouwen we aan een sterke en bloeiende gemeenschap.
            </p>
          </div>
          <div>
            <h4 className="font-semibold text-slate-700 mb-4">Contact</h4>
            <p className="text-slate-600 text-sm mb-2">Email: info@icb-barendrecht.nl</p>
            <p className="text-slate-600 text-sm mb-2">Tel: 0180 - XXX XXX</p>
            <p className="text-slate-600 text-sm">Adres: [Adres], Barendrecht</p>
          </div>
          <div>
            <h4 className="font-semibold text-slate-700 mb-4">Informatie</h4>
            <p className="text-slate-600 text-sm">
              Alle donaties gaan rechtstreeks naar het centrum en worden gebruikt voor de doelen zoals beschreven.
            </p>
          </div>
        </div>
        <div className="pt-8 border-t border-slate-200 text-center text-sm text-slate-500">
          <p>© {new Date().getFullYear()} Islamitisch Centrum Barendrecht. Alle rechten voorbehouden.</p>
          <p className="mt-2">
            Deze website is ontwikkeld voor de Olijfboom van Licht campagne.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;

