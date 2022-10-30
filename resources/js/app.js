
require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('example-componen', require('./components/ExampleComponent.vue').default);
Vue.component('search', require('./components/Search.vue').default);
Vue.component('product-list', require('./components/Product.vue').default);

const app = new Vue({
    el: '#app',
});
