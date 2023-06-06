<template>
  <div class="grid grid-cols-12 mb-4">
    <div class="col-span-3">
      <EmptyState class="h-16 flex items-center justify-center border-none shadow-none mb-2">No images</EmptyState>
    </div>
    <div class="col-span-9 flex items-start justify-between">
      <div class="flex flex-col">
        <ProductInfo :product="item.product" class="text-base font-medium" />
        <ProductDesc :product="item.product" class="text-base" />
        <span class="text-base">Size: {{ item.size ?? 'N/A' }}</span>
        <span class="text-base">Qty: {{ item.quantity }}</span>
      </div>
      <div>
        <Price :price="total" class="text-base" />
      </div>
    </div>
  </div>
</template>

<script setup>
import EmptyState from '@/Components/UI/EmptyState.vue'
import ProductInfo from '@/Components/ProductInfo.vue'
import Price from '@/Components/Price.vue'
import ProductDesc from '@/Components/ProductDesc.vue'
import { computed } from 'vue'

const props = defineProps({
  item: Object,
})

const total = computed(
  () => props.item.product.price * props.item.quantity,
)
</script>