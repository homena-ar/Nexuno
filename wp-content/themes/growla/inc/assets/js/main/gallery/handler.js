export const gallery_handler = () => {
    if ( typeof Isotope === 'undefined' ) return;
    let gallery_rows = document.querySelectorAll('.gallery');
    gallery_rows.forEach(gallery_row => {
        gallery_row.isotope = new Isotope( gallery_row.querySelector('.gallery-row'), {
            itemSelector: '.gallery-item-wrapper',
            layoutMode: 'fitRows'
        });
    });

    // handle change event for select
    let selects = document.querySelectorAll('.gallery .filter-select');
    if ( selects == null ) return;

    selects.forEach(select => {
        select.addEventListener('change', (e) => {
            let gallery = select.closest('.gallery');
            gallery.isotope.arrange({ filter: e.target.value });
        });
    });
}

export const gallery_layout_handler = (e) => {
    if ( typeof Isotope === 'undefined' ) return;
    e.preventDefault();
    let target = e.target;

    if ( target.classList.contains('selected') ) return;

    // remove selected class from ther elements
    target.closest('.filter').querySelector('.selected').classList.remove('selected');

    let grid = target.closest('.gallery').isotope;

    // add class
    target.classList.add('selected');

    grid.arrange({ filter: target.dataset.filter });
}