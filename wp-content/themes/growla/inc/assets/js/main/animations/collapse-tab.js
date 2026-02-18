export const collapseAnimationHandler = (e) => {
    if ( e.target.closest('a') ) return;
    if ( e.target.closest('.growla-collapse-content') ) return;
    const container = e.target.closest('.growla-collapse');

    const animatingClass = 'is-animating';
    const animatedClass = 'animated-state';

    const isAnimating = container.classList.contains(animatingClass);
    const isAnimatedState = container.classList.contains(animatedClass);

    if ( isAnimating ) return;

    const wrapper = container.querySelector('.growla-collapse-content-wrapper');
    const excerpt = container.querySelector('.growla-collapse-excerpt');
    const content = container.querySelector('.growla-collapse-content');
    const normalIcon = container.querySelector('.normal-icon');
    const activeIcon = container.querySelector('.active-icon');

    if ( ! isAnimatedState ) {
    const contentHeight = content.offsetHeight;

        const tl = gsap.timeline({
            onStart: () => {
                container.classList.add(isAnimating);
            },
            onComplete: () => {
                container.classList.remove(isAnimating);
                container.classList.add(animatedClass);

                wrapper.style.setProperty('height', 'auto');
            }
        });
    
        tl.to(wrapper, { height: contentHeight });
        tl.to(excerpt, { y: 25, autoAlpha: 0, position: 'absolute' }, '<');
        tl.to(content, { y: 0, autoAlpha: 1, position: 'static' });
        tl.to(normalIcon, { autoAlpha: 0 }, 0);
        tl.to(activeIcon, { autoAlpha: 1 }, 0);
    } else {
        const excerptHeight = excerpt.offsetHeight;

        const tl = gsap.timeline({
            onStart: () => {
                container.classList.add(isAnimating);
            },
            onComplete: () => {
                container.classList.remove(isAnimating);
                container.classList.remove(animatedClass);

                wrapper.style.setProperty('height', 'auto');
            }
        });
    
        tl.to(wrapper, { height: excerptHeight });
        tl.to(content, { y: 25, autoAlpha: 0, position: 'absolute' }, '<');
        tl.to(excerpt, { y: 0, autoAlpha: 1, position: 'static' });
        tl.to(activeIcon, { autoAlpha: 0 }, 0);
        tl.to(normalIcon, { autoAlpha: 1 }, 0);
    }

}