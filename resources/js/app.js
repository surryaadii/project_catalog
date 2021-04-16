import Vue from 'vue'
import VueRouter from 'vue-router'
import VueInternalization from 'vue-i18n'
import VueCookies from 'vue-cookies'
import VueSplide from '@splidejs/vue-splide';
import Tinybox from "vue-tinybox";
import _ from 'lodash'
import axios from 'axios';
import App from './components/App'
import Home from './components/layouts/Home'
import Products from './components/layouts/Products'
import ProductDetail from './components/layouts/ProductDetail'
import About from './components/layouts/About'
import Contact from './components/layouts/Contact'
import Locale from './vue-i18n-locales.generated'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import '@splidejs/splide/dist/css/themes/splide-default.min.css';

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueCookies)
Vue.use(VueSplide)

Vue.component('Tinybox', Tinybox);

Vue.use(VueRouter)
Vue.use(VueInternalization);

const lang = Vue.$cookies.get('lang') || 'en'
document.documentElement.lang = lang
const i18n = new VueInternalization({
    locale: lang,
    messages: Locale
});

axios.defaults.headers.common['lang'] = lang;

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
                    path: 'products/:slug',
                    name: 'productDetail',
                    component: ProductDetail,
                    meta: ({ title: 'Products Detail' })
                },
                {
                  path: 'about',
                  name: 'about',
                  component: About,
                  meta: ({ title: 'About' }) 
                },
                {
                  path: 'contact',
                  name: 'contact',
                  component: Contact,
                  meta: ({ title: 'Contact' }) 
                }
            ],
        },
    ],
});


const DEFAULT_TITLE = 'Global Business Solution'
router.beforeEach((to, from, next) => {
    let language = to.params.lang;

    Vue.nextTick(() => {
        document.title = `${to.meta.title} | ${DEFAULT_TITLE}` || DEFAULT_TITLE;
    });

    // set the current language for i18n.
    if (_.includes(i18n.availableLocales, language)) {
        i18n.locale = language
        Vue.$cookies.set('lang', language)
    } else {
        language = Vue.$cookies.get('lang') || 'en'
        return next({path: '/', params:{lang:language}})
    }
    next()
});

Vue.mixin({
    methods: {
        isBlank:function (string){
            /* filter empty string */

            return (_.isEmpty(string) || _.isUndefined(string) || _.isNull(string) || string == "")
        },
        validateEmail:function(email){
            let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        validatePhone: function(phone) {
            let re = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/
            return re.test(phone)
        },
        clipboardText: function(text) {
            let textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            let msg = ''
            try {
                let successful = document.execCommand('copy');
                msg = successful ? 'successful' : 'unsuccessful';
            } catch (err) {
                console.log('Oops, unable to copy');
            }
            document.body.removeChild(textArea);
            return msg
        }
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    i18n,
    router,
});
