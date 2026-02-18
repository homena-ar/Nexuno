const get_io_root = () => {
    if ( document.body.scrollbar === undefined ) return null;
    return document.querySelector('.os-viewport');
}

const progess_handler = (el) => {
    if ( document.body.scrollbar === undefined ) return;
    el = el.querySelector('.elementor-progress-bar');
    let value = el.dataset.max;
    if ( value === undefined || value === null ) return;
    el.style.setProperty('width', value + '%');
}

const io_handler = ( entries, observer ) => {
    entries.forEach(entry => {
        // progess bar
        if ( entry.target.matches('.elementor-progress-wrapper') && entry.isIntersecting ) {
            progess_handler( entry.target );
        }
    })
}

const register_observers = ( observer ) => {
    const selectors = [ '.elementor-progress-wrapper' ];

    selectors.forEach(selector => {
        let els = document.querySelectorAll(selector);     
        if ( els.length < 1 ) return;
        els.forEach(el => {
            observer.observe(el);
        });
    });

}

export const init_io = () => {
    let observer = new IntersectionObserver(io_handler, {
        root: get_io_root(),
        rootMargin: '0px',
        threshold: 1.0
    });

    register_observers( observer );

}