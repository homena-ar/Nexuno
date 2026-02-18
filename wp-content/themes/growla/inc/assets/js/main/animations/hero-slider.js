import { linesAnimationHandler } from './lines-animation';

const animateIllustration = (illustration, isActive) => {
    if (illustration == null) return;
    
    if (isActive) {
        switch (illustration.className) {
            case 'illustration-boxes-1':

                const elements = illustration.querySelectorAll('.illustration-boxes-1-grid');
                if (elements.length > 0) {
                    elements.forEach(element => {
                        gsap.to(element.querySelectorAll('.illustration-boxes-1-row'), { autoAlpha: 1, stagger: .1, overwrite: true });
                    })
                }
                break;
            case 'illustration-lines':
                linesAnimationHandler(false);
                break;
            default:
                break;
        }
    } else {
        switch (illustration.className) {
            case 'illustration-boxes-1':
                gsap.to(illustration.querySelectorAll('.illustration-boxes-1-row'), { autoAlpha: 0, stagger: .1 });
                break;
            case 'illustration-lines':
                linesAnimationHandler(true);
            default:
                break;
        }
    }
}

const animateSliderContent = (swiper) => {
    const activeSlide = swiper.slides[swiper.activeIndex];
    swiper.slides.forEach(slide => {
        const content = slide.querySelectorAll('.growla-animate-slide');
        const isActive = slide === activeSlide;
        const illustration = slide.querySelector('.hero-illustration > div');

        if (isActive) {
            gsap.to(content, { autoAlpha: 1, y: 0, stagger: .1 });
        } else {
            gsap.to(content, { autoAlpha: 0, y: 100 });
        }

        animateIllustration(illustration, isActive);
    });     
}

export const heroSlideAnimationHandler = () => {
    const elements = document.querySelectorAll('.hero-slider .slider');
    if (elements.length < 1) return;
    elements. forEach(element => {
        if (element.swiper == null) return;
        element.swiper.on('slideChangeTransitionEnd', animateSliderContent)
        animateSliderContent(element.swiper);
    })
}

export const pageHeaderAnimationHandler = () => {
    const element = document.querySelector('.page-header-illustration > div');
    if (element == null) return;
    animateIllustration(element, true);
}