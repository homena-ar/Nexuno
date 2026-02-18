import { isMobile } from '../utils/utils';

export const calculateFooterSpacerHeight = () => {
    const spacer = document.getElementById('footer-spacer');
    const content = document.getElementById('footer-content-wrapper');
    const wrapper = document.getElementById('footer-wrapper');

    if (spacer == null || content == null || wrapper == null) {
        return;
    }

    if (isMobile || window.innerHeight < content.offsetHeight) {
        wrapper.classList.add('footer-anim-disabled');
        return;
    } else {
        wrapper.classList.remove('footer-anim-disabled');
    }

    spacer.style.height = content.offsetHeight + 'px';
}