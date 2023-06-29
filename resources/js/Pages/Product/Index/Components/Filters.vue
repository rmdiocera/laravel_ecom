<template>
  <form @submit.prevent="filterProduct">
    <div class="flex flex-col space-y-8">
      <div class="space-y-4">
        <div class="slider-cont">
          <span class="sub-heading">Price</span>
          <div class="flex justify-between">
            <span class="text-base">${{ sliderMin }}</span>
            <span class="text-base">${{ sliderMax }}</span>
          </div>
          <MinMaxPriceSlider
            v-model:min-value="sliderMin"
            v-model:max-value="sliderMax"
            :max="5000"
          />
        </div>
        <div>
          <span class="sub-heading">Brand</span>
          <div v-for="brand in brands" :key="brand.id" class="flex items-center space-x-2">
            <input
              :id="`checkbox_${brand.id}`"
              v-model="filterProductForm.brand_id"
              :value="`${brand.id}`"
              name="brand"
              type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            />
            <label :for="`checkbox_${brand.id}`">{{ brand.brand }}</label>
          </div>
        </div>
        <div v-if="categories">
          <span class="sub-heading">Category</span>
          <div v-for="category in categories" :key="category.id" class="flex items-center space-x-2">
            <input
              :id="`checkbox_${category.id}`"
              v-model="filterProductForm.category_id"
              :value="`${category.id}`"
              name="category"
              type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            />
            <label :for="`checkbox_${category.id}`">{{ category.category }}</label>
          </div>
        </div>
      </div>
      <button class="btn-primary w-full" type="submit"><fa-icon icon="fa-solid fa-filter" class="mr-2" />Filter</button>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import MinMaxPriceSlider from '@/Pages/Product/Index/Components/MinMaxPriceSlider.vue'
import { ref } from 'vue'
defineProps({
  brands: Array,
  categories: Array,
})

const sliderMin = ref(0)
const sliderMax = ref(5000)

const filterProductForm = useForm({
  brand_id: [],
  category_id: [],
  price_from: sliderMin,
  price_to: sliderMax,
})

const filterProduct = () => {
  filterProductForm.get(
    route('products.index'),
    {
      preserveScroll: true,
      preserveState: true,
    },
  )

  // addToCartForm.size = null
}
</script>