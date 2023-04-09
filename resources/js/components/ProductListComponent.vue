<template>
    <div class="row">

        <!-- Start Column 1 -->
        <div class="col-12 col-md-4 col-lg-3 mb-5"  v-for="product in products" :key="product.id">
            <a class="product-item" href="#">
                <img :src="product.image" class="img-fluid product-thumbnail">
                <h3 class="product-title">{{ product.name }}</h3>
                <div v-if="product.discount_price">
                    <del class="text-muted me-2">{{ product.price }}</del>
                    <strong class="product-price">{{ product.discount_price }}</strong>
                </div>
                <div v-else>
                    <strong class="product-price">{{ product.price }}</strong>
                </div>
                <span class="icon-cross" @click.prevent="addToCart(product)">
                <img src="/front/images/cross.svg" class="img-fluid">
                </span>
            </a>
        </div>
        <!-- End Column 1 -->


    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: [], // Products data from backend
            };
        },
        methods: {
            // Add product to cart
            addToCart(product) {
                // Make API request to add product to cart
                // Update cart count and emit event
                axios.post('/api/cart/add', {
                        product_id: product.id,
                        quantity: 1,
                    })
                    .then(() => {
                        this.$store.dispatch('addCartItem', product);
                        toastr.success('Product added to cart!');
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            toastr.error('Please login or register first');
                        } else {
                            console.log(error);
                        }
                    });
            },
            fetchProducts() {
                // Make an API call or fetch products data from server
                axios.get('/api/products')
                    .then(response => {
                        this.products = response.data.data.products;
                    })
                    .catch(error => {
                        console.error('Failed to fetch products:', error);
                    });
            },
        },
        mounted() {
            this.fetchProducts();
        }
    }
</script>

