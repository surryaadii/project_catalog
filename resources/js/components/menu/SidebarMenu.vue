<template>
    <div class="sidebar">
        <b-sidebar id="sidebar-menu" shadow v-model="isOpenSidebarMenu" :class="'sidebar-outer'" :bodyClass="'sidebar-body'" :footerClass="'sidebar-footer'" :headerClass="'sidebar-header'" :noCloseOnRouteChange="noCloseOnRouteChange" :backdrop="isBackdropActive" :no-slide="!isSlideActive" :sidebar-class="'sidebar-menu'">
            <template #header="{}">
                <router-link :to="{ name: 'home' }" custom v-slot="{ href, navigate, isExactActive }">
                    <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="logo-link" :class="isExactActive ? 'active' : '' ">
                        <img src="/assets/frontend/images/logo.svg" alt="">
                    </a>
                </router-link>
            </template>
            <b-nav vertical type="info" variant="white">
                <b-nav-text>
                    <router-link :to="{ name: 'home' }" custom v-slot="{ href, navigate, isExactActive }">
                        <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="nav-link" :class="isExactActive ? 'active' : '' ">Home</a>
                    </router-link>
                </b-nav-text>
                <b-nav-text>
                    <router-link :to="{ name: 'products' }" custom v-slot="{ href, navigate, isExactActive }">
                        <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="nav-link" :class="isExactActive ? 'active' : '' ">Products</a>
                    </router-link>
                </b-nav-text>
                <b-nav-text>
                    <router-link :to="{ name: 'about' }" custom v-slot="{ href, navigate, isExactActive }">
                        <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="nav-link" :class="isExactActive ? 'active' : '' ">About</a>
                    </router-link>
                </b-nav-text>
                <b-nav-text>
                    <router-link :to="{ name: 'contact' }" custom v-slot="{ href, navigate, isExactActive }">
                        <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="nav-link" :class="isExactActive ? 'active' : '' ">Hotline Services</a>
                    </router-link>
                </b-nav-text>
            </b-nav>
            <template #footer="{}">
                <div>
                    <b-form-group class="mr-4">
                        <b-form-select v-model="selectLanguage" class="mb-1" @change="changeLanguage">
                        <!-- This slot appears above the options from 'options' prop -->
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Please select an option --</b-form-select-option>
                            </template>

                            <!-- These options will appear after the ones from 'options' prop -->
                            <b-form-select-option value="id">Indonesian</b-form-select-option>
                            <b-form-select-option value="en">English</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <div class="social-media">
                        <span>Follow Our Social Media</span>
                        <div class="social-media-icon">

                         <a href="#"><img src="/assets/frontend/images/facebook-icon.svg" alt="facebook-img"></a> 
                         <a href="#"><img src="/assets/frontend/images/twitter-icon.svg" alt="twitter-img"></a> 
                         <a href="#"><img src="/assets/frontend/images/instagram-icon.svg" alt="instagram-img"></a>
                        </div>
                    </div>
                    <div class="copyright">
                        <span class="copyright-left-side">©</span>
                        <div class="copyright-right-side">
                            <span>{{ new Date().getFullYear()}} GLOBAL BUSINESS SOLUTION PTE LTD.</span>
                            <span>All Rights Reserved.</span>
                        </div>
                    </div>
                </div>
            </template>
        </b-sidebar>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpenSidebarMenu: false,
            noCloseOnRouteChange: false,
            isBackdropActive : false,
            isSlideActive : false,
            selectLanguage: 'en',
        }
    },

    mounted() {
        window.addEventListener("resize", this.getWindowWidth);
        this.getWindowWidth()
        this.selectLanguage = this.$cookies.get('lang') ? this.$cookies.get('lang') : 'en'
    },

    methods: {
        changeLanguage:function() {
            let self = this
            self.$cookies.set('lang', self.selectLanguage)
            document.documentElement.lang = self.selectLanguage
            self.$router.push({params: {lang: self.selectLanguage}})
            self.$router.go(0)
        },
        getWindowWidth(event) {
            let windowWidth = document.documentElement.clientWidth;
            if(windowWidth < 1200) {
                this.noCloseOnRouteChange = false
                this.isOpenSidebarMenu = false
                this.isBackdropActive = true
                this.isSlideActive = true
            } else {
                this.noCloseOnRouteChange = true
                this.isOpenSidebarMenu = true
                this.isBackdropActive = false
                this.isSlideActive = false
            }
        },
        subIsActive(input) {
            const paths = Array.isArray(input) ? input : [input]
            return paths.some(path => {
                return this.$route.path.indexOf(path) === 0 // current path starts with this path string
            })
        }
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.getWindowWidth);
        // window.removeEventListener('resize', this.getWindowHeight);
    }
}
</script>

<style>

</style>