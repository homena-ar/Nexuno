// Intersection Observer
const intersectionHandler = (entries, observer) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const valueElement = entry.target.querySelector('.growla-counter-value');
        const value = valueElement.dataset.value;

        if ( value == null ) return;
        gsap.to(valueElement, { innerHTML: value, delay: .25, duration: 1, snap: { innerHTML: 1 } });

        observer.unobserve(entry.target);
    });
};

const counterHandler = () => {
    const elements = document.querySelectorAll('.growla-counter');
    if ( elements.length < 1 ) return;

    const observer = new IntersectionObserver(intersectionHandler);

    elements.forEach(element => {
        observer.observe(element);
    })
}

export default counterHandler;