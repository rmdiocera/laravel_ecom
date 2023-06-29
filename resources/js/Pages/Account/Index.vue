<template>
  <div class="flex flex-col md:grid md:grid-cols-12 gap-6">
    <div class="md:col-span-7">
      <h1 class="text-3xl mb-4">Profile</h1>
      <EmptyState class="border-none shadow-none">This feature is not available as of this moment.</EmptyState>
    </div>
    <div class="md:col-span-5">
      <h1 class="text-3xl mb-4">My Orders</h1>
      <EmptyState v-if="!Object.keys(orders).length" class="border-none shadow-none">You have no items in your orders as of this moment.</EmptyState>
      <OrderList v-for="(items, index) in orders" v-else :key="items.id" :index="index" :items="items" />
    </div>
  </div>
</template>

<script setup>
import OrderList from '@/Pages/Account/Index/Components/OrderList.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'
defineProps({
  orders: Object,
})
</script>