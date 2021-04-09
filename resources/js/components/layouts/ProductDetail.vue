<template>
  <div class="container product-detail-page">
        <div class="product-detail-navigation">
            <router-link :to="{ name: 'products' }" custom v-slot="{ href, navigate }">
                <a :href="href" @click="navigate" @keypress.enter="navigate" role="link">
                    <span class="product-navigation-icon">
                        <img src="/assets/frontend/images/caret-left.svg">
                    </span>
                    <span class="product-navigation-text">Back to Product Page</span>
                </a>
            </router-link>
        </div>
        <div class="product-detail">
            <div class="product-detail-left">
                <div>
                    <agile class="product-image-preview" ref="c1" :options="options1" :as-nav-for="asNavFor1" :key="assets.length">
                        <div class="slide" v-for="(slide, index) in assets" :key="index" :class="`slide--${index}`"><img :src="slide"/></div>
                    </agile>
                </div>
                <div>
                    <agile class="product-image-thumbnails" ref="c2" :options="options2" :as-nav-for="asNavFor2" :key="assets.length">
                        <div class="slide slide--thumbnail" v-for="(slide, index) in assets" :key="index" :class="`slide--${index}`" @click="$refs.c2.goTo(index)"><img :src="slide"/></div>
                        <template slot="prevButton">
                            <img src="/assets/frontend/images/caret-left.svg" alt="">
                        </template>
                        <template slot="nextButton">
                            <img src="/assets/frontend/images/caret-right.svg" alt="">
                        </template>
                    </agile>
                </div>
            </div>
            <div class="product-detail-right">
                <div class="share-product">
                    <span><img src="/assets/frontend/images/share-icon.svg" alt=""> Share This Product</span>
                </div>
                <div class="product-title">
                    <h1>{{ productDetail.name }}</h1>
                </div>
                <div class="product-description">
                    <p>product description:</p>
                    <span>{{ productDetail.description }}</span>
                </div>
                <div class="product-action">
                    <router-link :to="{ name: 'contact' }" custom v-slot="{ href, navigate }">
                        <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="btn btn-blue btn-action text-white">order this product</a>
                    </router-link>
                    <a :href="`https://wa.me/628989224842?text=i want to ask about product ${ productDetail.name } ` " target="_blank" class="btn btn-white btn-action">ask about this product</a>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            slug: '',
            token: '',
            productDetail: [],
            assets: [],
            asNavFor1: [],
			asNavFor2: [],
            options1: {
				dots: false,
				fade: true,
				navButtons: false
			},
			
			options2: {
				autoplay: false,
				centerMode: true,
				dots: false,
				navButtons: true,
				slidesToShow: 3,
				responsive: [
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 1000,
                        settings: {
                            navButtons: true
                        }
                    }
                ]
				
			},
        }
    },

    created() {
        this.token = this.$cookies.get('auth_token')
        this.getProductDetails()
    },
    methods: {
        getProductDetails: function() {
            let self = this
            self.slug = self.$route.params.slug
            axios({
                method: 'GET',
                url: `/api/v1/product/${self.slug}`,
                headers: {
                    Authorization: 'Bearer '+self.token,
                },
            }).then( (res) => {
                let data = res.data
                if(data.status) {
                    self.productDetail = data.values.product
                    for (let index = 0; index < self.productDetail.assets.length; index++) {
                        const assetProducts = self.productDetail.assets[index];
                        self.assets.push(assetProducts.url)
                    }
                }
            }).then(() => {
                self.$refs.c1.reload()
                self.$refs.c2.reload()
                self.asNavFor1.push(self.$refs.c2)
		        self.asNavFor2.push(self.$refs.c1)
            })
        }
    }
}
</script>

<style>

</style>