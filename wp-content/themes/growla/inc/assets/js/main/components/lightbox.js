const elementor_lighbox_override = () => {
    let elem_lightbox = document.querySelector('.elementor-lightbox');
    if ( elem_lightbox == null ) return;
    elem_lightbox.parentNode.removeChild( elem_lightbox );
}

export const lightbox_handler = () => {
    if ( typeof GLightbox === 'undefined' ) return;
    // instantiate the lightbox
    let lightbox = GLightbox({
        selector: '.growla-glightbox'
    });

    lightbox.on('open', elementor_lighbox_override);
    lightbox.on('close', elementor_lighbox_override);
}