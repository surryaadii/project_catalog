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
                <div class="row m-0">
                    <div class="col-md-12 p-0">
                        <splide
                            :options="previewOptions"
                            ref="primary"
                            :slides="assets"
                            class="splide-preview mx-auto"
                        >
                            <splide-slide v-for="slide in assets" :key="slide">
                                <img :src="slide" alt="slide.alt">
                            </splide-slide>
                        </splide>
                    </div>
                    <div class="col-md-12 p-0">
                        <splide
                            :options="thumbnailOptions"
                            ref="secondary"
                            :slides="assets"
                            class="splide-thumbnail"
                        >
                            <splide-slide v-for="slide in assets" :key="slide">
                                <img :src="slide" alt="slide.alt">
                            </splide-slide>
                        </splide>
                    </div>
                </div>
            </div>
            <div class="product-detail-right">
                <div class="share-product">
                    <span id="clipboard-event" :data-clipboard="currentUrl"><img src="/assets/frontend/images/share-icon.svg" alt=""> Share This Product</span>
                    <b-tooltip ref="tooltip-clipboard" triggers="click" :disabled="true" target="clipboard-event">
                        Link share copied !
                    </b-tooltip>
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

            previewOptions: {
                type       : 'fade',
                heightRatio: 0.5,
                width:  500,
                height: 408,
                pagination : false,
                arrows     : false,
                cover      : true,
                breakpoints : {
                    '520': {
                        width: 300,
                        height: 300,
                    }
                }
	      },
	      thumbnailOptions: {
                type:'loop',
                width       : 480,
                height     : 107,
                gap        : 31,
                rewind     : true,
                cover      : true,
                pagination : false,
                focus      : 'center',
                isNavigation: true,
                perPage: 3,
                padding: {
                    left : 30,
                    right: 30,
                },
                breakpoints : {
                    '520': {
                        width: 300,
                        height: 70,
                    }
                }
	        },
        }
    },

    created() {
        this.token = this.$cookies.get('auth_token')
        this.getProductDetails()
    },
    computed: {
        currentUrl() {
            return window.location.origin + this.$route.fullPath
        }
    },
    mounted() {
        setTimeout(() => { this.$refs.primary.sync(this.$refs.secondary.splide) }, 500)
        this.clipboard()
    },
    methods: {
        clipboard: function() {
            let self = this
            document.querySelectorAll('[data-clipboard]').forEach( (item) => {
                item.addEventListener('click', () => {
                    let value = item.getAttribute('data-clipboard')
                    let status = self.clipboardText(value)
                    // console.log(self.$refs.tooltip-clipboard)
                    if (status == 'successful') {
                        self.$refs["tooltip-clipboard"].$emit('enable')
                        self.$refs["tooltip-clipboard"].$emit('open')
                    }
                    setTimeout( () => {
                        self.$refs["tooltip-clipboard"].$emit('close')
                        self.$refs["tooltip-clipboard"].$emit('disable')
                    },2000)
                })
            })
        },
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
            })
        }
    }
}
</script>

<style>

</style>