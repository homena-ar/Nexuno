const backToTopElement = document.querySelector('.back-to-top');

export const backToTopHandler = () => {
    document.body.lenis.scrollTo(0, {
        duration: 2,
        easing: (x) => x === 0
        ? 0
        : x === 1
        ? 1
        : x < 0.5 ? Math.pow(2, 20 * x - 10) / 2
        : (2 - Math.pow(2, -20 * x + 10)) / 2
    });
}

export const backToTopScrollListener = () => {
    if ( backToTopElement == null ) return;
    let y_pos = window.scrollY;

    if ( y_pos > 200 ) {
        backToTopElement.classList.add('scrolled');
    } else {
        backToTopElement.classList.remove('scrolled');
    }
}