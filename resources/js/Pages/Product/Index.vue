<template>
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    <Product v-for="product in products" :key="product.id" :product="product" />
  </div>
</template>

<script setup>
import Product from '@/Pages/Product/Index/Components/Product.vue'
defineProps({
  products: Array,
})
</script>