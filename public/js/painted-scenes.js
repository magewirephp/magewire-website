(() => {
    const scenes = new Map([...document.querySelectorAll('[data-painted-scene]')].map(scene => [scene, false]));
    const controls = [...document.querySelectorAll('[data-motion-toggle]')];
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let paused = false;

    function updateMotion() {
        scenes.forEach((visible, scene) => {
            scene.classList.toggle('is-animated', visible && !paused && !reducedMotion.matches && !document.hidden);
        });
        controls.forEach(button => {
            button.hidden = reducedMotion.matches;
            button.setAttribute('aria-pressed', String(paused));
            const description = paused ? 'Play background animation' : 'Pause background animation';
            button.setAttribute('aria-label', description);
            button.title = description;
            const label = button.querySelector('[data-motion-label]');
            if (label) label.textContent = paused ? 'Play animation' : 'Pause animation';
        });
    }

    controls.forEach(button => button.addEventListener('click', () => {
        paused = !paused;
        updateMotion();
    }));
    reducedMotion.addEventListener('change', updateMotion);
    document.addEventListener('visibilitychange', updateMotion);

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => scenes.set(entry.target, entry.isIntersecting));
        updateMotion();
    });
    scenes.forEach((visible, scene) => observer.observe(scene));
    updateMotion();

    const header = document.getElementById('site-nav');
    function updateHeader() {
        header.classList.toggle('nav-solid', window.scrollY > 12);
    }
    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();
})();
