<template>
  <div class="flex flex-col md:grid md:grid-cols-12 gap-4 mb-2">
    <div class="md:col-span-7 md:flex md:flex-col md:justify-center">
      <VueperSlides v-if="slides.length" autoplay class="no-shadow">
        <VueperSlide
          v-for="(slide, i) in slides"
          :key="i"
          :image="slide.image"
        />
      </VueperSlides>
      <EmptyState v-else class="border-none shadow-none">No images</EmptyState>
    </div>
    <div class="flex flex-col justify-between gap-4 md:col-span-5">
      <div class="flex flex-col">
        <ProductInfo :product="product" class="text-2xl" />
        <ProductDesc :product="product" class="text-lg" />
        <Price :price="product.price" class="text-lg font-medium" />
      </div>
      <div class="flex flex-col">
        <div v-if="product.stocks.length">
          <form @submit.prevent="addToCart">
            <div v-if="!isAccessory" class="grid grid-cols-6 gap-2 mb-4">
              <div v-for="stock in hasStock" :key="stock.id">
                <!-- Try to filter stocks then loop through filtered stocks -->
                <!-- Check out how deleted listings are being handled -->
                <div v-if="stock.quantity != 0">
                  <input
                    :id="`option_${stock.id}`"
                    v-model="addToCartForm.size"
                    :value="`${stock.size}`"
                    name="size"
                    type="radio"
                    class="appearance-none peer"
                  />
                  <label
                    :for="`option_${stock.id}`" 
                    class="cursor-pointer w-full border flex items-center justify-center truncate uppercase select-none peer-checked:border peer-checked:border-gray-600 dark:peer-checked:border-cyan-300 text-gray-600 dark:text-gray-300 text-base font-medium py-2" 
                  >{{ stock.size }}</label>
                </div>
              </div>
            </div>
            <div v-if="addToCartForm.errors.size" class="input-error mb-2">
              {{ addToCartForm.errors.size }}
            </div>
            <div class="flex flex-col gap-2 mb-4">
              <button class="btn-primary w-full" :class="{ 'opacity-25 hover:bg-none': hasStock.length == 0 }" :disabled="hasStock.length == 0" type="submit">{{ hasStock.length > 0 ? 'Add to Cart' : 'Sold Out' }}</button>
              <Link class="btn-primary w-full" :href="route('products.favorite', { product: product.id, size: addToCartForm.size })" method="POST" as="button">Add to Favorite</Link>
            </div>
          </form>
        </div>
        <div v-else>
          Sold out
        </div>
        <div class="flex justify-end">
          <span>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias dolorem voluptates explicabo numquam soluta! Non impedit omnis optio voluptatem illum ipsa error molestias ad quae, accusantium, facere eius inventore officia.</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import EmptyState from '@/Components/UI/EmptyState.vue'
import ProductInfo from '@/Components/ProductInfo.vue'
import ProductDesc from '@/Components/ProductDesc.vue'
import Price from '@/Components/Price.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import { VueperSlides, VueperSlide } from 'vueperslides'
import 'vueperslides/dist/vueperslides.css'

const props = defineProps({
  product: Object,
  imgPath: String,
})

// Populate slides array with product images
const slides = []

props.product.images.forEach(img => slides.push({'image': window.location.origin + props.imgPath + img.filename}))

console.log(slides)

const isAccessory = computed(
  () => props.product.stocks.length == 1 && !props.product.stocks[0].has_sizes,
)

const hasStock = computed(
  () => props.product.stocks.filter(stock => stock.quantity != 0),
)

const addToCartForm = useForm({
  size: null,
  has_sizes: props.product.stocks[0].has_sizes ? true : false,
})

// CHECK ROUTE MODEL BINDING
const addToCart = () => {
  addToCartForm.post(
    route('products.cart.store', {
      product: props.product.id,
    }),
    {
      preserveScroll: true,
      preserveState: true,
    },
  )

  addToCartForm.size = null
}
</script>