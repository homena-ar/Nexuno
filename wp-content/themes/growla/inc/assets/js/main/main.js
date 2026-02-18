'use strict';

import progressBarHandler from './components/progress-bar';
import counterHandler from './components/counter';
import { comment_cancel_handler } from './components/comments';
import fullWidthResizer from './utils/full-width';
import { stickyNavigationHandler } from './navigation/nav';
import { blockAnimationHandler } from './animations/block-animation';
import { teamAnimationHandler } from './animations/team-members';
import { project_load_more_handler, project_layout_switch_handler } from './components/project.js';
import { tabAnimationHandler } from './animations/tabs-2';
import { collapseAnimationHandler } from './animations/collapse-tab';
import { contactFormTabAnimationHandler } from './animations/contact-form-tab';
import { selectHandler } from './components/select';
import { fullScreenAnimation, dropdownHandler } from './animations/full-screen-menu';
import { wavesAnimationHandler } from './animations/waves-animation';
import { Boxes1AnimationHandler } from './animations/boxes-1-animation';
import { initializeScroll } from './scroll/init';
import { hamburger_handler } from './navigation/hamburger';
import { debounce, throttle, isMobileCalculator } from './utils/utils';

import { mob_dropdown_handler } from './navigation/mobile-nav';
import { create_back_element_wrapper } from './navigation/mobile-nav';

import { animateHeadings } from './animations/heading';
import { growSectionAnimation } from './animations/section';
import { calculateFooterSpacerHeight } from './animations/footer';
import { heroSlideAnimationHandler, pageHeaderAnimationHandler } from './animations/hero-slider';

import { selectify } from './selectify/selectify';

import {
    nav_handler,
    dropdown_switch,
    dropdown_leave,
    add_nav_arrow,
    sm_mouseleave_handler,
    nav_slider_handler,
} from './navigation/nav.js';

import { backToTopHandler, backToTopScrollListener } from './components/back-to-top';

import {
    mouseTrailMoveHandler,
    mouseTrailResizeHandler,
    mouseTrailAnimationHandler,
} from './animations/mouse-trail.js';

gsap.config({ nullTargetWarn: false });
gsap.registerPlugin(ScrollTrigger);

const initializeSelectifyForTabs = () => {
    const elements = document.querySelectorAll('.growla-tabs-select > select');
    if (elements.length < 1) return;
    elements.forEach((element) => {
        selectify(element);

        element.addEventListener('change', tabAnimationHandler);
    });
};

const fileUploadClickHandler = (e) => {
    const parent = e.target.closest('.growla-file-upload');
    const input = parent.querySelector('input');
    input.click();
};

const initializeFileUploads = () => {
    const elements = document.querySelectorAll('.growla-file-upload input[type="file"]');

    Array.from(elements).forEach((element) => {
        element.addEventListener('change', () => {
            const file = element.files[0];
            const file_name_element = element.parentElement.querySelector('.label');

            file_name_element.innerHTML =
                file.name.slice(0, 9) + '...' + file.name.slice(file.name.length - 4, file.name.length);
        });
    });
};

const fadeInRandomElements = () => {
    const elements = document.querySelectorAll('.illustration-boxes-2-item');
    if (elements.length < 1) return;

    elements.forEach((element) => {
        const delay = Math.random() * 2; // Random delay between 0 and 2 seconds
        gsap.to(element, { autoAlpha: 1, duration: 1, delay: delay });
    });
};

class Line {
    constructor(options) {
        Object.assign(
            this,
            {
                strokeStyle: 'white',
                fillStyle: 'transparent',
                lineWidth: 5,
                alive: true,
                alpha: 1,
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 0,
            },
            options
        );
    }

    draw(ctx) {
        ctx.beginPath();
        ctx.moveTo(this.x1, this.y1);
        ctx.lineTo(this.x2, this.y2);
        ctx.fillStyle = this.fillStyle;
        ctx.strokeStyle = this.strokeStyle;
        ctx.globalAlpha = this.alpha;
        ctx.lineWidth = this.lineWidth;
        ctx.fill();
        ctx.stroke();
    }
}

