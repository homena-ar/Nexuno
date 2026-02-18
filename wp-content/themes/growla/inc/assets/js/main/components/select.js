export const selectHandler = () => {
    const elements = document.querySelectorAll('select');
    if (elements.length < 1) return;
    elements.forEach(element => {
        if (element.closest('.growla-tabs-select')) return;
        const isCorrectParent = element.classList.contains('growla-select');
        
        if (!isCorrectParent) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('growla-select');
            element.parentNode.insertBefore(wrapper, element);
            wrapper.appendChild(element);
        }
        
        new TomSelect(element, {
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });
}