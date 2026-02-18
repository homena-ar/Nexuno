export const project_load_more_handler = async (e) => {
    e.preventDefault();

    let anchor = e.target.closest('a');
    let endpoint  = anchor.href;
    let container = anchor.closest('.project-list');
    let wrapper = container.querySelector('.project-list-wrapper');
    let offset = container.querySelectorAll('.project-single').length;
    let nonce = wrapper.dataset.nonce;
    let max = parseInt(wrapper.dataset.max);

    const hide_btn = () => anchor.closest('.load-more-row').style.setProperty('display', 'none');

    const data =  new FormData();
    data.append('action', 'growla_projects_load_more');
    data.append('offset', offset);
    data.append('security', nonce);
    const params = new URLSearchParams(data);
    
    try {
        let response = await fetch(endpoint, {
            method: 'POST',
            headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
            body: params
        });
        let data = await response.text();

        if ( data === '' ) {
            hide_btn();
        }

        let projects = data.split('--splitter--');

        projects.forEach(project => {
            if ( project === '' ) return;

            const parser = new DOMParser();
            const DOM = parser.parseFromString(project, 'text/html');
            const projectElement = DOM.querySelector('.project-single');

            wrapper.appendChild(projectElement);
        })

        // recalculate offset
        offset = container.querySelectorAll('.project-list-wrapper .project-single').length;

        if ( offset === max ) {
            hide_btn();
        }


    } catch (err) {
        console.log(err);
        // hide the button container
        hide_btn();
    }


    
}

export const project_layout_switch_handler = (e) => {
    const element = e.target.closest('.project-list-layout-switcher div');
    const sibling = element.previousElementSibling ? element.previousElementSibling : element.nextElementSibling;
    
    const activeClass = 'project-list-layout-active';

    if ( element.classList.contains(activeClass) ) return;

    if (sibling == null) return;

    const parent = e.target.closest('.project-list');
    const projects = parent.querySelector('.project-list-wrapper'); 

    element.classList.add(activeClass);
    sibling.classList.remove(activeClass);

    projects.classList.toggle('project-list-vertical')
}