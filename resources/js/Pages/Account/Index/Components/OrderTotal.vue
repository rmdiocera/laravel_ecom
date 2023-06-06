<template>
  <div class="grid grid-cols-12 mb-4">
    <div class="col-span-3">
      <span>Total: </span>
    </div>
    <div class="col-span-9 flex items-start justify-between">
      <div>
        <Price :price="total" class="text-base" />
      </div>
    </div>
  </div>
</template>

<script setup>
import Price from '@/Components/Price.vue'
defineProps({
  total: Number,
})
</script>