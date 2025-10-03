import 'jquery'

interface OwlCarouselOptions {
  loop?: boolean
  margin?: number
  nav?: boolean
  dots?: boolean
  autoplay?: boolean
  autoplayTimeout?: number
  autoplayHoverPause?: boolean
  responsive?: {
    [key: number]: {
      items: number
    }
  }
  items?: number
  navText?: string[]
  smartSpeed?: number
  autoplaySpeed?: number
  dragEndSpeed?: number
  [key: string]: unknown
}

interface OdometerOptions {
  el: HTMLElement
  value: number
  format?: string
  theme?: string
  duration?: number
  animation?: string
}

interface OdometerInstance {
  update(value: number): void
  render(): void
}

declare global {
  interface JQuery {
    owlCarousel(options?: OwlCarouselOptions | string): JQuery
  }

  interface Window {
    Odometer: {
      new (options: OdometerOptions): OdometerInstance
    }
  }
}

export {}
