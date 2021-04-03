<template>
    <div class="main-menu">
        <b-navbar toggleable="sm" type="info" variant="white">
            <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>

            <b-navbar-brand>BootsVue</b-navbar-brand>

            <b-navbar-brand></b-navbar-brand>

            <b-collapse id="nav-text-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-text>
                        <router-link :to="{ name: 'home' }" custom v-slot="{ href, navigate, isExactActive }">
                            <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="nav-link menu-link" :class="isExactActive ? 'active' : '' ">Home</a>
                        </router-link>
                    </b-nav-text>
                    <b-nav-text>
                        <router-link :to="{ name: 'contact' }" custom v-slot="{ href, navigate, isExactActive }">
                            <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="nav-link menu-link" :class="isExactActive ? 'active' : '' ">Contact</a>
                        </router-link>
                    </b-nav-text>
                    <b-nav-text>
                        <router-link :to="{ name: 'about' }" custom v-slot="{ href, navigate, isExactActive }">
                            <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="nav-link menu-link" :class="isExactActive ? 'active' : '' ">About</a>
                        </router-link>
                    </b-nav-text>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpenSidebarMenu: true,
        }
    },
    created() {
        this.aa()
        console.log( this.$t('auth.failed') )
    },
    methods:{
        aa: function(){
            console.log(this)
            /*this.$http.get('/lists-users').then(response => {
                this.users = response.data.users;
            })*/
        }
    },
}
</script>

<style>

</style>