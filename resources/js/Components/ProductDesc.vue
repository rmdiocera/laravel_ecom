<template>
  <span>
    {{ product.description }}
  </span>
</template>

<script setup>
defineProps({
  product: Object,
})
</script>