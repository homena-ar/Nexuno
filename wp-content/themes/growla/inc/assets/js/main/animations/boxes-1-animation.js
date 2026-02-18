export const Boxes1AnimationHandler = () => {

    document.querySelectorAll('.illustration-boxes-1-item, .growla-illustration-box').forEach(box => {
        const color = window.getComputedStyle(box).getPropertyValue('--box-color');
        gsap.set(box, { willChange: "background-color" });
        animateBox(box, color);
    });
}

const animateBox = (box, color) => {
    const nextColor = Math.random() > 0.5 ? color : 'rgba(0,0,0,0)';
    const nextDuration = Math.random() * 2 + 2;

    gsap.to(box, {
        backgroundColor: nextColor,
        duration: nextDuration,
        onComplete: () => animateBox(box, color),
    });
}