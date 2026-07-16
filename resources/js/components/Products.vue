<template>
    <div>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">All Products</h1>
            <button
                @click="openAddModal"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm font-medium"
            >
                Add Product
            </button>
        </div>

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="text-left px-4 py-3">Product Name</th>
                        <th class="text-left px-4 py-3">Description</th>
                        <th class="text-left px-4 py-3">Price</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id" class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ product.product_name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ product.product_description }}</td>
                        <td class="px-4 py-3">${{ parseFloat(product.price).toFixed(2) }}</td>
                        <td class="px-4 py-3">
                            <span
                                :class="product.status === 'enabled'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'"
                                class="px-2 py-1 rounded text-xs font-medium"
                            >
                                {{ product.status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <button
                                @click="openEditModal(product)"
                                class="text-blue-600 hover:text-blue-800 text-xs font-medium"
                            >
                                Edit
                            </button>
                            <button
                                @click="toggleStatus(product)"
                                class="text-orange-600 hover:text-orange-800 text-xs font-medium"
                            >
                                {{ product.status === 'enabled' ? 'Disable' : 'Enable' }}
                            </button>
                        </td>
                    </tr>
                    <tr v-if="products.length === 0">
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            No products found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="showModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded shadow-lg w-full max-w-md mx-4 p-6">
                <h2 class="text-lg font-bold mb-4">{{ editingProduct ? 'Edit Product' : 'Add Product' }}</h2>

                <form @submit.prevent="submitForm">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input
                                v-model="form.product_name"
                                type="text"
                                required
                                class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea
                                v-model="form.product_description"
                                required
                                class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input
                                v-model="form.quantity"
                                type="number"
                                min="0"
                                required
                                class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
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
                                class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm font-medium"
                        >
                            {{ editingProduct ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
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
        this.fetchProducts();
    },
    methods: {
        async fetchProducts() {
            try {
                const res = await axios.get('/api/v1/products?include_disabled=1');
                this.products = res.data;
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
                await this.fetchProducts();
            } catch (e) {
                console.error('Failed to save product', e);
            }
        },
        async toggleStatus(product) {
            try {
                await axios.patch(`/api/v1/products/${product.id}/toggle-status`);
                await this.fetchProducts();
            } catch (e) {
                console.error('Failed to toggle status', e);
            }
        },
    },
};
</script>
