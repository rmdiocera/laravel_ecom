<template>
  <div class="flex justify-center">
    <Box class="w-1/3">
      <template #header>Edit Product</template>
      <form @submit.prevent="updateProduct">
        <div class="gap-4">
          <div class="flex flex-col space-y-2">
            <div>
              <label class="label">Category</label>
              <select v-model.number="updateProductForm.category_id" class="input" disabled>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.category }}</option>
              </select>
              <div v-if="updateProductForm.errors.category_id" class="input-error">
                {{ updateProductForm.errors.category_id }}
              </div>
            </div>
            <div>
              <label class="label">Brand</label>
              <select v-model.number="updateProductForm.brand_id" class="input" disabled>
                <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.brand }}</option>
              </select>
              <div v-if="updateProductForm.errors.brand_id" class="input-error">
                {{ updateProductForm.errors.brand_id }}
              </div>
            </div>
            <div>
              <label class="label">Name</label>
              <input v-model="updateProductForm.name" type="text" class="input" disabled />
              <div v-if="updateProductForm.errors.name" class="input-error">
                {{ updateProductForm.errors.name }}
              </div>
            </div>
            <div>
              <label class="label">Description</label>
              <input v-model="updateProductForm.description" type="text" class="input" disabled />
              <div v-if="updateProductForm.errors.description" class="input-error">
                {{ updateProductForm.errors.description }}
              </div>
            </div>
            <div>
              <label class="label">Price</label>
              <input v-model.number="updateProductForm.price" type="text" class="input" />
              <div v-if="updateProductForm.errors.price" class="input-error">
                {{ updateProductForm.errors.price }}
              </div>
            </div>
            <!-- <label class="label">Sizes</label> -->
            <div v-for="(stock, index) in updateProductForm.stocks" :key="index">
              <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                  <label class="label">Size</label>
                  <select v-model.number="stock.size" :disabled="addStockButtonDisabled" class="input">
                    <option value="">N/A</option>
                    <option v-for="size in sizes" :key="size.id" :hidden="addStockButtonDisabled" :value="size.size">{{ size.size }}</option>
                    <!-- <option value="8">8</option>
                    <option value="8.5">8.5</option>
                    <option value="9">9</option>
                    <option value="9.5">9.5</option> -->
                  </select>
                  <div v-if="updateProductForm.errors[`stocks.${index}.size`]" class="input-error">
                    {{ updateProductForm.errors[`stocks.${index}.size`] }}
                  </div>
                </div>
                <div class="col-span-1">
                  <label class="label">Quantity</label>
                  <input v-model.number="stock.quantity" type="text" class="input" />
                  <div v-if="updateProductForm.errors[`stocks.${index}.quantity`]" class="input-error">
                    {{ updateProductForm.errors[`stocks.${index}.quantity`] }}
                  </div>
                </div>
              </div>
            </div>
            <button type="button" class="btn-primary w-full" :hidden="addStockButtonDisabled" @click="addStock">Add Stock</button>
            <div>
              <label class="label">Upload Images</label>
              <!-- <input v-model.number="updateProductForm.price" type="text" class="input" />
              <div v-if="updateProductForm.errors.price" class="input-error">
                {{ updateProductForm.errors.price }}
              </div> -->
              <Uploader 
                server="/temp/upload"
                :media="images.saved"
                location="/storage/images"
                @add="addMedia" 
                @remove="removeMedia"
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
import Uploader from 'vue-media-upload'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  product: Object,
  categories: Object,
  brands: Object,
  sizes: Object,
})

let addStockButtonDisabled = props.product.category_id == 2 ?? false
let images = {
  saved: [],
  added: [],
  removed: [],
}

for (const image of props.product.images) {
  images.saved.push({'id': image.id, 'name': image.filename})
}

const updateProductForm = useForm({
  name: props.product.name,
  description: props.product.description,
  category_id: props.product.category_id,
  brand_id: props.product.brand_id,
  price: props.product.price,
  stocks: [],
  images: {
    added: [],
    removed: [],
  },
})

props.product.stocks.forEach(stock => updateProductForm.stocks.push({ size: stock.size == null ? '' : stock.size, quantity: stock.quantity }))

const addStock = () => updateProductForm.stocks.push({
  size: '',
  quantity: 0,
})

// Put added images in images.added
const addMedia = (media) => {
  images.added.push(media) 
  console.log(images)
}

// Put added images in images.removed
const removeMedia = (media) => {
  images.removed.push(media)
  console.log(images)
} 

// const updateProduct = () => {
//   // Loop through images.added and images.removed
//   images.added.forEach(image => updateProductForm.images.added.push(image.name))
//   images.removed.forEach(image => updateProductForm.images.removed.push({'id': image.id, 'name': image.name}))
//   console.log(updateProductForm)
// }
const updateProduct = () => {
  // Loop through images.added and images.removed
  images.added.forEach(image => updateProductForm.images.added.push(image.name))
  images.removed.forEach(image => updateProductForm.images.removed.push({'id': image.id, 'name': image.name}))

  updateProductForm.put(route('products.update', { product: props.product.id }))
}

</script>