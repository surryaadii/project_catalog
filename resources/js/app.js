import Vue from 'vue'
import VueRouter from 'vue-router'
import VueInternalization from 'vue-i18n'
import VueCookies from 'vue-cookies'
import _ from 'lodash'
import App from './components/App'
import Home from './components/layouts/Home'
import Products from './components/layouts/Products'
import Locale from './vue-i18n-locales.generated'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueCookies)

Vue.use(VueRouter)
Vue.use(VueInternalization);

const lang = document.documentElement.lang.substr(0, 2) || 'en';
const i18n = new VueInternalization({
    locale: lang,
    messages: Locale
});

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: `/${i18n.locale}`
        },
        {
            path: '/:lang',
            component: {
                 render (c) { return c('router-view') } 
            },
            children: [
                {
                  path: '',
                  name: 'home',
                  component: Home,
                  meta: ({ title: 'Home' }) 
                },
                {
                    path: 'products',
                    name: 'products',
                    component: Products,
                    meta: ({ title: 'Products' }) 
                  },
                {
                  path: 'about',
                  name: 'about',
                  component: Home,
                  meta: ({ title: 'About' }) 
                },
                {
                  path: 'contact',
                  name: 'contact',
                  component: { template : '<p>asd</p>'},
                  meta: ({ title: 'Contact' }) 
                }
            ],
        },
    ],
});


const DEFAULT_TITLE = 'Global Business Solution'
router.beforeEach((to, from, next) => {
    let language = to.params.lang;
    if (!language) {
      language = 'en'
    }

    Vue.nextTick(() => {
        document.title = `${to.meta.title} | ${DEFAULT_TITLE}` || DEFAULT_TITLE;
    });
  
    // set the current language for i18n.
    i18n.locale = language
    next()
});

Vue.mixin({
    methods: {
        isBlank:function (string){
            /* filter empty string */

            return (_.isEmpty(string) || _.isUndefined(string) || _.isNull(string) || string == "")
        }
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    i18n,
    router,
});
