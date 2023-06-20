<template>
  <Box class="flex flex-col justify-between">
    <div>
      <div v-if="product_img" class="flex justify-center">
        <img class="img-rounded" :src="product_img" :alt="product_name" />
      </div>
      <EmptyState v-else class="h-48 flex items-center justify-center border-none shadow-none mb-2">No images</EmptyState>
    </div>
    <div>
      <div class="flex items-center justify-between">
        <div class="flex flex-col">
          <Link :href="route('products.show', { product: product.id })">
            <ProductInfo :product="product" class="text-medium break-normal" />
          </Link>
          <ProductDesc :product="product" class="text-sm" />
        </div>
        <div>
          <Price :price="product.price" class="text-xl font-medium" />
        </div>
      </div>
      <div v-if="user && user.is_admin" class="flex items-center justify-end">
        <Link :href="route('products.edit', { product: product.id })" class="text-2xl">
          📝
        </Link>
        <Link :href="route('products.destroy', { product: product.id })" method="DELETE" as="button" class="text-2xl">
          🗑️
        </Link>
      </div>
    </div>
  </Box>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import ProductInfo from '@/Components/ProductInfo.vue'
import ProductDesc from '@/Components/ProductDesc.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'
import Price from '@/Components/Price.vue'
import { computed } from 'vue'

const props = defineProps({
  product: Object,
  path: String,
})

const user = computed(
  () => usePage().props.user,
)

const product_img = computed(
  () => props.product.images.length >= 1 ? window.location.origin + props.path + props.product.images[0].filename : null,
)

const product_name = computed(
  () => props.product.name,
)

</script>