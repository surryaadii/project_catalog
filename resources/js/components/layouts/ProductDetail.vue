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
                    <span><img src="" alt="">Share This Product</span>
                </div>
                <div class="product-title">
                    <h1>{{ productDetail.name }}</h1>
                </div>
                <div class="product-description">
                    <p>product description:</p>
                    <span>{{ productDetail.description }}</span>
                </div>
                <div class="product-action">
                    <a href="" class="btn btn-blue btn-action text-white">order this product</a>
                    <a href="" class="btn btn-white btn-action">ask about this product</a>
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
            slides: [
					'https://images.unsplash.com/photo-1453831362806-3d5577f014a4?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
					'https://images.unsplash.com/photo-1496412705862-e0088f16f791?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
					'https://images.unsplash.com/photo-1506354666786-959d6d497f1a?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
					'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
					'https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
					'https://images.unsplash.com/photo-1472926373053-51b220987527?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
					'https://images.unsplash.com/photo-1497534547324-0ebb3f052e88?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
                    'http://localhost:8000/storage/uploads/2021/04/07/05/Thumbnail BTG Web Tarakan (1).jpg'
				],
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
    mounted() {
        console.log(this.$refs)
    },
    methods: {
        getProductDetails: function() {
            let self = this
            console.log(self.$route.path);
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
                    let asssets = [];
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