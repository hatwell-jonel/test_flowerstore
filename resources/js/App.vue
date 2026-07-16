<template>
    <div class="min-h-screen bg-amber-50">
        <nav class="bg-white shadow-sm">
            <div class="max-w-4xl mx-auto px-4 flex items-center justify-between">
                <span class="font-display text-xl text-rose-700 font-semibold">Flower Store</span>
                <div class="flex space-x-6">
                    <router-link
                        to="/products"
                        class="py-4 px-2 font-medium text-sm border-b-2 border-transparent hover:text-rose-600 hover:border-rose-500 text-gray-600"
                        active-class="border-rose-500 text-rose-600"
                    >
                        Products
                    </router-link>
                    <router-link
                        to="/orders"
                        class="py-4 px-2 font-medium text-sm border-b-2 border-transparent hover:text-rose-600 hover:border-rose-500 text-gray-600"
                        active-class="border-rose-500 text-rose-600"
                    >
                        Orders
                    </router-link>
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto px-4 py-8">
            <router-view />
        </main>
    </div>
</template>
