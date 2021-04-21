import Vue from 'vue'
import VueRouter from 'vue-router'
import VueCookies from 'vue-cookies'
import i18n from './i18n'
import Home from './components/layouts/Home'
import Products from './components/layouts/Products'
import ProductDetail from './components/layouts/ProductDetail'
import About from './components/layouts/About'
import Contact from './components/layouts/Contact'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: `/${i18n.locale}`
        },
        {
            path: '/:lang',
            component: Vue.component('router-lang-wrapper', {
                template: '<router-view></router-view>',
            }),
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
        // set meta title
        document.title = `${to.meta.title} | ${DEFAULT_TITLE}` || DEFAULT_TITLE;
    });

    // set the current language for i18n.
    if (_.includes(i18n.availableLocales, language)) {
        i18n.locale = language
        VueCookies.set('lang', language)
    } else {
        language = VueCookies.get('lang') || 'en'
        return next({path: '/', params:{lang:language}})
    }
    next()
});

export default router;