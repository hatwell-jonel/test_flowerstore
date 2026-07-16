import { createRouter, createWebHistory } from 'vue-router';
import Products from '../components/Products.vue';
import Orders from '../components/Orders.vue';

const routes = [
    { path: '/', redirect: '/products' },
    { path: '/products', name: 'Products', component: Products },
    { path: '/orders', name: 'Orders', component: Orders },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
