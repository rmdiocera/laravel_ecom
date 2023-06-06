<template>
  <div class="grid grid-cols-12 mb-4">
    <div class="col-span-3">
      <EmptyState class="h-16 flex items-center justify-center border-none shadow-none mb-2">No images</EmptyState>
    </div>
    <div class="col-span-9 flex items-start justify-between">
      <div class="flex flex-col">
        <ProductInfo :product="item.product" class="text-base font-medium" />
        <ProductDesc :product="item.product" class="text-base" />
        <span class="text-base">Size: {{ item.size ?? 'N/A' }}</span>
        <div class="flex flex-row items-center gap-16">
          <span class="text-base">Qty: 
            <!-- data-old-qty is reactive that's why it changes dynamically -->
            <!-- <input id="input-qty" v-model.number="orderInfo.quantity" type="number" min="1" :data-old-qty="item.quantity" @change="test($event)" /> -->
          </span>
          <div class="flex flex-row h-8 w-24 rounded-lg relative bg-transparent input-counter">
            <button data-action="decrement" class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none" @click="decrement">
              -
            <!-- <span class="m-auto text-2xl font-thin">−</span> -->
            </button>
            <input v-model.number="orderInfo.quantity" class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700" name="custom-input-number" type="number" min="1" :data-old-qty="item.quantity" disabled />
            <button data-action="increment" class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer" @click="increment">
              +
            <!-- <span class="m-auto text-2xl font-thin">+</span> -->
            </button>
          </div>
        </div>
        <div v-if="orderInfo.errors.difference" class="input-error mb-2">
          {{ orderInfo.errors.difference }}
        </div>
        <Link class="flex justify-start text-2xl" :href="route('cart.destroy', {cart: item.id})" method="DELETE" as="button">🗑️</Link>
      </div>
      <div>
        <Price :price="total_amount" class="text-base font-medium" />
      </div>
    </div>
  </div>
</template>

<script setup>
import EmptyState from '@/Components/UI/EmptyState.vue'
import ProductInfo from '@/Components/ProductInfo.vue'
import Price from '@/Components/Price.vue'
import ProductDesc from '@/Components/ProductDesc.vue'
import { debounce } from 'lodash'
import { Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  item: Object,
})

const total_amount = computed(() => props.item.product.price * props.item.quantity)

const orderInfo = useForm({
  quantity: props.item.quantity,
  cart_item_id: props.item.id,
  stock_id: props.item.stock.id,
  change: '',
  difference: 0,
})

function decrement(e) {
  const btn = e.target.parentNode.parentElement.querySelector(
    'button[data-action="decrement"]',
  )
  const target = btn.nextElementSibling
  // console.log(target)
  let value = Number(target.value)
  value--
  orderInfo.quantity--
  target.value = value
  test(e, 'reduce')
}

function increment(e) {
  const btn = e.target.parentNode.parentElement.querySelector(
    'button[data-action="decrement"]',
  )
  const target = btn.nextElementSibling
  // console.log(target)
  let value = Number(target.value)
  value++
  orderInfo.quantity++
  target.value = value
  test(e, 'add')
}

const test = debounce((event, change) => test_func(event, change), 200)

// if (change == 'add') {
//     console.log(event.target.previousSibling)
//   } else if (change == 'reduce') {
//     console.log(event.target.nextSibling)
//   }

const test_func = (event, change) => {
  // console.log(event.target.previousSibling.getAttribute('data-old-qty'))
  let old_qty = 0

  if (change == 'add') {
    old_qty = Number(event.target.previousSibling.getAttribute('data-old-qty'))
    orderInfo.difference = orderInfo.quantity - old_qty
  } else if (change == 'reduce') {
    old_qty = Number(event.target.nextSibling.getAttribute('data-old-qty'))
    orderInfo.difference = old_qty - orderInfo.quantity
  }

  orderInfo.change = change

  // let old_qty = Number(event.target.getAttribute('data-old-qty'))
  // if (old_qty < orderInfo.quantity) {
  //   orderInfo.change = 'add'
  //   orderInfo.difference = orderInfo.quantity - old_qty
  // } else if (old_qty == orderInfo.quantity) {
  //   orderInfo.change = ''
  // } else {
  //   orderInfo.change = 'reduce'
  //   orderInfo.difference = old_qty - orderInfo.quantity 
  // }
  
  // console.log(orderInfo.quantity, old_qty, orderInfo.change)
    
  orderInfo.put(
    route('cart.update', {
      cart: orderInfo.cart_item_id,
      stock: orderInfo.stock_id,
      change: orderInfo.change,
      difference: orderInfo.difference,
    }),
    {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        // let input_qty = document.getElementById('input-qty')
        if (change == 'add') {
          // old_qty = Number(event.target.previousSibling.getAttribute('data-old-qty'))
          // orderInfo.difference = orderInfo.quantity - old_qty
          event.target.previousSibling.setAttribute('data-old-qty', orderInfo.quantity)
        } else if (change == 'reduce') {
          // old_qty = Number(event.target.nextSibling.getAttribute('data-old-qty'))
          // orderInfo.difference = old_qty - orderInfo.quantity
          event.target.nextSibling.setAttribute('data-old-qty', orderInfo.quantity)
        }
      },
      onError: () => {
        orderInfo.quantity = props.item.quantity
      }, 
    },
  )
}

// watch(
//   () => props.item.quantity,
//   (qty) => console.log(qty),
// )

</script>

<style scoped>
  input[type='number']::-webkit-inner-spin-button,
  input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .input-counter input:focus {
    outline: none !important;
  }

  .input-counter button:focus {
    outline: none !important;
  }
</style>