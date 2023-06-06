<template>
  <main class="max-w-screen-xl mx-auto p-8 flex flex-col items-center">
    <div class="flex w-full relative">
      <input id="option0" type="radio" name="tabs" class="appearance-none" />
      <label for="option0" class="cursor-pointer w-1/6 flex items-center justify-center truncate uppercase select-none font-semibold text-lg rounded-full py-2">OPTION 0</label>

      <input id="option1" type="radio" name="tabs" class="appearance-none" />
      <label for="option1" class="cursor-pointer w-1/6 flex items-center justify-center truncate uppercase select-none font-semibold text-lg rounded-full py-2">OPTION 1</label>

      <input id="option2" type="radio" name="tabs" class="appearance-none" />
      <label for="option2" class="cursor-pointer w-1/6 flex items-center justify-center truncate uppercase select-none font-semibold text-lg rounded-full py-2">OPTION 2</label>

      <input id="option3" type="radio" name="tabs" class="appearance-none" />
      <label for="option3" class="cursor-pointer w-1/6 flex items-center justify-center truncate uppercase select-none font-semibold text-lg rounded-full py-2">OPTION 3</label>

      <input id="option4" type="radio" name="tabs" class="appearance-none" />
      <label for="option4" class="cursor-pointer w-1/6 flex items-center justify-center truncate uppercase select-none font-semibold text-lg rounded-full py-2">OPTION 4</label>

      <div class="w-1/6 flex items-center justify-center truncate uppercase select-none font-semibold text-lg rounded-full p-0 h-full bg-indigo-600 absolute transform transition-transform tabAnim" />
    </div>
  </main>
</template>

<style>
/* Not Responsive */
body {
  background-color: rgba(31, 41, 55); /* cool gray 800 */
  color: white;
}

.tabAnim {
  z-index: -9;
}

#option0:checked ~ div {
  --tw-translate-x: 0%;
}

#option1:checked ~ div {
  --tw-translate-x: 100%;
}

#option2:checked ~ div {
  --tw-translate-x: 200%;
}

#option3:checked ~ div {
  --tw-translate-x: 300%;
}

#option4:checked ~ div {
  --tw-translate-x: 400%;
}

</style>