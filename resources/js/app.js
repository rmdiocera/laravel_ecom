import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy'
import '../css/app.css'
import MainLayout from '@/Layouts/MainLayout.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faCircleArrowLeft, faCartPlus, faHeart, faCreditCard, faCirclePlus, faFilter } from '@fortawesome/free-solid-svg-icons'

library.add(faCircleArrowLeft, faCartPlus, faHeart, faCreditCard, faCirclePlus, faFilter)

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    // return pages[`./Pages/${name}.vue`]
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || MainLayout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component('fa-icon', FontAwesomeIcon)
      .use(plugin)
      .use(ZiggyVue)
      .mount(el)
  },
})