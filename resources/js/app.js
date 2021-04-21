import Vue from 'vue'
import VueRouter from 'vue-router'
import VueInternalization from 'vue-i18n'
import VueCookies from 'vue-cookies'
import VueSplide from '@splidejs/vue-splide'
import Tinybox from "vue-tinybox"
import _ from 'lodash'
import axios from 'axios';
import router from './router'
import i18n from './i18n'
import App from './components/App'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import '@splidejs/splide/dist/css/themes/splide-default.min.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueCookies)
Vue.use(VueSplide)
Vue.use(VueRouter)

Vue.component('Tinybox', Tinybox);

const lang = Vue.$cookies.get('lang') || 'en'
axios.defaults.headers.common['lang'] = lang;

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
        },
        validateFormData: function(formData, formValidationData) {
            let self = this
            let errForm = {}
            for(var key in formData) {
                const modelValidation = formValidationData[key]
                let arrError = [];
                for (let idx in modelValidation) {
                    const validation = modelValidation[idx];
                    
                    if(validation == 'required') {
                        if(self.isBlank(formData[key])) {
                            arrError.push(validation)
                            break;
                        }
                    }

                    //type phone
                    if(validation == 'phone') {
                        if(!self.validatePhone(formData[key])) {
                            arrError.push(validation)
                            break;
                        }
                    }

                    //type email
                    if(validation == 'email') {
                        if(!self.validateEmail(formData[key])) {
                            arrError.push(validation)
                            break;
                        }
                    }
                }
                // if temp error more than 0 than set to object
                if(arrError.length > 0) errForm[key] = arrError
            }
            return errForm;
        }
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    i18n,
    router,
});
