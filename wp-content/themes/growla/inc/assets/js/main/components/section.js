export const calculate_section_offset = () => {
    /*
    *   transforms were used to align the sections to either side because
    *   Elementor by default, locks the margin-left and margin-right property
    *   to auto. This allows us to always get the browser computed value of the margin,
    *   which we can then use in transform property.
    */


    // get all sections
    let sections = document.querySelectorAll('.r-left-align, .r-right-align');
    // return if there are no sections
    if ( sections.length < 1 ) return;
    // loop through all sections
    sections.forEach(section => {
        // select the immediate container below
        let container = section.querySelector(':scope > .elementor-container');
        // move to the next section if the container does not exist
        if ( container === undefined || container === null ) return;
        // get computed styles for the container
        let computed_style = window.getComputedStyle(container);
        // check if the section should be left aligned
        if ( section.classList.contains('r-left-align') ) {
            // fetch the computed left margin and divide it by 2
            let left_margin = parseFloat( computed_style.getPropertyValue('margin-left') ) / 2.0;
            // set the relevant transforms
            section.style.setProperty('transform', `translateX(-${left_margin}px)`);
            container.style.setProperty('transform', `translateX(${left_margin}px)`);
        } 
        // check if the section should be right aligned
        else if ( section.classList.contains('r-right-align') ) {
            // fetch the computed right margin and divide it by 2
            let right_margin = parseFloat( computed_style.getPropertyValue('margin-right') ) / 2.0;
            // set the relevant transforms
            section.style.setProperty('transform', `translateX(${right_margin}px)`);
            container.style.setProperty('transform', `translateX(-${right_margin}px)`);
        }
    })
}