<template>
    <div class="container products">
        <div class="row row-filter">
            <div class="product-filter">
                <a class="btn btn-filter filter-item" :class="category.slug == filterCategory ? 'active' : ''" v-for="(category, i) in categories" :key="i" @click="getProducts(1, category.slug, searchText)">
                    {{category.name}}
                </a>
            </div>
            <div class="product-main-search">
                <span>
                    <b-icon icon="search" font-scale="1.5"></b-icon>
                </span>
                <b-form-input
                    id="input-search-product"
                    v-model="searchText"
                    type="text"
                    placeholder="Search"
                    debounce="500"
                    @update="getProducts(1, filterCategory, searchText)"
                ></b-form-input>
            </div>
        </div>
        <div class="row" v-for="(rowProducts, i) in products" :key="i">
            <div class="col-md-3 product-item" v-for="(product, j) in rowProducts" :key="j">
                <b-skeleton-wrapper :loading="isLoading">
                    <template #loading>
                        <div class="wrapper-product">
                            <div class="product-image">
                                <b-skeleton-img height="203px"></b-skeleton-img>
                            </div>
                            <div class="product-detail">
                                <b-skeleton width="85%"></b-skeleton>
                                <b-skeleton width="45%"></b-skeleton>
                            </div>
                        </div>
                    </template>

                    <div class="wrapper-product">
                        <div class="product-image">
                            <span class="product-new" v-if="product.is_new"> new </span>
                            <img :src="product.assets.length ? product.assets[0] : 'https://placekitten.com/480/210'" alt="" class="img-fluid">
                        </div>
                        <div class="product-detail">
                            <p class="product-title mb-0">{{ product.name }}</p>
                            <div class="product-action">
                                <span class="product-action-icon">
                                    <img src="/assets/frontend/images/caret-right.svg" alt="product-link">
                                </span>
                                <a class="product-action-link" href="#">See Product Detail</a>
                            </div>
                        </div>
                    </div>
                </b-skeleton-wrapper>
            </div>
        </div>
        <div class="pagination-products" v-if="!isLoading">
            <span class="pagination-icon" :class="( summary.max_page <= summary.current_page && summary.max_page > 1 ) ? '' : 'disabled'" @click="getProducts(summary.current_page-1, filterCategory, searchText)">
                <img :src="( summary.max_page <= summary.current_page && summary.max_page > 1) ? `/assets/frontend/images/caret-left.svg` : `/assets/frontend/images/caret-left-disabled.svg`" alt="">
            </span>
            <span class="pagination-page">{{ summary.current_page }}</span>
            <span class="pagination-icon" :class="summary.max_page > summary.current_page ? '' : 'disabled' " @click="getProducts(summary.current_page+1, filterCategory, searchText)">
                <img :src="summary.max_page > summary.current_page ? `/assets/frontend/images/caret-right.svg` : `/assets/frontend/images/caret-right-disabled.svg`" alt="">
            </span>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash'
export default {
    data() {
        return {
            token: '',
            isLoading: true,
            products: [],
            categories: [],
            searchText: '',
            filterCategory: '',
            summary: {
                current_page: 1,
                end: 0,
                max_page: 0,
                per_page: 6,
                start: 1,
                total_row: 0,
            },
        }
    },

    created() {
        this.token = this.$cookies.get('auth_token')
        this.getProducts(this.summary.current_page)
        this.getCategories()
    },

    methods: {
        getCategories:function () {
            let self = this
            axios({
                method: 'GET',
                url: '/api/v1/categories',
                headers: {
                    Authorization: 'Bearer '+self.token,
                },
            }).then( (res) => {
                let data = res.data
                if(data.status) {
                    self.categories = data.values.categories
                }
            })
        },

        getProducts:function (page, filter, search) {
            let self = this
            self.isLoading = true
            let url = '/api/v1/products'
            url = url+`?page=${page}&per_page=${self.summary.per_page}`
            if(!self.isBlank(filter)) {
                self.filterCategory = filter
                url = url+`&category=${filter}`
            }
            if(!self.isBlank(search)) {
                url = url+`&q=${search}`
            }
            axios({
                method: 'GET',
                url: url,
                headers: {
                    Authorization: 'Bearer '+self.token,
                },
            }).then((res) => {
                let data = res.data
                if(data.status) {
                    let products = data.values.products
                    self.products = _.chunk(products, 4);
                    self.summary = data.values.summary

                    setTimeout( () => {
                        self.isLoading = false;
                    }, 1000)
                }
            })
        }
    }
}
</script>

<style>

</style>