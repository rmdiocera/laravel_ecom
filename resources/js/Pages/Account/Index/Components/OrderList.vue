<template>
  <span class="font-medium text-lg">{{ index }}</span>
  <!-- Create OrderItem component -->
  <OrderItem v-for="item in items" :key="item.id" :item="item" />
  <OrderTotal :total="total" />
</template>

<script setup>
import OrderItem from '@/Pages/Account/Index/Components/OrderItem.vue'
import OrderTotal from '@/Pages/Account/Index/Components/OrderTotal.vue'

// const { DateTime } = luxon.DateTime 

const props = defineProps({
  index: String,
  items: Array,
})

const total = props.items.reduce(
  (acc, val) => acc + (val.product.price * val.quantity)
  , 0)

// props.items.forEach(el => console.log(el.product.price))

// props.items.forEach(el => console.log(el))
</script>