export let isMobile = false;
export const isTouchScreen = window.matchMedia("(pointer: coarse)").matches;

export const isMobileCalculator = () => {
    if (window.innerWidth >= 992) isMobile = false;
    else isMobile = true;
}

export const getAbsoluteElementHeight = (element) => {
    if ( element == null ) return null;
    const height = element.offsetHeight;
    return height;
};

export const getHiddenElementHeight = (element) => {
    if (element == null) return null;
    element.style.setProperty('display', 'block');
    const height = element.offsetHeight;
    element.style.setProperty('display', 'none');
    return height;
}

export const appendClassSelector = className =>  '.' + className;

export const getStyle = (element, property) => {
    if (element == null || property == null) {
        return '';
    }

    return window.getComputedStyle(element).getPropertyValue(property);
}

export function debounce(func, delay = 500) {
    let timeoutId;
    
    return function(...args) {
        const context = this;
        
        clearTimeout(timeoutId);
        
        timeoutId = setTimeout(() => {
            func.apply(context, args);
        }, delay);
    };
}

export function throttle(func, delay = 300) {
    let timeoutId;
    let lastExecTime = 0;
    
    return function(...args) {
        const context = this;
        const currentTime = Date.now();
        
        if (currentTime - lastExecTime >= delay) {
            // If enough time has passed since the last execution, execute the function
            func.apply(context, args);
            lastExecTime = currentTime;
        } else {
            // If not enough time has passed, schedule the execution
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(context, args);
                lastExecTime = currentTime;
            }, delay - (currentTime - lastExecTime));
        }
    };
}