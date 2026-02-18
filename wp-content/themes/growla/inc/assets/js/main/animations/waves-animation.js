export const wavesAnimationHandler = () => {
    const elements = document.querySelectorAll('.waves-illustration');
    if (elements.length < 1) return;
    elements.forEach((element) => {
        const svgOriginal = element.querySelector('.first-wave');
        const svgClone = element.querySelector('.second-wave');
        const isRTL = document.documentElement.dir === 'rtl';

        // total width / numbers of pixels traveled in a second
        const duration = svgOriginal.getBoundingClientRect().width / 50;

        // GSAP timeline for seamless looping
        const tl = gsap.timeline({
            repeat: -1, // Infinite loop
            defaults: { ease: 'none', duration: duration },
        });

        // Animation for the original SVG
        tl.fromTo(svgOriginal, { x: 0 }, { x: '100%' }, 0);
        // Animation for the clone SVG, starting immediately after the original
        if (isRTL) {
            tl.fromTo(svgClone, { x: '0%' }, { x: '100%' }, 0);
        } else {
            tl.fromTo(svgClone, { x: '-200%' }, { x: '-100%' }, 0);
        }

        return false;
    });
};
