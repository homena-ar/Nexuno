import { getAbsoluteElementHeight, appendClassSelector } from '../utils/utils';

export const tabAnimationHandler = (e) => {
    let isSelect = e.target.matches('select');

    const container = e.target.closest('.growla-tabs');
    const tabWrapper = container.querySelector('.growla-tabs-content');

    let currentOption = null;

    if (isSelect) {
        const select = e.target;
        const option = select.options[select.selectedIndex];
        currentOption = document.getElementById(option.dataset.option);
    } else {
        currentOption = e.target.closest('.growla-tabs-options li');

        const select = container.querySelector('.selectify-wrapper > select');
        const active = container.querySelector('.selectify-wrapper .active');
        select.selectify.customOption( currentOption, active, true );
    }
    
    const currentTabID = currentOption.dataset.target;
    const currentTab = container.querySelector(currentTabID);

    const activeOptionClass = 'growla-tab-option-active'
    const activeTabClass = 'growla-tab-active';

    const activeOption = container.querySelector(appendClassSelector(activeOptionClass));
    const activeTab = container.querySelector(appendClassSelector(activeTabClass));

    if ( currentOption === activeOption ) return;

    const animatingClass = 'is-animating';
    const isAnimating = container.classList.contains(animatingClass);

    if ( isAnimating ) return;

    const activeHeight = activeTab.offsetHeight;
    const currentHeight = getAbsoluteElementHeight(currentTab);

    const tl = gsap.timeline({
        onStart: () => {
            container.classList.add(animatingClass);
            activeOption.classList.remove(activeOptionClass);
            currentOption.classList.add(activeOptionClass);
        },
        onComplete: () => {
            container.classList.remove(animatingClass);

            activeTab.classList.remove(activeTabClass);
            currentTab.classList.add(activeTabClass);

            tabWrapper.style.setProperty('height', 'auto');
        }
    });

    tl.set(tabWrapper, { height: activeHeight });
    tl.to(tabWrapper, { height: currentHeight });
    tl.to(activeTab, { y: 50, autoAlpha: 0, position: 'absolute' }, '<');
    tl.to(currentTab, { y: 0, autoAlpha: 1, position: 'static' });
}