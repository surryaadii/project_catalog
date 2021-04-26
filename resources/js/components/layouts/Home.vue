<template>
    <div class="home-banner">
        <b-carousel
        id="carousel-1"
        :interval="5000"
        indicators
        img-height="768"
        >
            <template v-for="(bannerImg, i) in bannersImg.assets">
                <b-carousel-slide :key="i">
                    <template #img>
                        <img
                            class="d-block banner-img w-100"
                            :src="bannerImg.image_url"
                        >
                    </template>
                    <div class="carousel-caption-wrapper">
                        <template v-if="i == 0">
                            <h1 class="slogan-text">We bring Indonesian Product to the world.</h1> 
                        </template>
                        <template v-else>
                            <h2 class="slogan-text">We bring Indonesian Product to the world.</h2> 
                        </template>
                        <div class="wrapper-banner-button w-100 text-center">
                            <router-link :to="{ name: 'products' }" custom v-slot="{ href, navigate, isExactActive }">
                                <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="btn btn-white btn-banner" :class="isExactActive ? 'active' : '' ">See Our Products</a>
                            </router-link>
                            <router-link :to="'#'" custom v-slot="{ href, navigate, isExactActive }">
                                <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="btn btn-white btn-banner" :class="isExactActive ? 'active' : '' ">Learn More</a>
                            </router-link>
                        </div>
                    </div>
                </b-carousel-slide>
            </template>
        </b-carousel>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            bannersImg: [],
            token: '',
        }
    },
    created() {
        this.token = this.$cookies.get('auth_token')
        this.getBanner()
    },
    methods: {
        getBanner:function() {
            let self = this
            axios({
                method: 'post',
                url: '/api/v1/get-banner',
                data: {'banner_page':"banner_home"},
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