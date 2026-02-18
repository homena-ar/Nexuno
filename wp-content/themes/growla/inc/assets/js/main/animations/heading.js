export const animateHeadings = () => {
    const elements = document.querySelectorAll('.growla-animated-heading');
    if (elements.length < 1) return;

    let mm = gsap.matchMedia();

    elements.forEach(element => {
        mm.add("(min-width: 992px)", () => {
            const characters = element.querySelectorAll('.growla-character');
            gsap.from(characters, {
                opacity: 0,
                y: 10,
                stagger: 0.1,
                scrollTrigger: {
                    trigger: element,
                    end: 'top 40%',
                    scrub: true
                }
            });

            const subheading = element.querySelector('.growla-heading--sub');
            if (subheading) {
                gsap.from(subheading, {
                    opacity: 0,
                    y: 5,
                    duration: .3,
                    scrollTrigger: {
                        trigger: element,
                        end: 'top 60%',
                        scrub: false,
                    }
                })
            }
        }); 
    })
}