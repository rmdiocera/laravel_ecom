<template>
  <div v-if="!Object.keys(cart).length">
    <h1 class="text-3xl mb-4">Cart</h1>
    <EmptyState class="border-none shadow-none">You have no items in your cart as of this moment.</EmptyState>
  </div>
  <div v-else class="flex flex-col md:grid md:grid-cols-12 gap-6">
    <div class="md:col-span-7">
      <h1 class="text-3xl mb-4">Cart</h1>
      <CartList v-for="item in cart" :key="item.id" :item="item" />
    </div>
    <div class="md:col-span-5">
      <h1 class="text-3xl mb-4">Order Summary</h1>
      <OrderSummary :cart="cart" :pay-link="payLink" :total="total" />
    </div>
  </div>
</template>

<script setup>
import CartList from '@/Pages/Cart/Index/Components/CartList.vue'
import OrderSummary from './Index/Components/OrderSummary.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'
defineProps({
  payLink: String,
  cart: Object,
  total: Number,
})

</script>