<template>
  <div class="container about-page">
        <div class="about-title"><h1>About Us</h1></div>
        <div class="about-image"><b-img :src="pageData.assets ? pageData.assets[0].image_url : ''" fluid></b-img></div>
        <div class="about-description" v-html="pageData.content">
      </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            pageData: [],
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
                url: '/api/v1/get-page',
                data: {'slug':self.$route.name},
                headers: {
                    Authorization: 'Bearer '+self.token,
                },
            }).then((res) => {
                let data = res.data
                if(data.status) {
                    self.pageData = data.values.page
                }
            })
        }
    }
}
</script>

<style>

</style>