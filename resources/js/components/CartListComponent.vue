<template>
    <div class="container">
        <div class="row mb-5">
            <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody></tbody>

                        <tbody v-if="!$store.state.cart.products || $store.state.cart.products.length === 0" >
                            <tr class="text-center">
                                <td colspan="6">Cart is empty</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="item in $store.state.cart.products" :key="item.id">
                                <td class="product-thumbnail">
                                    <img :src="item.image" :alt="item.name" class="img-fluid">
                                </td>
                                <td class="product-name">
                                    <h2 class="h5 text-black">{{ item.name }}</h2>
                                </td>
                                <td>${{ item.pivot.price }}</td>
                                <td class="text-center">
                                    {{ item.pivot.quantity }}
                                </td>
                                <td>${{ item.pivot.total }}</td>
                                <td><a href="" @click.prevent="removeFromCart(item)" class="btn btn-black btn-sm">X</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">Subtotal</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">${{ this.subtotal }}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">Tax</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">5%</strong>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <span class="text-black">Total</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">${{ this.total }}</strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary py-3 btn-block">Proceed To Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        computed: {
            subtotal() {
                const products = this.$store.state.cart.products;
                if (!products || products.length === 0) {
                    return 0;
                }
                const subtotal = products.reduce((total, item) => {
                    return total + parseFloat(item.pivot.total);
                }, 0);
                return Number(subtotal.toFixed(2));
            },
            total() {
                const taxRate = 0.05;
                const total = this.subtotal * (1 + taxRate);
                return Number(total.toFixed(2));
            },
        },
        methods: {
            removeFromCart(item) {
                const productId = item.id;
                axios.post("/api/cart/remove", {
                    product_id: productId
                })
                .then(() => {
                    this.$store.dispatch('removeFromCart', item);
                    toastr.success('Product removed from the cart!');
                })
                .catch(error => {
                    console.error("Failed to remove item from cart", error);
                });
            },
        }
    }
</script>
