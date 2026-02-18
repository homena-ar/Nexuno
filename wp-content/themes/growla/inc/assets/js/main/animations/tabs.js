const tab_anim = (e) => {
    const active_id = e.target.dataset.bsTarget;
    const prev_id = e.relatedTarget.dataset.bsTarget;
    
    const active_pane = document.querySelector(`${active_id}`);
    const prev_pane = document.querySelector(`${prev_id}`);

    const active_page_height = active_pane.offsetHeight;
    const pane_wrapper = active_pane.closest('.tab-content');

    gsap.to(pane_wrapper, {height: active_page_height});


    const active_pane_div = active_pane.querySelector(':scope > div');
    const prev_pane_div = prev_pane.querySelector(':scope > div');

    const prev_tl = gsap.timeline({ defaults: {duration: .3 } });

    prev_tl.to(prev_pane_div, { 
        autoAlpha: 0, 
        y: -25
    });

    prev_tl.to(prev_pane, { 
        autoAlpha: 0,
    });

    const active_tl = gsap.timeline({ defaults: {duration: .3 } });

    active_tl.to(active_pane, { 
        autoAlpha: 1,
    });

    active_tl.to(active_pane_div, { 
        autoAlpha: 1, 
        y: 0
    });


    let active_li = document.querySelector(`.selectify li[data-value="${e.target.id}"]`);
    if ( active_li !== null && active_li !== undefined ) {
        let parent_select = active_li.closest('.selectify-wrapper');
        let select = parent_select.querySelector('select');
        let active = parent_select.querySelector('.active');
    
        select.selectify.customOption( active_li, active, true );
    }


    active_pane.closest('.tab-content').querySelector('.first-render')?.classList?.remove('first-render');
};

const set_tab_active = (el) => {
    const id = el.dataset.bsTarget;
    const pane = document.querySelector(`${id}`);
    const div = pane.querySelector(':scope > div');

    const pane_wrapper = pane.closest('.tab-content');

    gsap.to(pane_wrapper, {height: pane.offsetHeight});

    gsap.to(
        pane,
        {
            autoAlpha: 1,
        }
    );

    gsap.to(
        div,
        {
            autoAlpha: 1,
            y: 0
        }    
    );
}

const set_tab_heights = (id) => {
    const el = document.querySelector(id);
    let height = 0;
    
    Array.from(el.children).forEach((child) => {
        height += child.offsetHeight;
    })

    el.style.setProperty('height', height + 'px');
    return height;
}

const get_tab_height = (id) => {
    const el = document.querySelector(id);
    return el.offsetHeight;
}

export const tab_handler = (type) => {
    let main = document.querySelectorAll('.growla-tabs');

    main.forEach(tab => {
        let els = tab.querySelectorAll('button[data-bs-toggle="tab"]');
        let pane_wrapper = tab.querySelector('.tab-content');
        
        els.forEach((el) => {

            if ( el.classList.contains('active') ) {
                set_tab_active(el);
                pane_wrapper.style.setProperty('height', get_tab_height(el.dataset.bsTarget) + 'px'); 
            }
            
            if ( type === 'load' )
                el.addEventListener('show.bs.tab', tab_anim);
        });
        
    });
}

export const nav_select_handler = (el) => {
    let id = el.dataset.value;
    if ( id === null || id === undefined || id === '' ) return;

    let trigger =  document.querySelector(`#${id}`);
    if ( trigger === null || trigger === undefined ) return;

    let tab = new bootstrap.Tab(trigger)
    tab.show();

    let select_wrapper = el.closest('.selectify-wrapper');
    let select = select_wrapper.querySelector('select');
    let active = select_wrapper.querySelector('.active');
    
    select.selectify.customOption( trigger, active, true );

}