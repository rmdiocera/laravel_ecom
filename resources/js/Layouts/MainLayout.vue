<template>
  <header>
    <div class="container mx-auto w-full">
      <nav class="p-4 flex items-center justify-between">
        <div>
          <Link :href="route('index')" class="font-ubuntu text-4xl">🌊 Dripp</Link>
        </div>
        <div class="flex justify-between items-center gap-16">
          <div class="flex gap-4">
            <!-- <Link href="/">New Arrivals</Link> -->
            <!-- {{ categories }} -->
            <Link
              v-for="category in categories" :key="category.id" 
              :href="route('products.index') + `/category/${toLowerCase(category.category)}`"
            >
              {{ category.category }}
            </Link>
          </div>
        </div>
        <div class="flex justify-between items-center gap-16">
          <div v-if="user" class="flex items-center gap-4">
            <div v-if="user.is_admin">
              <Link :href="route('products.create')" class="btn-primary"><fa-icon icon="fa-solid fa-circle-plus" class="mr-2" />Add New Product</Link>
            </div>
            <div v-else>
              <Link :href="route('favorites.index')" class="text-gray-500 relative pr-2 py-2 text-lg">
                ❤️
                <div v-if="favoritesCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                  {{ favoritesCount }}
                </div>
              </Link>
              <Link :href="route('cart.index')" class="text-gray-500 relative pr-2 py-2 text-lg">
                🛒
                <div v-if="cartCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                  {{ cartCount }}
                </div>
              </Link>
            </div>
            <Link :href="route('account.index')" class="text-small">
              {{ user.name }}
            </Link>
            <Link :href="route('logout')" method="DELETE" as="button">Log Out</Link>
          </div>
          <div v-else class="flex gap-4">
            <Link :href="route('login')">Login</Link>
            <Link :href="route('account.create')">Register</Link>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <main class="container mx-auto w-full p-4">
    <div v-if="successMessage" class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2">
      {{ successMessage }}
    </div>
    <slot>Default</slot>
  </main>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const successMessage = computed(
  () => usePage().props.flash.success, 
)

const user = computed(
  () => usePage().props.user,
)

const cartCount = computed(
  () => usePage().props.user.cartCount <= 9
    ? usePage().props.user.cartCount
    : '9+',
)

const favoritesCount = computed(
  () => usePage().props.user.favoritesCount <= 9
    ? usePage().props.user.favoritesCount
    : '9+',
)

const categories = computed(
  () => usePage().props.category_names,
)

// console.log(categories.value)

const toLowerCase = (value) => value.toLowerCase() 
</script>