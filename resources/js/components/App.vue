<template>
    <div class="d-flex">
        <SidebarMenu />
        <router-view></router-view>
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