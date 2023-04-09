<template>
    <div class="navbar-cart">
        <a href="/cart">
            <img src="/front/images/cart.svg" alt="Cart">
            <div class="cart-item-count">{{ $store.state.cartCount }}</div>
        </a>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
    export default {
        created() {
            this.fetchCart()
        },
        computed: {
            ...mapState(['cartCount', 'cart'])
        },
        methods: {
            ...mapActions(['fetchCart'])
        }
    }
</script>

<style>
.navbar-cart {
    position: relative;
    display: inline-block;
}

.cart-item-count {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: #f00;
    color: #fff;
    border-radius: 50%;
    padding: 5px;
    font-size: 12px;
}
</style>
