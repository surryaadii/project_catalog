<template>
    <div class="d-flex">
        <SidebarMenu />
        <router-view></router-view>
        <div class="floating-icon-whatsapp">
            <a :href="'https://wa.me/'+ 628989224842 " target="_blank">
                <img src="/assets/frontend/images/whatsapp-icon.svg" alt="">
                <span>Chat</span>
            </a>
        </div>
    </div>
</template>

<script>
    import Header from './menu/Header'
    import SidebarMenu from './menu/SidebarMenu.vue'
    export default {
        components:{
            Header,
            SidebarMenu
        }
    }
</script>

<style>

</style>