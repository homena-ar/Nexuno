import { trigger_ib } from '../animations/image-box';

export const hs1_handler = () => {
    let els = document.querySelectorAll('.hs1');
    if ( els.length < 1 ) return;
    els.forEach( el => {
        let box_slider = el.querySelector('.hs1-box .swiper-container');
        if ( box_slider === null || box_slider === undefined ) return;
        let content_slider = el.querySelector('.hs1-content .swiper-container');
        if ( content_slider === null || content_slider === undefined ) return;

        // bind the two sliders together, so they are always on the same slide
        box_slider.swiper.controller.control = content_slider.swiper;
        content_slider.swiper.controller.control = box_slider.swiper;

        // display the content of the active slide image box
        let default_slide = box_slider.querySelector('.swiper-slide-active');
        trigger_ib( default_slide );

        // listen for slide change event
        box_slider.swiper.on('slideChange', () => {
            
            let active_slide = box_slider.swiper.slides[ box_slider.swiper.activeIndex ];
            let prev_slide = box_slider.swiper.slides[ box_slider.swiper.previousIndex ];
    
            // toggle the animation state of the previous and active slides
            box_slider.style.setProperty('min-height', prev_slide.offsetHeight + 'px' );
            trigger_ib( prev_slide );
            trigger_ib( active_slide );
            box_slider.style.setProperty('min-height', active_slide.offsetHeight + 'px' );

        });
        
    });
};

export const hs1_height_resize_handler = () => {
    let els = document.querySelectorAll('.hs1-box');
    if ( els.length < 1 ) return;
    els.forEach( el => {
        el.style.setProperty('height', 'auto' );
    });
}

export const hs1_height_handler = (el, type) => {
    let parent = el.closest('.hs1-box');
    if ( parent === undefined || parent === null ) return;
    let el_height = el.closest('.image-box').offsetHeight;

    if ( type === 'update' ) {
        let parent_height = parent.offsetHeight;
        
        if ( el_height >= parent_height ) {
            parent.style.setProperty('height', el_height + 'px');
        } else {
            parent.style.setProperty('height', parent_height + 'px');
        }
    } else if ( type === 'complete' ) {
        parent.style.setProperty('height', el_height + 'px');
    }


}