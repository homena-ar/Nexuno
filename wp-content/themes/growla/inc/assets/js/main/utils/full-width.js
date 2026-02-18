const fullWidthResizer = () => {
    const containers = document.querySelectorAll('.growla-full-width-container');
    const isRTL = document.documentElement.dir === 'rtl';
    if (containers.length < 1) return;
    containers.forEach(container => {
        const innerElement = container.querySelector('.e-con-inner');
    
        // Calculate offset from the left
        const offsetLeft = container.offsetLeft;
    
        // Set the left margin to the negative offset
        if (!isRTL) {
            innerElement.style.marginLeft = -offsetLeft + 'px';
        } else {
            innerElement.style.marginRight = -offsetLeft + 'px';
        }
        innerElement.style.maxWidth = 'initial';
        innerElement.style.width = '100vw';
    });
}

export default fullWidthResizer;