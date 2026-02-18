export const offset_image = () => {
    // select all offset images
    let els = document.querySelectorAll('.r-image');

    // return if there are no elements
    if ( els.length < 1 ) return;

    // loop through each image
    els.forEach(el => {
        // if the extend attribute is empty then return
        let extend = el.dataset.extend;

        // select the inner container of the image
        let el_inner = el.querySelector('.r-image-inner');
        // get its distance from the left side of the screen
        let offset_x = el.getBoundingClientRect().x;
        
        if ( extend === '' ) {
            el_inner.style.width = el.offsetWidth + 'px';
            return;
        }

        // extending to the left
        if ( extend === 'left' ) {
            // add the width containing element to the distance from the screen 
            let width = el.offsetWidth + offset_x;

            // set the width and position of the containing inner element
            el_inner.style.width = width + 'px';
            el_inner.style.left = ( offset_x * -1 ) + 'px';
        } else if ( extend === 'right' ) {
            // width from the left of the element to the right of the screen
            let width = window.innerWidth - offset_x;
            el_inner.style.width = width + 'px';
        }
    
    });
 
};

export const height_computer = () => {
    // select all offset images
    let els = document.querySelectorAll('.r-image');

    // return if there are no elements
    if ( els.length < 1 ) return;

    // loop through each image
    els.forEach(el => {
        // select the inner container of the image
        let el_inner = el.querySelector('.r-image-inner');
        // compute the height the parent column
        let col_height = el.closest('.elementor-column').offsetHeight;
        // get the height value added through elementor 
        let computed_height = window.getComputedStyle( el_inner ).getPropertyValue('--height-elementor');
        // check if that value is a percentage
        if ( computed_height.includes('%') ) {
            // parse the percentage height to float
            computed_height = parseFloat(computed_height);
            // compute the height of the element with respect to its container
            let percentage = computed_height / 100;
            let final_height = ( col_height * percentage );
            // set the height of the element
            el_inner.style.height = final_height + 'px';
            // set the container minimum height to 1px
            // this is done to fix issues when a section that is offset to either side not working
            // when the image container had height of 0.
            // adding this min-height through css does not work
            if ( el.classList.contains('overlap') ) {
                el.style.minHeight = '1px';    
            } else {
                el.style.minHeight = computed_height + 'px';   
            }
        } else {
            //  if it is not percentage than set the height
            el_inner.style.height = computed_height;
            if ( ! el.classList.contains('overlap') ) {
                el.style.minHeight = computed_height;
            }
        }
        
    });
}