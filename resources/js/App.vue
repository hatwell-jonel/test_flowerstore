<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-4xl mx-auto px-4">
                <div class="flex space-x-6">
                    <router-link
                        to="/products"
                        class="py-4 px-2 font-medium text-sm border-b-2 border-transparent hover:border-blue-500 hover:text-blue-600"
                        active-class="border-blue-500 text-blue-600"
                    >
                        Products
                    </router-link>
                    <router-link
                        to="/orders"
                        class="py-4 px-2 font-medium text-sm border-b-2 border-transparent hover:border-blue-500 hover:text-blue-600"
                        active-class="border-blue-500 text-blue-600"
                    >
                        Orders
                    </router-link>
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto px-4 py-6">
            <router-view />
        </main>
    </div>
</template>
