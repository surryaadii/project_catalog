import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'
import Hello from './views/Hello'
import Home from './views/Home'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
        },
    ],
});

router.beforeEach((to, from, next) => {
    let language = to.params.lang;
    if (!language) {
      language = 'en';
    }
  
    i18n.locale = language;
    next();
  });

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
