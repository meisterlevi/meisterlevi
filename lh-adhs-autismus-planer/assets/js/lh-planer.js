(function () {
  function initPlaner() {
    var root = document.querySelector('[data-lh-planer]');
    if (!root) {
      return;
    }

    var form = root.querySelector('[data-lh-planer-form]');
    if (!form) {
      return;
    }

    var steps = Array.prototype.slice.call(form.querySelectorAll('[data-lh-step]'));
    var btnNext = form.querySelector('[data-lh-next]');
    var btnPrev = form.querySelector('[data-lh-prev]');
    var btnSubmit = form.querySelector('[data-lh-submit]');
    var stepCurrent = form.querySelector('[data-lh-step-current]');

    if (!steps.length) {
      return;
    }

    var index = 0;
    root.classList.add('is-enhanced');

    function updateStep() {
      var i;
      for (i = 0; i < steps.length; i++) {
        var isActive = i === index;
        steps[i].classList.toggle('is-active', isActive);
        steps[i].setAttribute('aria-hidden', isActive ? 'false' : 'true');
      }

      if (stepCurrent) {
        stepCurrent.textContent = String(index + 1);
      }

      if (btnPrev) {
        btnPrev.style.display = index === 0 ? 'none' : 'inline-block';
      }

      if (btnNext) {
        btnNext.style.display = index === steps.length - 1 ? 'none' : 'inline-block';
      }

      if (btnSubmit) {
        btnSubmit.style.display = index === steps.length - 1 ? 'inline-block' : 'none';
      }
    }

    function validateStep() {
      var activeStep = steps[index];
      if (!activeStep) {
        return true;
      }

      var requiredRadios = activeStep.querySelectorAll('input[type="radio"][required]');
      if (requiredRadios.length > 0) {
        var name = requiredRadios[0].name;
        var chosen = activeStep.querySelector('input[name="' + name + '"]:checked');
        if (!chosen) {
          return false;
        }
      }

      if (activeStep.getAttribute('data-lh-step') === '4') {
        var checked = activeStep.querySelectorAll('input[type="checkbox"]:checked').length;
        if (checked < 3 || checked > 5) {
          return false;
        }
      }

      return true;
    }

    if (btnNext) {
      btnNext.addEventListener('click', function () {
        if (!validateStep()) {
          window.alert('Bitte Auswahl in diesem Schritt vervollständigen (Schritt 4: 3 bis 5 Optionen).');
          return;
        }

        index = Math.min(index + 1, steps.length - 1);
        updateStep();
      });
    }

    if (btnPrev) {
      btnPrev.addEventListener('click', function () {
        index = Math.max(index - 1, 0);
        updateStep();
      });
    }

    updateStep();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPlaner);
  } else {
    initPlaner();
  }
})();
