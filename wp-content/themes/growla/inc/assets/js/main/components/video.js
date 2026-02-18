export const video_overlay_handler = ( wrapper ) => {
    let el = wrapper.querySelector('.growla-overlay-container');
    if ( el == null ) return;
    el.style.setProperty('display', 'none');
}