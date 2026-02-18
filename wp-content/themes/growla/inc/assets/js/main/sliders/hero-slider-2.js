export const hs2_handler = () => {
    let els = document.querySelectorAll('.hs2');

    els.forEach( el => {
        let image_slider = el.querySelector('.hs2-image .swiper-container');
        let content_slider = el.querySelector('.hs2-content .swiper-container');

        // bind the two sliders together, so they are always on the same slide
        image_slider.swiper.controller.control = content_slider.swiper;
        content_slider.swiper.controller.control = image_slider.swiper;

        // display the content of the active slide image box
        let active_slide = content_slider.swiper.slides[ content_slider.swiper.activeIndex ];
        gsap.to(
            active_slide.querySelector('.content'),
            {
                'clip-path': 'polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)',
                autoAlpha: 1
            }
        );

        // listen for slide change event
        content_slider.swiper.on('slideChange', () => {     
            let active_slide = content_slider.swiper.slides[ content_slider.swiper.activeIndex ];
            let previous_slide = content_slider.swiper.slides[ content_slider.swiper.previousIndex ];
            
            // toggle the animation state of the previous and active slides
            let tl = gsap.timeline();

            tl.to(
                previous_slide.querySelector('.content'),
                {
                    'clip-path': 'polygon(0% 100%, 100% 100%, 100% 100%, 0% 100%)',
                    autoAlpha: 0
                }
            );

            tl.to(
                active_slide.querySelector('.content'),
                {
                    'clip-path': 'polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)',
                    autoAlpha: 1
                }
            );


        });

    } )

}