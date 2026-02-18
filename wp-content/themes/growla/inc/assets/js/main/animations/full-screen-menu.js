export const fullScreenAnimation = (e) => {
    const outerContainer = e.target.closest('.growla-full-screen-nav');
    const container = outerContainer.querySelector('.growla-full-screen-nav-content');
    const containerInner = outerContainer.querySelector('.growla-full-screen-nav-content-inner');
    const trigger = e.target.closest('.growla-full-screen-nav-trigger');
    const contentWrapper = container.querySelector('.growla-full-screen-nav-content-container');
    const image = container.querySelector('.growla-full-screen-nav-content-image');

    const animatingClass = 'is-animating';
    const animatedClass = 'animated-state';

    const isAnimating = outerContainer.classList.contains(animatingClass);
    const isAnimated = outerContainer.classList.contains(animatedClass);

    const isRTL = document.documentElement.dir === 'rtl';

    if (isAnimating) return;

    if (!isAnimated) {
        const tl = gsap.timeline({
            onStart: () => {
                outerContainer.classList.add(isAnimating);
                trigger.classList.add(animatedClass);
            },
            onComplete: () => {
                outerContainer.classList.remove(isAnimating);
                outerContainer.classList.add(animatedClass);
            },
            ease: 'power4.out',
        });

        let imageAnim = { x: 0, autoAlpha: 1 };

        if (isRTL) {
            imageAnim = { xPercent: 0, autoAlpha: 1 };
        }

        tl.to(container, { x: 0, duration: 0.25 });
        tl.to(containerInner, { x: 0 });
        tl.to(contentWrapper, { autoAlpha: 1, y: 0 });
        tl.to(image, imageAnim, '<');
    } else {
        const tl = gsap.timeline({
            onStart: () => {
                outerContainer.classList.add(isAnimating);
                trigger.classList.remove(animatedClass);
            },
            onComplete: () => {
                outerContainer.classList.remove(isAnimating);
                outerContainer.classList.remove(animatedClass);
            },
            ease: 'power4.out',
        });

        let imageAnim = { x: '50%', autoAlpha: 0 };

        if (isRTL) {
            imageAnim = { xPercent: -50, autoAlpha: 0 };
        }

        tl.to(contentWrapper, { autoAlpha: 0, y: 25 });
        tl.to(image, imageAnim, '<');
        tl.to(containerInner, { x: '-100%', duration: 0.25 });
        tl.to(container, { x: '-100%' });
    }
};

export const dropdownHandler = (e) => {
    e.preventDefault();

    const animatingClass = 'is-animating';
    const animatedClass = 'animated';

    const li = e.target.closest('li');
    const menu = li.closest('ul');
    const submenu = li.querySelector('.sub-menu');
    const activeSubmenus = menu.querySelectorAll('li.' + animatedClass);

    const isAnimating = li.classList.contains(animatingClass);
    const isAnimated = li.classList.contains(animatedClass);

    if (isAnimating) return;

    if (!isAnimated) {
        if (activeSubmenus.length > 0) {
            activeSubmenus.forEach((activeSubmenu) => {
                const menu = activeSubmenu.querySelector('.sub-menu');
                gsap.to(menu, {
                    autoAlpha: 0,
                    y: 25,
                    onStart: () => {
                        activeSubmenu.classList.add(animatingClass);
                        activeSubmenu.classList.remove(animatedClass);
                    },
                    onComplete: () => {
                        activeSubmenu.classList.remove(animatingClass);
                    },
                });
            });
        }

        const tl = gsap.timeline({
            onStart: () => {
                li.classList.add(animatingClass);
                li.classList.add(animatedClass);
            },
            onComplete: () => {
                li.classList.remove(animatingClass);
            },
        });
        tl.to(submenu, { autoAlpha: 1, y: 0 });
    } else {
        const tl = gsap.timeline({
            onStart: () => {
                li.classList.add(animatingClass);
                li.classList.remove(animatedClass);
            },
            onComplete: () => {
                li.classList.remove(animatingClass);
            },
        });
        tl.to(submenu, { autoAlpha: 0, y: 25 });
    }
};
