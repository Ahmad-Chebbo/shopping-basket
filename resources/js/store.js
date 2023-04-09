import {createStore} from 'vuex'

export default createStore({
    state: {
        cart: {},
        cartCount: 0,
    },
    mutations: {
        SET_CART(state, cart) {
            state.cart = cart;
            if(cart != null) {
                state.cartCount = cart.products ? cart.products.reduce((total, product) => {
                    return total + product.pivot.quantity;
                }, 0) : 0;
            }
        }
    },
    actions: {
        fetchCart({commit}) {
            // Make an API call to fetch cart data from the backend
            axios.get('/api/cart')
            .then(response => {
                commit('SET_CART', response.data.data.cart)
            })
            .catch(error => {
                console.error('Failed to fetch cart:', error);
            });
        },
        addCartItem({commit, state}, product){
            let cart = state.cart || { products: [] };
            let item = cart.products.find(item => item.id === product.id);
            if (item) {
                item.pivot.quantity++;
            } else {
                cart.products.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    pivot: {
                        quantity: 1,
                        total: product.price
                    }
                });
            }
            commit('SET_CART', cart);
        },
        removeFromCart({ commit, state }, product) {
            let cart = state.cart
            cart.products = cart.products.filter(item => item.id !== product.id)
            commit('SET_CART', cart)
        },
        clearCart() {
            let cart = state.cart;
            cart = {};
            commit('SET_CART', cart);
        }
    }
});
