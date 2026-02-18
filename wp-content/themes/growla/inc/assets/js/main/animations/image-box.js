import { masonry_layout } from "../components/masonry";
import { hs1_height_handler } from "../sliders/hero-slider-1";

const create_ib_tl = (el) => {
  let tl = gsap.timeline({
    reversed: true,
    paused: true,
    onComplete: (el) => {
      hs1_height_handler(el, "complete");
    },
    onCompleteParams: [el],
    onUpdate: (el) => {
      masonry_layout(el);
      hs1_height_handler(el, "update");
    },
    onUpdateParams: [el],
  });

  tl.to(el, {
    height: "auto",
    opacity: 1,
    y: 0,
    marginBottom: 15,
    "clip-path": "polygon(0% 100%, 100% 100%, 100% 0%, 0% 0%)",
  });

  return tl;
};

export const trigger_ib = (element) => {
  let reveal = element.querySelector(".reveal");
  let con = element.querySelector(".content");
  let tl = con.animation;

  // create animation if one does not exist already
  if (tl === undefined) {
    con.animation = create_ib_tl(con);
    tl = con.animation;
  }

  // play animation
  if (tl.reversed()) {
    reveal.classList.add("plus");
    element.classList.add("dropped");
    tl.play();
  } else {
    tl.reverse();
    reveal.classList.remove("plus");
    element.classList.remove("dropped");
  }
};
