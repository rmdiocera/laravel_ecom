<template>
  <div class="flex flex-col space-y-4 lg:space-x-8 lg:grid lg:grid-cols-6">
    <div>
      <Filters :brands="brands" :categories="categories" />
    </div>
    <div class="col-span-5">
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <Product v-for="product in products" :key="product.id" :product="product" :path="imgPath" />
      </div>
    </div>
  </div>
</template>

<script setup>
import Product from '@/Pages/Product/Index/Components/Product.vue'
import Filters from '@/Pages/Product/Index/Components/Filters.vue'
defineProps({
  brands: Array,
  categories: Array,
  products: Array,
  imgPath: String,
})
</script>