export const hamburger_handler = (e) => {
    let el = e.target.closest('.hamburger');
    el.classList.toggle('shown');
    document.querySelector('body.custom-scrollbar > .os-scrollbar-vertical')?.classList?.toggle('hamburger-shown');
};