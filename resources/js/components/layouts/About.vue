<template>
  <div class="container about-page">
        <div class="about-title"><h1>About Us</h1></div>
        <div class="about-image"><b-img :src="bannersImg.assets ? bannersImg.assets[0].image_url : ''" fluid></b-img></div>
        <div class="about-description">
            <p>We bring Indonesia to the world.</p>
            <span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute 
                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
                sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetu adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </span>
      </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            bannersImg: [],
        }
    },

    created() {
        this.getBanner()
    },

    methods: {
        getBanner: function() {
            let self = this
            axios({
                method: 'post',
                url: '/api/v1/get-banner',
                data: {'banner_page':"banner_about_us"},
                headers: {
                    Authorization: 'Bearer '+self.token,
                },
            }).then((res) => {
                let data = res.data
                if(data.status) {
                    self.bannersImg = data.values.banner
                }
            })
        }
    }
}
</script>

<style>

</style>