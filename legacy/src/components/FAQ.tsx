import React, { useState } from 'react';

interface FAQItem {
  question: string;
  answer: string;
}

const FAQ: React.FC = () => {
  const [openIndex, setOpenIndex] = useState<number | null>(0);

  const faqs: FAQItem[] = [
    {
      question: 'Waar gaat het geld naartoe?',
      answer: 'Het opgehaalde geld wordt gebruikt om de lening van het centrum af te lossen, te investeren in educatieve programma\'s voor jongeren, en om de gemeenschap verder te versterken.',
    },
    {
      question: 'Kan ik als bedrijf doneren?',
      answer: 'Ja, bedrijven zijn van harte welkom om te doneren. Neem contact met ons op voor meer informatie over zakelijke donaties en mogelijke voordelen.',
    },
    {
      question: 'Krijg ik een bevestiging?',
      answer: 'Ja, na uw donatie ontvangt u automatisch een bevestigingsmail met de details van uw donatie. U kunt deze gebruiken voor uw administratie.',
    },
    {
      question: 'Kan ik een team starten?',
      answer: 'Ja! U kunt een eigen team oprichten en anderen uitnodigen om samen donaties te verzamelen. Dit maakt het leuker en effectiever om het doel te bereiken.',
    },
    {
      question: 'Wat betekent 1 licht?',
      answer: 'Elk licht vertegenwoordigt €10.000. Wanneer we €10.000 hebben opgehaald, wordt er een licht op de olijfboom geactiveerd. We hebben 100 lichten nodig om ons doel van €1.000.000 te bereiken.',
    },
  ];

  return (
    <section id="faq" className="py-20 px-4 bg-slate-100/60">
      <div className="container mx-auto max-w-3xl">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4 title-gradient">Veelgestelde Vragen</h2>
        </div>

        <div className="space-y-4">
          {faqs.map((faq, index) => (
            <div
              key={index}
              className="bg-white/80 rounded-xl border border-slate-200 backdrop-blur-sm overflow-hidden"
            >
              <button
                onClick={() => setOpenIndex(openIndex === index ? null : index)}
                className="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-white/80 transition-colors"
              >
                <span className="font-semibold text-slate-800">{faq.question}</span>
                <span className="text-gold text-xl ml-4">
                  {openIndex === index ? '−' : '+'}
                </span>
              </button>
              {openIndex === index && (
                <div className="px-6 pb-4 text-slate-600 leading-relaxed">
                  {faq.answer}
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default FAQ;

