export const growSectionAnimation = () => {
    const sections = document.querySelectorAll('.growla-grow-section');
    if (sections.length < 1) return;

    let mm = gsap.matchMedia();

    sections.forEach(section => {
        mm.add("(min-width: 992px)", () => {
            gsap.to(section, {
                clipPath: 'polygon(0% 0%, 100% 0%, 100% 150%, 0% 150%)',
                scrollTrigger: {
                    trigger: section,
                    end: '-10% top',
                    scrub: true,
                }
            });
        });
    });
}