import Vue from 'vue'
import VueInternalization from 'vue-i18n'
import Locale from './vue-i18n-locales.generated'
import VueCookies from 'vue-cookies'

Vue.use(VueInternalization);

const lang = VueCookies.get('lang') || 'en'
document.documentElement.lang = lang
const i18n = new VueInternalization({
    locale: lang,
    messages: Locale
});

export default i18n;