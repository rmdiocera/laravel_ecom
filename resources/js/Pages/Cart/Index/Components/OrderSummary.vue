<template>
  <div class="flex flex-col space-y-16">
    <div class="flex justify-between px-4">
      <span class="text-base font-medium">
        Total:
      </span>
      <Price :price="total" class="text-base font-medium" />
    </div>
    <div class="px-4">
      <!-- <Link class="btn-primary w-full" method="POST" as="button">Checkout</Link> -->
      <Link href="#!" class="btn-primary w-full" as="button" @click="openCheckout">
        Buy
      </Link>
    </div>
  </div>
</template>

<script setup>
import Price from '@/Components/Price.vue'
import { Link, useForm } from '@inertiajs/vue3'


const props = defineProps({
  payLink: String,
  cart: Object,
  total: Number,
})

// const total = computed(
//   () => props.cart.reduce((x, value) => x + value.product.price, 0),
// )
// console.log(props)

const cartForm = useForm({
  amount: props.total,
})

function checkoutComplete() {
  cartForm.post(route('orders.store', { cart: props.cart }))
}

const Paddle = window.Paddle
const openCheckout = () => {
  Paddle.Checkout.open({
    override: props.payLink,
    successCallback: checkoutComplete,
  })
}

// props.cart.forEach((x) => console.log(x.product.price))

// const test = total.reduce((x, value) => x.product + value, 0)

// const arr = [1,2,3]

// const total = computed(
//   () => arr.reduce((x, val) => x + val, 0),
// )

</script>