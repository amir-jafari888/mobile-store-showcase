(() => {
    'use strict';

    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('[data-password-toggle]');

    if (!passwordInput || !toggleButton) {
        return;
    }

    toggleButton.addEventListener('click', () => {
        const shouldShowPassword = passwordInput.type === 'password';

        passwordInput.type = shouldShowPassword ? 'text' : 'password';
        toggleButton.setAttribute('aria-pressed', String(shouldShowPassword));
        toggleButton.setAttribute(
            'aria-label',
            shouldShowPassword ? 'پنهان کردن رمز عبور' : 'نمایش رمز عبور'
        );
        passwordInput.focus({ preventScroll: true });
    });
})();
