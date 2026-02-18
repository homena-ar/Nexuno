import { isTouchScreen } from '../utils/utils';

const svg = document.querySelector('.growla-mouse-trail')
const path = svg.querySelector('path')

let points = []
let segments = 50
let mouse = {
  x: 0,
  y: 0,
}

export const mouseTrailMoveHandler = (event) => {
    if (isTouchScreen) {
        return;
    }
  const x = event.clientX
  const y = event.clientY

  mouse.x = x + 8;
  mouse.y = y + 4;

  if (points.length === 0) {
    for (let i = 0; i < segments; i++) {
      points.push({
        x: x,
        y: y,
      })
    }
  }
}

export const mouseTrailAnimationHandler = () => {
    if (isTouchScreen) {
        return;
    }
  // starting point
  let px = mouse.x
  let py = mouse.y

  points.forEach((p, index) => {
    p.x = px
    p.y = py

    let n = points[index + 1]

    if (n) {
      px = px - (p.x - n.x) * 0.1
      py = py - (p.y - n.y) * 0.1
    }
  })

  const attributeValue = `M ${points.map((p) => `${p.x} ${p.y}`).join(` L `)}`;

  if ( attributeValue !== 'M ' )
    path.setAttribute('d', attributeValue)

  requestAnimationFrame(mouseTrailAnimationHandler)
}

export const mouseTrailResizeHandler = () => {
    if (isTouchScreen) {
        return;
    }
  const ww = window.innerWidth
  const wh = window.innerHeight

  svg.style.width = ww + 'px'
  svg.style.height = wh + 'px'
  svg.setAttribute('viewBox', `0 0 ${ww} ${wh}`)
}