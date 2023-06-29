<template>
  <div class="flex justify-center">
    <Box class="w-1/3">
      <template #header>Add New Product</template>
      <form @submit.prevent="addProduct">
        <div class="gap-4">
          <div class="flex flex-col space-y-2">
            <div>
              <label class="label">Category</label>
              <select v-model.number="addProductForm.category_id" class="input" @change="toggleAddStock($event)">
                <option value="0" selected disabled>
                  Select product's category
                </option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.category }}</option>
                <!-- <option value="1">Shoes</option>
                <option value="2">Accessories</option> -->
              </select>
              <div v-if="addProductForm.errors.category_id" class="input-error">
                {{ addProductForm.errors.category_id }}
              </div>
            </div>
            <div>
              <label class="label">Brand</label>
              <select v-model.number="addProductForm.brand_id" class="input">
                <option value="0" selected disabled>Select product's brand</option>
                <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.brand }}</option>
                <!-- <option value="1">Nike</option>
                <option value="2">Adidas</option> -->
              </select>
              <div v-if="addProductForm.errors.brand_id" class="input-error">
                {{ addProductForm.errors.brand_id }}
              </div>
            </div>
            <div>
              <label class="label">Name</label>
              <input v-model="addProductForm.name" type="text" class="input" />
              <div v-if="addProductForm.errors.name" class="input-error">
                {{ addProductForm.errors.name }}
              </div>
            </div>
            <div>
              <label class="label">Description</label>
              <input v-model="addProductForm.description" type="text" class="input" />
              <div v-if="addProductForm.errors.description" class="input-error">
                {{ addProductForm.errors.description }}
              </div>
            </div>
            <div>
              <label class="label">Price</label>
              <input v-model.number="addProductForm.price" type="text" class="input" />
              <div v-if="addProductForm.errors.price" class="input-error">
                {{ addProductForm.errors.price }}
              </div>
            </div>
            <!-- <label class="label">Sizes</label> -->
            <div v-for="(stock, index) in addProductForm.stocks" :key="index">
              <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                  <label class="label">Size</label>
                  <select v-model.number="stock.size" class="input">
                    <option value="" :selected="true" :disabled="true">{{ addStockButtonDisabled ? 'N/A' : 'Select size' }}</option>
                    <option v-for="size in sizes" :key="size.id" :hidden="addStockButtonDisabled" :value="size.size">{{ size.size }}</option>
                    <!-- <option value="8">8</option>
                    <option value="8.5">8.5</option>
                    <option value="9">9</option>
                    <option value="9.5">9.5</option> -->
                  </select>
                  <div v-if="addProductForm.errors[`stocks.${index}.size`]" class="input-error">
                    {{ addProductForm.errors[`stocks.${index}.size`] }}
                  </div>
                </div>
                <div class="col-span-1">
                  <label class="label">Quantity</label>
                  <input v-model.number="stock.quantity" type="text" class="input" />
                  <div v-if="addProductForm.errors[`stocks.${index}.quantity`]" class="input-error">
                    {{ addProductForm.errors[`stocks.${index}.quantity`] }}
                  </div>
                </div>
              </div>
            </div>
            <button type="button" class="btn-primary w-full" :hidden="addStockButtonDisabled" @click="addStock">Add Stock</button>
            <div>
              <label class="label">Upload Images</label>
              <!-- <input type="file" class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4" multiple @input="addImages" />
              <div v-if="addProductForm.errors.brand_id" class="input-error">
                {{ addProductForm.errors.brand_id }}
              </div> -->
              <Uploader
                server="/temp/upload"
                @change="changeMedia"
              />
            </div>
            <button type="submit" class="btn-primary w-1/4 ml-auto">Save</button>
          </div>
        </div>
      </form>
    </Box>
  </div>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import { useForm } from '@inertiajs/vue3'
import Uploader from 'vue-media-upload'

defineProps({
  categories: Object,
  brands: Object,
  sizes: Object,
})

let img_arr = []

let addStockButtonDisabled = false
const addProductForm = useForm({
  name: null,
  description: null,
  category_id: 0,
  brand_id: 0,
  price: 0,
  stocks: [{
    size: '',
    quantity: 0, 
  }],
  images: [],
})

const toggleAddStock = (event) => {
  let category_id = event.target.value
  
  // Reset stocks array
  addProductForm.stocks.length = 0
  // Add default stock input
  addStock()

  // If selected category is "Shoes"
  if (category_id == 1) {   
    // If "Add Stock" button is disabled, enable it
    if (addStockButtonDisabled) {
      addStockButtonDisabled = false
    }
  // If selected category is "Accessories"
  } else {
    // If "Add Stock" button is enabled, disable it
    if (!addStockButtonDisabled) {
      addStockButtonDisabled = true
    }
  }
}

const addStock = () => addProductForm.stocks.push({
  size: '',
  quantity: 0,
})

// const addImages = (event) => {
//   for (const image of event.target.files) {
//     addProductForm.images.push(image)
//   }

//   // console.log(addProductForm.images)
// }

// Put selected image in img_arr array
const changeMedia = (media) => {
  img_arr = media
}

// const addProduct = () => console.log(addProductForm)
const addProduct = () => {
  img_arr.forEach(image => addProductForm.images.push(image.name))
  addProductForm.post(route('products.store'))
}

</script>