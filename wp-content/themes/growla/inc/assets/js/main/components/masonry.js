// masonry can be initialized through HTML using data-masonry
// the reason for custom initialization is to assign the masonry object to
// the element, so it can be accessed later
export const masonry_handler = () => {
    let rows = document.querySelectorAll('.row-masonry');

    rows.forEach(row => {
        let options = row.dataset.masonryOptions;
        options = JSON.parse( options );
        row.masonry = new Masonry( row, options);
    });
}

export const masonry_layout = (el) => {
    let row = el.closest('.row-masonry');
    if ( 
        row === undefined || 
        row === null || 
        row.masonry === undefined || 
        row.masonry === null 
    ) return;
    row.masonry.layout();
}