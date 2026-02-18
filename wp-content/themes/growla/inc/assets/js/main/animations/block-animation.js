import { getAbsoluteElementHeight, getStyle } from '../utils/utils';

export const blockAnimationHandler = (e) => {
    const block = e.target.closest('.growla-block-slide-2');

    const animatingClass = 'is-animating';
    const animatedClass = 'animated-state';

    const isAnimating = block.classList.contains(animatingClass);
    if (isAnimating) return;

    const isNormalState = ! block.classList.contains(animatedClass);
    const isAnimatedState = block.classList.contains(animatedClass);


    const contentWrapper = block.querySelector('.growla-block-slide-2--content-wrapper');
    const firstContent = block.querySelector('.growla-block-slide-2--content-inner');
    const secondContent = block.querySelector('.growla-block-slide-2--content-inner-2');
    const firstIcon = block.querySelector('.growla-block-slide-2--icon-top');
    const secondIcon = block.querySelector('.growla-block-slide-2--icon-bottom');

    const normalIcon = block.querySelector('.normal-icon');
    const activeIcon = block.querySelector('.active-icon');

    const border = block.querySelector('.growla-block-slide-2--content-icon-border');
    const primaryColor = getStyle(block, '--outline-color');
    
    const isRTL = document.documentElement.dir === 'rtl';

    const onStart = () => block.classList.add(animatingClass);

    if (isNormalState) {
        const secondContentHeight = getAbsoluteElementHeight(secondContent);
        const tl = gsap.timeline({
            onStart: onStart,
            onComplete: () => {
                block.classList.remove(animatingClass)
                block.classList.add(animatedClass)
            },
            ease: 'power4.out',
        });

        tl.set(secondContent, { y: 0 });
        tl.to(contentWrapper, { height: secondContentHeight, onComplete: () => contentWrapper.style.height = 'auto' });
        tl.to(firstContent, { autoAlpha: 0, y: -25, position: 'absolute', duration: .1 }, '0');
        tl.to(firstIcon, { xPercent: isRTL ? -100 : 100, ease: 'elastic.out(1,1)', }, '0');
        tl.to(secondIcon, { x: 0, ease: 'elastic.out(1,1)', }, '0' );
        tl.to(border, { width: border.offsetWidth - 80, ease: 'elastic.out(1,1)' }, '0' );
        tl.to(normalIcon, { autoAlpha: 0 }, '0');
        tl.to(activeIcon, { autoAlpha: 1 }, '0');
        tl.to(block, { outlineColor: primaryColor }, '0');
        tl.to(secondContent, { autoAlpha: 1, position: 'relative' }, .3 );

    } else if (isAnimatedState) {
        const firstContentHeight = getAbsoluteElementHeight(firstContent);
        const tl = gsap.timeline({
            onStart: onStart,
            onComplete: () => {
                block.classList.remove(animatingClass)
                block.classList.remove(animatedClass)
            }
        });

        tl.set(firstContent, { y: 0 });
        tl.to(contentWrapper, { height: firstContentHeight, onComplete: () => contentWrapper.style.height = 'auto' });
        tl.to(secondContent, { autoAlpha: 0, y: 25, position: 'absolute' }, '0');
        tl.to(firstIcon, { xPercent: 0, ease: 'elastic.out(1,1)' }, '0');
        tl.to(secondIcon, { x: isRTL ? '100%' : '-100%', ease: 'elastic.out(1,1)' }, '0' );
        tl.to(border, { width: '100%', ease: 'elastic.out(1,1)' }, '0' );
        tl.to(activeIcon, { autoAlpha: 0 }, '0');
        tl.to(normalIcon, { autoAlpha: 1 }, '0');
        tl.to(block, { outlineColor: 'transparent' }, '0');
        tl.to(firstContent, { autoAlpha: 1, position: 'relative' }, .3 );
    }
};