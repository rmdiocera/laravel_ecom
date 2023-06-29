<template>
  <h1 class="text-3xl mb-4">My Favorites</h1>
  <div v-if="!favorites.length">
    <EmptyState class="border-none shadow-none">You have no items in your favorites as of this moment.</EmptyState>
  </div>
  <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    <FavoriteItem v-for="favorite in favorites" :key="favorite.id" :favorite="favorite" :path="imgPath" />
  </div>
</template>

<script setup>
import FavoriteItem from '@/Pages/Favorite/Index/Components/FavoriteItem.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'
defineProps({
  favorites: Array,
  imgPath: String,
})
</script>