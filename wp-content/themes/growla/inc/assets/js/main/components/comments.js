export const comment_cancel_handler = (e) => {
    e.preventDefault();
    let cancel_el = document.querySelector('#cancel-comment-reply-link');
    let parent = document.querySelector('.form-submit-row .cancel');
    if ( cancel_el == null || parent == null ) return;
    parent.appendChild(cancel_el);
}