const illustrationLinesAnimation = (canvas) => {
    const ctx = canvas.getContext('2d');
    const direction = canvas.dataset.direction || 'normal';
    const delay = parseFloat(canvas.dataset.delay) || 0;

    let items = [];

    const lineColor = window.getComputedStyle(canvas).getPropertyValue('--line-color') || 'white';

    resizeCanvas();
    window.addEventListener('resize', resizeCanvas, false);

    const lineCount = 5;
    const gap = 10;

    for (let index = 0; index < lineCount; index++) {
        let startX = canvas.width - 5 - index * gap;
        let startY = canvas.height;

        let line1Options = {};
        let line1AnimOptions = {};
        let line2Options = {};
        let line2AnimOptions = {};

        if (direction === 'normal') {
            line1Options = {
                strokeStyle: lineColor,
                x1: startX,
                y1: startY,
                x2: startX,
                y2: startY,
            };

            line1AnimOptions = {
                delay: delay,
                x1: startX,
                x2: startX,
                y1: startY,
                y2: 0 + index * gap + 5,
                ease: 'power1.in',
            };

            line2Options = {
                strokeStyle: lineColor,
                x1: startX + 2.5,
                y1: 0 + index * gap + 5,
                x2: startX + 2.5,
                y2: 0 + index * gap + 5,
            };

            line2AnimOptions = {
                x1: startX + 2.5,
                x2: 0,
                y1: 0 + index * gap + 5,
                y2: 0 + index * gap + 5,
                ease: 'power1.out',
                duration: 0.5,
            };
        } else {
            startY = canvas.height - 2.5;

            line1Options = {
                strokeStyle: lineColor,
                x1: startX,
                y1: 0,
                x2: startX,
                y2: 0,
            };

            line1AnimOptions = {
                delay: delay,
                x1: startX,
                y1: 0,
                x2: startX,
                y2: startY - index * gap,
                ease: 'power1.in',
            };

            line2Options = {
                strokeStyle: lineColor,
                x1: startX + 2.5,
                y1: startY - index * gap,
                x2: startX + 2.5,
                y2: startY - index * gap,
            };

            line2AnimOptions = {
                x1: startX + 2.5,
                y1: startY - index * gap,
                x2: 0,
                y2: startY - index * gap,
                ease: 'power1.out',
                duration: 0.5,
            };
        }

        const line1 = new Line(line1Options);

        const line2 = new Line(line2Options);

        items.push(line1);
        items.push(line2);

        const tl = gsap.timeline({
            delay: index * 0.25,
            defaults: {
                duration: 1,
            },
        });

        tl.to(line1, line1AnimOptions);

        tl.to(line2, line2AnimOptions);
    }

    gsap.ticker.add(render);

    function render() {
        ctx.save();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.restore();

        // construct the scene
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            if (item.alive) {
                item.draw(ctx);
            }
        }
    }

    function resizeCanvas() {
        let w = canvas.clientWidth;
        let h = canvas.clientHeight;
        ctx.canvas.width = w;
        ctx.canvas.height = h;
        ctx.strokeStyle = lineColor;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        render();
    }
};

const illustrationLinesAnimationHandler = () => {
    const canvas = document.querySelectorAll('.illustration-lines-canvas');
    const preloader = document.querySelector('.gfx_preloader');
    const delay = preloader ? 7000 : 0;
    setTimeout(() => {
        canvas.forEach((element) => illustrationLinesAnimation(element));
    }, delay);
};

const ON_LOAD_SERVICES = [
    initializeScroll,
    progressBarHandler,
    counterHandler,
    fullWidthResizer,
    selectHandler,
    wavesAnimationHandler,
    Boxes1AnimationHandler,
    create_back_element_wrapper,
    animateHeadings,

    isMobileCalculator,
    calculateFooterSpacerHeight,
    growSectionAnimation,
    heroSlideAnimationHandler,
    pageHeaderAnimationHandler,
    stickyNavigationHandler,

    initializeSelectifyForTabs,
    initializeFileUploads,

    nav_slider_handler,
    () => {
        add_nav_arrow('.sub-menu .menu-item-has-children');
        add_nav_arrow('.navigation-menu.mobile > .menu-item-has-children');
    },

    illustrationLinesAnimationHandler,

    fadeInRandomElements,
    mouseTrailAnimationHandler,
    mouseTrailResizeHandler,
];

window.addEventListener('load', () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('elementor-preview')) {
        setTimeout(() => ON_LOAD_SERVICES.forEach((service) => service()), 1000);
        return;
    }

    ON_LOAD_SERVICES.forEach((service) => service());
});

