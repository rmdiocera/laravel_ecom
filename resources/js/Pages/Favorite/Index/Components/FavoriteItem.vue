<template>
  <Box>
    <div v-if="product_img" class="flex justify-center">
      <img class="img-rounded h-64 w-auto object-scale-down" :src="product_img" :alt="favorite.product.name" />
    </div>
    <EmptyState v-else class="h-48 flex items-center justify-center border-none shadow-none mb-2">No images</EmptyState>
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
    <div class="flex items-center justify-end">
      <Link :href="route('favorites.destroy', { favorite: favorite.id })" method="DELETE" as="button" class="text-2xl">
        🗑️
      </Link>
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
import { computed } from 'vue'

const props = defineProps({
  favorite: Object,
  path: String,
})

const product_img = computed(
  () => props.favorite.product.images.length >= 1 ? window.location.origin + props.path + props.favorite.product.images[0].filename : null,
)

</script>