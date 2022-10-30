<template>

    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by Category</h5>
                    <form>
                        <div
                            class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">All Category</label>

                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3"
                            v-for="category in categories" :key="category.id">
                            <input type="checkbox" class="custom-control-input" :id="category.id"
                                @change="getFilterProducts()" :value="category.id" v-model="categoryId">
                            <label class="custom-control-label" :for="category.id">{{ category.name }}</label>
                        </div>
                    </form>
                </div>
                <!-- Price End -->

                <!-- Color Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by Brand</h5>
                    <form>
                        <div
                            class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="brand-all">
                            <label class="custom-control-label" for="price-all">All Brand</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3"
                            v-for="brand in brands" :key="brand.id">
                            <input type="checkbox" class="custom-control-input" :id="brand.id"
                                @change="getFilterProducts()" :value="brand.id" v-model="brandId">
                            <label class="custom-control-label" :for="brand.id">{{ brand.name }}</label>
                        </div>
                    </form>
                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by name">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1" v-for="product in products" :key="product.id">
                        <div class="card product-item border-0 mb-4">
                            <div
                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" :src="'/public/image/' + product.image" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{ product.name }}</h6>
                                <div class="d-flex justify-content-center">

                                    <h6>${{ product.price }}</h6>
                                    <h6 class="text-muted ml-2"></h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-eye text-primary mr-1"></i>View
                                    Detail</a>
                                <a href="" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { response } from 'express';


export default {
    data() {
        return {
            categories: [],
            brands: [],
            products: [],
            categoryId: [],
            brandId: [],

        }
    },

    created() {
        this.getAllCategories();
        this.getAllBrands();
        this.getAllProducts();
    },

    methods: {
        getAllCategories() {
            axios.get('/get/all/categories')
                .then(response => {
                    this.categories = response.data
                }).catch(error => {
                    console.log(error)
                })
        },
        getAllBrands() {
            axios.get('/get/all/brands')
                .then(response => {
                    this.brands = response.data
                }).catch(error => {
                    console.log(error)
                })
        },

        getAllProducts() {
            axios.get('/get/all/products')
                .then(response => {
                    this.products = response.data
                }).catch(error => {
                    console.log(error)
                })
        },

        getFilterProducts() {
            axios.post('/get/filter/products', { category_id: this.categoryId, brand_id: this.brandId })
                .then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error)
                })
        }
    }
}

</script>