const CLICK_HANDLERS = {
    '.comment-reply-link': comment_cancel_handler,
    '.growla-block-slide-2': blockAnimationHandler,
    '.team-member-2': teamAnimationHandler,
    '.load-more-button': project_load_more_handler,
    '.growla-tabs-options li': tabAnimationHandler,
    '.growla-collapse': collapseAnimationHandler,
    '.contact-form-tabs-navigation-item': contactFormTabAnimationHandler,
    '.growla-full-screen-nav-trigger': fullScreenAnimation,
    '.growla-full-screen-nav-content-menu > ul > li.menu-item-has-children > a': dropdownHandler,
    '.project-list-layout-switcher div': project_layout_switch_handler,
    '.hamburger-icon': hamburger_handler,
    '.hamburger-overlay': hamburger_handler,
    '.hamburger-close': hamburger_handler,
    '.navigation-menu.mobile': (e) => {
        if (e.target.closest('.back-button')) {
            mob_dropdown_handler(e, true);
        }

        if (e.target.parentNode.matches('.menu-item-has-children')) {
            mob_dropdown_handler(e);
        }
    },
    '.elementor-open-inline': (e) => {
        const widget = e.target.closest('.elementor-widget-video');
        if (widget == null) return;
        const illustration = widget.querySelector('.growla-video-illustration');
        if (illustration == null) return;
        gsap.to(illustration, { autoAlpha: 0 });
    },
    '.growla-file-upload': fileUploadClickHandler,
    '.back-to-top': backToTopHandler,
};

document.addEventListener('click', (e) => {
    for (const [key, value] of Object.entries(CLICK_HANDLERS)) {
        if (e.target.closest(key)) {
            value(e);
        }
    }
});

const ON_RESIZE_SERVICES = [fullWidthResizer, isMobileCalculator, calculateFooterSpacerHeight, mouseTrailResizeHandler];

window.addEventListener(
    'resize',
    debounce(() => {
        ON_RESIZE_SERVICES.forEach((service) => service());
    }),
    { passive: true }
);

const ON_SCROLL_SERVICES = [stickyNavigationHandler, backToTopScrollListener];

window.addEventListener(
    'scroll',
    throttle(() => {
        ON_SCROLL_SERVICES.forEach((service) => service());
    }, 200),
    { passive: true }
);

const ON_MOUSE_MOVE_SERVICES = [
    mouseTrailMoveHandler,
    function (e) {
        const mouseX = e.pageX;
        const mouseY = e.pageY;

        // Adjust the speed of parallax for different elements
        const parallaxElements = document.querySelectorAll('.illustration-boxes-2-item');
        parallaxElements.forEach(function (element, index) {
            let speed = element.dataset.speed;
            if (!speed) {
                speed = Math.random() * 2 + 0.1;
                element.dataset.speed = speed;
            }
            const offsetX = (mouseX * speed) / 100;
            const offsetY = (mouseY * speed) / 100;

            // Apply parallax effect
            element.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
        });
    },
];

document.addEventListener(
    'mousemove',
    (e) => {
        ON_MOUSE_MOVE_SERVICES.forEach((service) => service(e));
    },
    { passive: true }
);

// mouseenter event
document.body.addEventListener(
    'mouseenter',
    function (e) {
        e.stopPropagation();

        // navigation
        if (e.target.matches('.navigation-menu.desktop > .menu-item-has-children')) {
            nav_handler(e);
        }
    },
    true
);

// mouseleave event
document.body.addEventListener(
    'mouseleave',
    function (e) {
        e.stopPropagation();

        if (e.target.matches('.navigation-menu.desktop > .menu-item-has-children')) {
            nav_handler(e);
        }

        if (e.target.matches('.navigation-menu.desktop .sub-menu .sub-menu')) {
            sm_mouseleave_handler(e);
        }
    },
    true
);

document.body.addEventListener(
    'mouseover',
    (e) => {
        e.stopPropagation();
        if (e.target.closest('.navigation-menu.desktop .sub-menu > .menu-item-has-children')) {
            dropdown_switch(e);
        }
    },
    true
);

document.body.addEventListener('mouseout', (e) => {
    if (e.target.closest('.navigation-menu.desktop .sub-menu > .menu-item-has-children')) {
        dropdown_leave(e);
    }
});
