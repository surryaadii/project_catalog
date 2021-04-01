<template>
    <div class="d-flex">
        <SidebarMenu />
        <router-view></router-view>
    </div>
</template>

<script>
    import Header from './Header'
    import SidebarMenu from './SidebarMenu.vue'
    export default {


        components:{
            Header,
            SidebarMenu
        }
    }
</script>

<style>

</style>