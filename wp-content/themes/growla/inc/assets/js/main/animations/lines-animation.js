import { getStyle } from '../utils/utils';

const reverseState = (element) => gsap.set(element, { fill: 'transparent' });

export const linesAnimationHandler = (isReverse) => {
    const elements = document.querySelectorAll('.illustration-lines');

    if (elements.length < 1) return;
    elements.forEach(element => {

        const primaryColor = getStyle(element, '--color-primary');
        const secondaryColor = getStyle(element, '--color-secondary');

        const line1 = element.querySelector('.line-1');
        const line2 = element.querySelector('.line-2');
        const line3 = element.querySelector('.line-3');
        const line4 = element.querySelector('.line-4');

        if (element.animation != null) {
            if (isReverse) {
                element.animation.reverse(0);

                reverseState(line1);
                reverseState(line2);
                reverseState(line3);
                reverseState(line4);
            } else {
                element.animation.play(0)
            }
            return;
        }

        const tl = gsap.timeline({
            paused: true,
            defaults: {
                duration: 2
            }
        });

        tl.to(line1, { strokeDashoffset: 0, onComplete: () => gsap.to(line1, { fill: secondaryColor }) });
        tl.to(line2, { strokeDashoffset: 0, onComplete: () => gsap.to(line2, { fill: primaryColor }) }, 0);
        tl.to(line3, { strokeDashoffset: 0, onComplete: () => gsap.to(line3, { fill: primaryColor }) }, 0);
        tl.to(line4, { strokeDashoffset: 0, onComplete: () => gsap.to(line4, { fill: secondaryColor }) }, 0);

        element.animation = tl;

        if (isReverse) {
            element.animation.reverse(0);
        } else {
            element.animation.play(0);
        }
    });
}