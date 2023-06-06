<template>
  <div v-if="!favorites.length">
    <h1 class="text-3xl mb-4">Favorites</h1>
    <EmptyState class="border-none shadow-none">You have no items in your cart as of this moment.</EmptyState>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    <FavoriteItem v-for="favorite in favorites" :key="favorite.id" :favorite="favorite" />
  </div>
</template>

<script setup>
import FavoriteItem from '@/Pages/Favorite/Index/Components/FavoriteItem.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'
defineProps({
  favorites: Array,
})
</script>