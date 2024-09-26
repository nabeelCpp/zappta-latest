/** Return the CSS dimensions, dpr (device pixel resolution), and desired pixel dimensions, of a canvas. */
export function canvasDims(canvas: HTMLCanvasElement) {
    let dpr = window.devicePixelRatio           // DPR: How many device pixels per CSS pixel (can be fractional)
    let cssWidth = canvas.clientWidth           // CSS dimensions of canvas
    let cssHeight = canvas.clientHeight
    let pxWidth = Math.round(dpr * cssWidth)    // Dimensions we should set the backing buffer to.
    let pxHeight = Math.round(dpr * cssHeight)
    return {dpr, cssWidth, cssHeight, pxWidth, pxHeight}
}

/** Plot a blue Lissajous curve and two sine waves on a dark background. */
export function plotImage(ctx: CanvasRenderingContext2D, width: number, height: number) {
    ctx.fillStyle = '#1F2937'
    ctx.fillRect(0, 0, width, height)

    ctx.strokeStyle = '#FCA5A566'
    ctx.lineWidth = 2
    ctx.beginPath()
    pathHorizontalSine(ctx, width, height * 0.2)
    ctx.stroke()

    ctx.beginPath()
    pathHorizontalSine(ctx, width, height * 0.8)
    ctx.stroke()

    ctx.beginPath()
    ctx.strokeStyle = '#818CF8'
    pathLissajous(ctx, width/2, height/2, Math.min(width, height) * 0.45)
    ctx.stroke()
}

/** Draw a Lissajous curve centred on (cx, cy), scaled by w so that the result is in (cx, cy) + [-w, w]^2. */
function pathLissajous(ctx: CanvasRenderingContext2D, cx: number, cy: number, w: number) {
    let a = 5, b = 6, delta = Math.PI/4
    let period = 15 * 2 * Math.PI // LCM(a, b)
    let samples = 5000

    for (let i = 0; i < samples; i++) {
        let t = i * period / samples
        ctx.lineTo(cx + w * Math.sin(a*t + delta), cy + w * Math.cos(b*t))
    }
}

/** Draw a horizontal sine wave of the given width, starting at y given by the height */
function pathHorizontalSine(ctx: CanvasRenderingContext2D, width: number, y: number) {
    for (let x = 0; x < width; x += 0.25)
        ctx.lineTo(x, y + 10 * Math.cos(0.1 * x + Math.PI/5))

}

/** Animate the CSS width property. */
export function bounceWidth(element: HTMLElement) {
    element.animate([
        {width: "100%", easing: "ease-in-out"},
        {width: "10%", easing: "ease-in-out"},
        {width: "100%", easing: "ease-in-out"},
    ], {
        duration: 5000,
        iterations: 2,
    })
}

/** Perform an action when an element first becomes visible. */
export function whenFirstVisible(element: HTMLElement, action: () => void) {
    new IntersectionObserver((entries, observer) => {
        if (entries.length > 0 && entries[0].isIntersecting) {
            action()
            observer.disconnect()
        }
    }, {threshold: 1.0}).observe(element)
}
