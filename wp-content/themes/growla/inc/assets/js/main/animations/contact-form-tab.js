export const contactFormTabAnimationHandler = (e) => {
    const clickedTarget = e.target.closest('.contact-form-tabs-navigation-item');
    const wrapper = clickedTarget.closest('.contact-form-tabs');
    const targetID = clickedTarget.dataset.target;
    if (targetID == null || targetID === '') return;

    const activeClass = 'active';

    const isActive = clickedTarget.classList.contains(activeClass); 

    if ( isActive ) return;

    const activeNavItem = wrapper.querySelector('.contact-form-tabs-navigation-item.active');

    const targetTab =  wrapper.querySelector(targetID);
    if (targetTab == null) return;

    const activeTab = wrapper.querySelector('.contact-form-tab.active');
    if ( activeTab == null ) return;

    const tabsContainer = wrapper.querySelector('.contact-form-tabs-content');

    const animatingClass = 'is-animating';
    const isAnimating = wrapper.classList.contains(animatingClass);

    if ( isAnimating ) return;

    const currentHeight = tabsContainer.offsetHeight;
    const targetTabHeight = targetTab.offsetHeight;

    const tl = gsap.timeline({
        onStart: () => {
            wrapper.classList.add(isAnimating);
            
            activeNavItem.classList.remove(activeClass);
            clickedTarget.classList.add(activeClass);
        },
        onComplete: () => {
            wrapper.classList.remove(isAnimating);
            wrapper.style.setProperty('height', 'auto');

            activeTab.classList.remove(activeClass);
            targetTab.classList.add(activeClass);
        }
    });

    tl.set(tabsContainer, { height: currentHeight });
    tl.to(tabsContainer, { height: targetTabHeight });
    tl.to(activeTab, { autoAlpha: 0, y: 25, position: 'absolute' }, '<');
    tl.to(targetTab, { autoAlpha: 1, y: 0, position: 'static' });

}