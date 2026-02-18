import { ELASTIC_EASING } from '../utils/constants';

export const teamAnimationHandler = (event) => {
    // if the user clicks on a button with the block then don't animate anything.
    if (event.target.closest('a')) return;

    const block = event.target.closest('.team-member-2');

    const animatingClass = 'is-animating';
    const animatedClass = 'animated-state';

    const isAnimating = block.classList.contains(animatingClass);
    if (isAnimating) return;

    const isNormalState = !block.classList.contains(animatedClass);
    const isAnimatedState = block.classList.contains(animatedClass);

    const wrapper = block.querySelector('.team-member-2-wrapper');
    const thumbnail = block.querySelector('.team-member-2-image');
    const smallThumbnail = block.querySelector(
        '.team-member-2-small-thumbnail'
    );
    const thumbnailImage = thumbnail.querySelector('img');
    const content = block.querySelector('.team-member-2-content');
    const firstInnerContent = block.querySelector(
        '.team-member-2-content-inner-1'
    );
    const name = firstInnerContent.querySelector('h4');
    const desgination = firstInnerContent.querySelector('p');
    const secondInnerContent = block.querySelector(
        '.team-member-2-content-inner-2'
    );
    const border = block.querySelector('.team-member-2-icon-border');

    const normalIcon = block.querySelector('.normal-icon');
    const activeIcon = block.querySelector('.active-icon');

    const onStart = () => block.classList.add(animatingClass);
    const wrapperOnComplete = () => {
        wrapper.style.setProperty('height', 'auto');
    };

    if (isNormalState) {
        wrapper.style.setProperty('min-height', 'initial');
        secondInnerContent.style.setProperty('position', 'static');
        const height = content.offsetHeight;
        secondInnerContent.style.setProperty('position', 'absolute');

        const tl = gsap.timeline({
            onStart: onStart,
            onComplete: () => {
                block.classList.remove(animatingClass);
                block.classList.add(animatedClass);
            },
            ease: 'power4.out',
        });

        tl.to(thumbnailImage, {
            x: '110%',
            ease: 'elastic.in(1,1)',
            duration: 0.5,
        });
        tl.to(smallThumbnail, { x: 0, ease: ELASTIC_EASING });
        tl.to(
            border,
            { width: 'var(--animated-border-width)', ease: ELASTIC_EASING },
            '<'
        );
        tl.to(wrapper, { height: height, onComplete: wrapperOnComplete }, '<');
        tl.to(thumbnail, { height: 0 }, '<');
        tl.to(normalIcon, { autoAlpha: 0 }, '<');
        tl.to(activeIcon, { autoAlpha: 1 }, '<');
        tl.to([name, desgination], { marginLeft: 0 }, 0);
        tl.to(secondInnerContent, { position: 'static', autoAlpha: 1, y: 0 });
    } else if (isAnimatedState) {
        const isRTL = document.documentElement.dir === 'rtl';
        const smallThumbnailMultiplyer = isRTL ? 1 : -1;

        thumbnail.style.setProperty('height', 353 + 'px');
        wrapper.style.setProperty('min-height', 'initial');
        secondInnerContent.style.setProperty('position', 'absolute');

        const wrapperHeight = wrapper.offsetHeight;

        thumbnail.style.setProperty('height', 0);
        secondInnerContent.style.setProperty('position', 'static');

        const tl = gsap.timeline({
            onStart: onStart,
            onComplete: () => {
                block.classList.remove(animatingClass);
                block.classList.remove(animatedClass);
            },
            ease: 'power4.out',
        });

        tl.to(secondInnerContent, {
            position: 'absolute',
            autoAlpha: 0,
            y: 30,
            duration: 0.15,
        });
        tl.to(thumbnail, { height: 353 }, '<');
        tl.to(
            wrapper,
            { height: wrapperHeight, onComplete: wrapperOnComplete },
            '<'
        );
        tl.to(thumbnailImage, { x: 0, ease: ELASTIC_EASING, duration: 0.5 });
        tl.to(
            smallThumbnail,
            {
                x: (smallThumbnail.offsetWidth + 17) * smallThumbnailMultiplyer,
                ease: 'elastic.in(1,1)',
            },
            '<-=.3'
        );
        tl.to(activeIcon, { autoAlpha: 0 }, '<');
        tl.to(normalIcon, { autoAlpha: 1 }, '<');
        tl.to(border, { width: '100%', ease: 'elastic.in(1,1)' }, '<');
        tl.to([name, desgination], { marginLeft: 'auto' }, '<');
    }
};
