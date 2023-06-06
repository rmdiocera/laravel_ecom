<template>
  <div class="flex flex-col md:grid md:grid-cols-12 gap-6">
    <div class="md:col-span-7">
      <h1 class="text-3xl mb-4">Profile</h1>
    </div>
    <div class="md:col-span-5">
      <h1 class="text-3xl mb-4">My Orders</h1>
      <OrderList v-for="(items, index) in orders" :key="items.id" :index="index" :items="items" />
    </div>
  </div>
</template>

<script setup>
import OrderList from '@/Pages/Account/Index/Components/OrderList.vue'
const props = defineProps({
  orders: Object,
})

console.log(props.orders)
</script>