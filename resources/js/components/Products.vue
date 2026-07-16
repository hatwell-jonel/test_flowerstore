<template>
    <div>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-display font-semibold text-rose-900">All Products</h1>
            <button
                @click="openAddModal"
                class="bg-rose-600 text-white px-4 py-2 rounded hover:bg-rose-700 text-sm font-medium"
            >
                Add Product
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-md ring-1 ring-rose-100 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-rose-50 text-rose-700 uppercase text-xs">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold">Product Name</th>
                        <th class="text-left px-4 py-3 font-semibold">Description</th>
                        <th class="text-left px-4 py-3 font-semibold">Price</th>
                        <th class="text-left px-4 py-3 font-semibold">Status</th>
                        <th class="text-left px-4 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id" class="border-t border-rose-100 hover:bg-amber-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ product.product_name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ product.product_description }}</td>
                        <td class="px-4 py-3 text-gray-700">${{ parseFloat(product.price).toFixed(2) }}</td>
                        <td class="px-4 py-3">
                            <span
                                :class="product.status === 'enabled'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-rose-100 text-rose-700'"
                                class="px-2 py-1 rounded text-xs font-medium"
                            >
                                {{ product.status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 space-x-3">
                            <button
                                @click="openEditModal(product)"
                                class="text-rose-600 hover:text-rose-800 text-xs font-medium"
                            >
                                Edit
                            </button>
                            <button
                                @click="toggleStatus(product)"
                                class="text-amber-600 hover:text-amber-800 text-xs font-medium"
                            >
                                {{ product.status === 'enabled' ? 'Disable' : 'Enable' }}
                            </button>
                        </td>
                    </tr>
                    <tr v-if="products.length === 0">
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No products found.
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="pagination.last_page > 1" class="flex items-center justify-between px-4 py-3 border-t border-rose-100 text-sm">
                <span class="text-gray-500">
                    Page {{ pagination.current_page }} of {{ pagination.last_page }}
                </span>
                <div class="flex space-x-2">
                    <button
                        :disabled="pagination.current_page <= 1"
                        @click="fetchProducts(pagination.current_page - 1)"
                        class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-rose-50 disabled:opacity-40 disabled:cursor-not-allowed text-xs"
                    >
                        Previous
                    </button>
                    <button
                        :disabled="pagination.current_page >= pagination.last_page"
                        @click="fetchProducts(pagination.current_page + 1)"
                        class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-rose-50 disabled:opacity-40 disabled:cursor-not-allowed text-xs"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 border-t-4 border-t-rose-500">
                <div class="p-6">
                    <h2 class="text-lg font-display font-semibold text-rose-900 mb-4">{{ editingProduct ? 'Edit Product' : 'Add Product' }}</h2>

                    <form @submit.prevent="submitForm">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                                <input
                                    v-model="form.product_name"
                                    type="text"
                                    required
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-rose-500 focus:border-rose-500"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea
                                    v-model="form.product_description"
                                    required
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-rose-500 focus:border-rose-500"
                                ></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input
                                    v-model="form.quantity"
                                    type="number"
                                    min="0"
                                    required
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-rose-500 focus:border-rose-500"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <input
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-rose-500 focus:border-rose-500"
                                />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <button
                                type="button"
                                @click="closeModal"
                                class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="bg-rose-600 text-white px-4 py-2 rounded hover:bg-rose-700 text-sm font-medium"
                            >
                                {{ editingProduct ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
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
            products: [],
            pagination: { current_page: 1, last_page: 1 },
            showModal: false,
            editingProduct: null,
            form: {
                product_name: '',
                product_description: '',
                quantity: 0,
                price: 0,
            },
        };
    },
    mounted() {
        this.fetchProducts(1);
    },
    methods: {
        async fetchProducts(page = 1) {
            try {
                const res = await axios.get(`/api/v1/products?include_disabled=1&page=${page}`);
                this.products = res.data.data;
                this.pagination = { current_page: res.data.current_page, last_page: res.data.last_page };
            } catch (e) {
                console.error('Failed to fetch products', e);
            }
        },
        openAddModal() {
            this.editingProduct = null;
            this.form = { product_name: '', product_description: '', quantity: 0, price: 0 };
            this.showModal = true;
        },
        openEditModal(product) {
            this.editingProduct = product;
            this.form = {
                product_name: product.product_name,
                product_description: product.product_description,
                quantity: product.quantity,
                price: product.price,
            };
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.editingProduct = null;
        },
        async submitForm() {
            try {
                if (this.editingProduct) {
                    await axios.put(`/api/v1/products/${this.editingProduct.id}`, this.form);
                } else {
                    await axios.post('/api/v1/products', this.form);
                }
                this.closeModal();
                await this.fetchProducts(this.pagination.current_page);
            } catch (e) {
                console.error('Failed to save product', e);
            }
        },
        async toggleStatus(product) {
            try {
                await axios.patch(`/api/v1/products/${product.id}/toggle-status`);
                await this.fetchProducts(this.pagination.current_page);
            } catch (e) {
                console.error('Failed to toggle status', e);
            }
        },
    },
};
</script>
