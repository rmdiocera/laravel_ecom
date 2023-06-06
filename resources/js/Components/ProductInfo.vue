<template>
  <span>
    {{ product.name }}
  </span>
</template>

<script setup>
defineProps({
  product: Object,
})
</script>