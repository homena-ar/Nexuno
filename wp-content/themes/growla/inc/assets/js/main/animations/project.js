import { masonry_layout } from '../components/masonry';

const create_project_tl = ( item ) => {
    let tl = gsap.timeline({ 
        paused: true, 
        ease: 'power4.inOut', 
        defaults: { duration: .3 },
        onUpdate: masonry_layout,
        onUpdateParams: [ item ]
    });

    let bg = item.querySelector('.project-bg');
    let content = item.querySelector('.project-content');
    let cat = item.querySelector('.categories');
    let h4 = item.querySelector('h4');
    let arrow = item.querySelector('.project-reveal');

    if ( content !== undefined || content !== null )
        tl.to(
            content,
            {
                height: 'auto',
                'pointer-events': 'auto'
            }
        );
    
    if ( bg !== undefined || bg !== null )
        tl.to(bg, { 'left': '0px', opacity: 1 } );

    if ( cat !== undefined || cat !== null )
        tl.to(cat, 
            { 
                'clip-path': 'polygon(0% 100%, 100% 100%, 100% 0%, 0% 0%)', 
                opacity: 1, 
                y: 0 
            }, 
            '-=.2' );

    if ( h4 !== undefined || h4 !== null )
        tl.to([h4, arrow], 
            { 
                'clip-path': 'polygon(0% 100%, 100% 100%, 100% 0%, 0% 0%)', 
                opacity: 1, 
                y: 0 
            }, 
            '-=.2' );


    return tl;
}

export const project_trigger = (e) => {
    let el = e.target;
    
    if ( el.animation === undefined ) 
        el.animation = create_project_tl(el);

    if ( e.type === 'mouseenter' ) 
        el.animation.play();
    else 
        el.animation.reverse();
} 