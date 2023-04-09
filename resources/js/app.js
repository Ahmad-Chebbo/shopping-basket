/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import NavbarCartComponent from './components/NavbarCartComponent.vue';
import ProductListComponent from './components/ProductListComponent.vue';
import CartListComponent from './components/CartListComponent.vue';
import VueCookies from 'vue3-cookies'
import store from './store';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

app.component('navbar-cart-component', NavbarCartComponent);
app.component('product-list-component', ProductListComponent);
app.component('cart-list-component', CartListComponent);


// Get the API token from the local storage of the browser
const apiToken = localStorage.getItem('auth-token');
// Set the API token in a variable
window.apiToken = apiToken;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(store).use(VueCookies).mount('#app');
