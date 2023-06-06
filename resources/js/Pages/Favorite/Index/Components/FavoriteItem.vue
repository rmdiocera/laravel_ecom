<template>
  <Box>
    <EmptyState class="h-48 flex items-center justify-center border-none shadow-none mb-2">No images</EmptyState>
    <div class="flex items-center justify-between">
      <div class="flex flex-col">
        <Link :href="route('products.show', { product: favorite.product.id })">
          <ProductInfo :product="favorite.product" class="text-medium" />
        </Link>
        <ProductDesc :product="favorite.product" class="text-sm" />
      </div>
      <div>
        <Price :price="favorite.product.price" class="text-xl font-medium" />
      </div>
    </div>
  </Box>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import ProductInfo from '@/Components/ProductInfo.vue'
import ProductDesc from '@/Components/ProductDesc.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'
import Price from '@/Components/Price.vue'

defineProps({
  favorite: Object,
})
</script>