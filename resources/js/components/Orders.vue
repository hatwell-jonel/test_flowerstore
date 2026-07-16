<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Orders</h1>

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="text-left px-4 py-3">Order ID</th>
                        <th class="text-left px-4 py-3">Product Name</th>
                        <th class="text-left px-4 py-3">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders" :key="order.id" class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ order.id }}</td>
                        <td class="px-4 py-3">{{ order.product?.product_name }}</td>
                        <td class="px-4 py-3">${{ parseFloat(order.price).toFixed(2) }}</td>
                    </tr>
                    <tr v-if="orders.length === 0">
                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                            No orders found.
                        </td>
                    </tr>
                </tbody>
                <tfoot v-if="orders.length > 0" class="bg-gray-50 font-semibold">
                    <tr class="border-t-2 border-gray-300">
                        <td class="px-4 py-3" colspan="1">Total Orders: {{ orders.length }}</td>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3">${{ totalPrice.toFixed(2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            orders: [],
        };
    },
    computed: {
        totalPrice() {
            return this.orders.reduce((sum, o) => sum + parseFloat(o.price), 0);
        },
    },
    mounted() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            try {
                const res = await axios.get('/api/v1/orders');
                this.orders = res.data;
            } catch (e) {
                console.error('Failed to fetch orders', e);
            }
        },
    },
};
</script>
