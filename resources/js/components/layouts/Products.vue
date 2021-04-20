<template>
    <div class="container products-page">
        <Modal :isShowing="showModal" @close="showModal = false" ref="modal" class="search-modal">
            <template slot="float-button-close">
                <span class="modal-floating-close-button" @click="$refs.modal.$emit('close')">
                    <b-icon icon="x" font-scale="3.3"></b-icon>
                </span>
            </template>
            <div slot="body" class="search-modal-body">
                <div class="modal-search-category">
                    <div class="modal-search-category-title" @click="openCategorySearchItem('.modal-search-category-title', '.category-option-list')">
                        <span>Categories</span>
                        <img svg-inline class="icon icon-inline" src="@assets/frontend/images/caret-top-no-background.svg" />
                    </div>
                    <div class="category-option-list">
                        <div class="option-list" v-for="(category, i) in categories" :key="i" @click.prevent="selectCategorySearchItem('.modal-search-category-title','.category-option-list', category.slug)">
                            <label :for="`option-list-${i}`" class="mb-0">
                                <input
                                    type="radio"
                                    :id="`option-list-${i}`"
                                    :value="category.slug"
                                    v-model="filterCategory"
                                >
                            </label>
                            <label :for="`option-list-${i}`" class="mb-0">
                                <p class="mb-0">{{category.name}}</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-separator"></div>
                <div class="modal-search-input">
                    <b-form-input
                        id="input-search-product"
                        v-model="searchText"
                        type="text"
                        placeholder="Search Something"
                        autocomplete="off"
                        @change="getProducts(1, filterCategory, searchText)"
                    ></b-form-input>
                    <b-icon icon="search" font-scale="1.5"></b-icon>
                </div>
            </div>
        </Modal>
        <div class="row row-filter">
            <div class="product-filter">
                <a class="btn btn-filter filter-item" :class="filterCategory == '' ? 'active' : ''" @click="getProducts(1, 'All', searchText)"> All </a>
                <a class="btn btn-filter filter-item" :class="category.slug == filterCategory ? 'active' : ''" v-for="(category, i) in categories" :key="i" @click="getProducts(1, category.slug, searchText)">
                    {{category.name}}
                </a>
            </div>
            <div class="product-main-search" @click="showModal = true">
                <span class="product-search-icon">
                    <b-icon icon="search" font-scale="1.5"></b-icon>
                </span>
                <span class="product-search-title d-none d-sm-block">Search</span>
            </div>
        </div>
        <div class="list-products">
            <b-skeleton-wrapper :loading="isLoading">
                <template #loading>            
                    <div class="row">
                        <div class="col-md-3 col-sm-6 product-item">
                            <div class="wrapper-item">
                                <div class="item-image">
                                    <b-skeleton-img></b-skeleton-img>
                                </div>
                                <div class="item-detail">
                                    <b-skeleton width="85%"></b-skeleton>
                                    <b-skeleton width="45%"></b-skeleton>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 product-item">
                            <div class="wrapper-item">
                                <div class="item-image">
                                    <b-skeleton-img></b-skeleton-img>
                                </div>
                                <div class="item-detail">
                                    <b-skeleton width="85%"></b-skeleton>
                                    <b-skeleton width="45%"></b-skeleton>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 product-item">
                            <div class="wrapper-item">
                                <div class="item-image">
                                    <b-skeleton-img></b-skeleton-img>
                                </div>
                                <div class="item-detail">
                                    <b-skeleton width="85%"></b-skeleton>
                                    <b-skeleton width="45%"></b-skeleton>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </b-skeleton-wrapper>
            <template v-if="products.length > 0">
                <template v-if="!isLoading">
                    <div class="count-search-products" v-if="searchText.length > 0"><span>{{summary.end}} of {{summary.total_row}} Search Result for “{{searchText}}”</span></div>
                    <div class="row" v-for="(rowProducts, i) in products" :key="i">
                        <div class="col-md-3 col-sm-6 product-item" v-for="(product, j) in rowProducts" :key="j">
                            <div class="wrapper-item">
                                <div class="item-image">
                                    <span class="item-new" v-if="product.is_new"> new </span>
                                    <img :src="product.assets.length ? product.assets[0].url : `https://source.unsplash.com/random/500x500?sig=${ Math.floor(Math.random() * 123) + Math.floor(Math.random() * 123) }`" alt="" class="img-fluid">
                                </div>
                                <div class="item-detail">
                                    <p class="item-title mb-0">{{ product.name }}</p>
                                    <div class="item-action">
                                        <span class="item-action-icon">
                                            <img svg-inline class="icon icon-inline" src="@assets/frontend/images/caret-right.svg" />
                                        </span>
                                        <router-link :to="{ name: 'productDetail', params:{ slug: product.slug }  }" custom v-slot="{ href, navigate }">
                                            <a :href="href" @click="navigate" @keypress.enter="navigate" role="link" class="item-action-link">See Product Detail</a>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
            <template v-else-if="products.length < 1 && !isLoading">
                <p>Product not found</p>
            </template>
        </div>
        <div class="pagination-products" v-if="!isLoading && products.length > 0">
            <span class="pagination-icon" :class="summary.current_page > 1 ? '' : 'disabled'" @click="getProducts(summary.current_page-1, filterCategory, searchText)">
                <img svg-inline v-if="summary.current_page > 1 " class="icon icon-inline" src="@assets/frontend/images/caret-left.svg" />
                <img svg-inline v-else class="icon icon-inline" src="@assets/frontend/images/caret-left-disabled.svg" />
            </span>
            <span class="pagination-page">{{ summary.current_page }}</span>
            <span class="pagination-icon" :class="summary.max_page > summary.current_page ? '' : 'disabled' " @click="getProducts(summary.current_page+1, filterCategory, searchText)">
                <img svg-inline v-if="summary.max_page > summary.current_page " class="icon icon-inline" src="@assets/frontend/images/caret-right.svg" />
                <img svg-inline v-else class="icon icon-inline" src="@assets/frontend/images/caret-right-disabled.svg" />
            </span>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash'
import Modal from '../Modal'
export default {
    data() {
        return {
            token: '',
            isLoading: true,
            showModal: false,
            products: [],
            categories: [],
            searchText: '',
            filterCategory: '',
            summary: {
                current_page: 1,
                end: 0,
                max_page: 0,
                per_page: 8,
                start: 1,
                total_row: 0,
            },
        }
    },

    components: {
        Modal,
    },

    created() {
        this.token = this.$cookies.get('auth_token')
        this.getProducts(this.summary.current_page)
        this.getCategories()
    },

    methods: {
        openCategorySearchItem: function(classEleModal, classEle) {
            let elements = document.querySelectorAll(`${classEleModal}, ${classEle}`)
            elements.forEach(ele => {
                ele.classList.contains('opened') ? ele.classList.remove('opened') : ele.classList.add('opened')
            });
        },
        selectCategorySearchItem: function(classEleModal, classEle, value) {
            this.openCategorySearchItem(classEleModal, classEle)
            this.filterCategory = value
        },
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
                self.filterCategory = filter == 'All' ? '' : filter
                url = url+`&category=${self.filterCategory}`
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
                }
                setTimeout( () => {
                    self.isLoading = false;
                }, 1000)
            })
        }
    }
}
</script>