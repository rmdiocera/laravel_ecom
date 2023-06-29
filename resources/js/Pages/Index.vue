<template>
  <div class="flex items-center relative">
    <img src="/storage/index-bg.jpg" alt="" class="img-rounded w-full" />
    <div class="bg-black top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-1/3 h-48 absolute opacity-50" />
    <div class="text-gray-200 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-1/4">
      <div class="flex flex-col justify-center items-center w-auto space-y-8">
        <span class="font-medium text-lg">Get your shoe fix here at <span class="font-ubuntu text-2xl">Dripp</span>.</span>
        <Link class="btn-primary w-full text-center" :href="route('products.index')">Shop</Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

</script>