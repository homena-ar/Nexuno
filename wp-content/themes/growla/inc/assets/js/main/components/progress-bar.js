// Intersection Observer
const intersectionHandler = (entries, observer) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;

        const bar = entry.target.querySelector('.growla-progress-bar--actual');
        const valueElement = entry.target.querySelector('.growla-progress-bar--value');
        const value = valueElement.dataset.value;
        const isRTL = document.documentElement.dir === 'rtl';

        if ( value == null ) return;

        if (isRTL) {
            gsap.fromTo(bar, { x: '100%' }, { x: (100 - parseInt(value)) + '%', duration: 1, delay: 0.25 });
        } else {
            gsap.to(bar, { x: (parseInt(value) - 100) + '%', duration: 1, delay: 0.25 });
        }
        gsap.to(valueElement, { innerHTML: value + '%', duration: 1, delay: .25, snap: { innerHTML: 1 } });

        observer.unobserve(entry.target);
    });
};

const progressBarHandler = () => {
    const elements = document.querySelectorAll('.growla-progress-bar');
    if ( elements.length < 1 ) return;

    const observer = new IntersectionObserver(intersectionHandler);

    elements.forEach(element => {
        observer.observe(element);
    })
}

export default progressBarHandler;