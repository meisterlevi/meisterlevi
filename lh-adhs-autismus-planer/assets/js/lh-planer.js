(function () {
  const root = document.querySelector('[data-lh-planer]');
  if (!root) return;

  const form = root.querySelector('[data-lh-planer-form]');
  if (!form) return;

  const steps = Array.from(form.querySelectorAll('[data-lh-step]'));
  const btnNext = form.querySelector('[data-lh-next]');
  const btnPrev = form.querySelector('[data-lh-prev]');
  const btnSubmit = form.querySelector('[data-lh-submit]');
  const stepCurrent = form.querySelector('[data-lh-step-current]');

  let index = 0;

  const updateStep = () => {
    steps.forEach((step, i) => step.classList.toggle('is-active', i === index));
    if (stepCurrent) stepCurrent.textContent = String(index + 1);
    if (btnPrev) btnPrev.style.display = index === 0 ? 'none' : 'inline-block';
    if (btnNext) btnNext.style.display = index === steps.length - 1 ? 'none' : 'inline-block';
    if (btnSubmit) btnSubmit.style.display = index === steps.length - 1 ? 'inline-block' : 'none';
  };

  const validateStep = () => {
    const activeStep = steps[index];
    if (!activeStep) return true;

    const requiredRadios = activeStep.querySelectorAll('input[type="radio"][required]');
    if (requiredRadios.length > 0) {
      const name = requiredRadios[0].name;
      const chosen = activeStep.querySelector('input[name="' + name + '"]:checked');
      if (!chosen) return false;
    }

    if (activeStep.dataset.lhStep === '4') {
      const checked = activeStep.querySelectorAll('input[type="checkbox"]:checked').length;
      if (checked < 3 || checked > 5) return false;
    }

    return true;
  };

  btnNext?.addEventListener('click', () => {
    if (!validateStep()) {
      window.alert('Bitte Auswahl in diesem Schritt vervollständigen (Schritt 4: 3 bis 5 Optionen).');
      return;
    }
    index = Math.min(index + 1, steps.length - 1);
    updateStep();
  });

  btnPrev?.addEventListener('click', () => {
    index = Math.max(index - 1, 0);
    updateStep();
  });

  updateStep();
})();
