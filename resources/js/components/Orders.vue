<template>
    <div>
        <h1 class="text-2xl font-display font-semibold text-rose-900 mb-6">Orders</h1>

        <div class="bg-white rounded-lg shadow-md ring-1 ring-rose-100 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-rose-50 text-rose-700 uppercase text-xs">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold">Order ID</th>
                        <th class="text-left px-4 py-3 font-semibold">Product Name</th>
                        <th class="text-left px-4 py-3 font-semibold">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders" :key="order.id" class="border-t border-rose-100 hover:bg-amber-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ order.id }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ order.product?.product_name }}</td>
                        <td class="px-4 py-3 text-gray-700">${{ parseFloat(order.price).toFixed(2) }}</td>
                    </tr>
                    <tr v-if="orders.length === 0">
                        <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                            No orders found.
                        </td>
                    </tr>
                </tbody>
                <tfoot v-if="orders.length > 0" class="bg-rose-50">
                    <tr class="border-t-2 border-rose-200 font-semibold">
                        <td class="px-4 py-3 text-rose-800 text-sm">Orders on this page: {{ orders.length }}</td>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3 text-rose-800">Page Total: ${{ pageTotal.toFixed(2) }}</td>
                    </tr>
                    <tr class="border-t border-rose-100 font-semibold">
                        <td class="px-4 py-3 text-rose-800 text-sm">All orders: {{ pagination.total }}</td>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3 text-rose-800">Grand Total: ${{ grandTotal.toFixed(2) }}</td>
                    </tr>
                </tfoot>
            </table>
            <div v-if="pagination.last_page > 1" class="flex items-center justify-between px-4 py-3 border-t border-rose-100 text-sm">
                <span class="text-gray-500">
                    Page {{ pagination.current_page }} of {{ pagination.last_page }}
                </span>
                <div class="flex space-x-2">
                    <button
                        :disabled="pagination.current_page <= 1"
                        @click="fetchOrders(pagination.current_page - 1)"
                        class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-rose-50 disabled:opacity-40 disabled:cursor-not-allowed text-xs"
                    >
                        Previous
                    </button>
                    <button
                        :disabled="pagination.current_page >= pagination.last_page"
                        @click="fetchOrders(pagination.current_page + 1)"
                        class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-rose-50 disabled:opacity-40 disabled:cursor-not-allowed text-xs"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            orders: [],
            pagination: { current_page: 1, last_page: 1, total: 0 },
            grandTotal: 0,
        };
    },
    computed: {
        pageTotal() {
            return this.orders.reduce((sum, o) => sum + parseFloat(o.price), 0);
        },
    },
    mounted() {
        this.fetchOrders(1);
    },
    methods: {
        async fetchOrders(page = 1) {
            try {
                const res = await axios.get(`/api/v1/orders?page=${page}`);
                this.orders = res.data.data;
                this.pagination = { current_page: res.data.current_page, last_page: res.data.last_page, total: res.data.total };
                this.grandTotal = res.data.grand_total;
            } catch (e) {
                console.error('Failed to fetch orders', e);
            }
        },
    },
};
</script>
