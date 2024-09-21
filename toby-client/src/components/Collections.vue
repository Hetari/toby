<template>
  <!-- TODO: make it responsive -->
  <div  class="col-span-7 bg-primary content-between  border-r-1 border-l-1 border-b-1">
      <div class="flex flex-col w-full">
          <div class="flex justify-between w-full pt-4 px-4 pb-[16px] pr-4 border-b-1">
              <p class="text-2xl pl-2">My Collections <span class="text-sm pl-1 font-light text-[#7C7C9A]">| </span> <span class="text-sm font-light">{{ x }}</span> <span class="text-sm font-light"> collections</span></p>
              <button class=" hover:text-pink-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="chakra-icon css-sqo9k5" focusable="false"><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
              </button>
          </div>

          <div class="p-[21.22px] place-content-end flex border-b-1">
            <button class="border rounded-md py-1 px-6 hover:text-pink-500 font-light">+ ADD COLLECTION</button>
          </div>

          <div class="grid p-4 text-2xl font-light">
              <p class="pl-4"> Show Collections</p>

          </div>

      </div>


  </div>
</template>


<script setup lang="ts">
let x = 0;
</script>

<style scoped>
.border-t-1 {
    border-top-width: 1px;
    border-color: rgb(100, 100, 100);
}

.border-b-1 {
    border-bottom-width: 1px;
    border-color: rgb(100, 100, 100);
}
.border-l-1 {
    border-left-width: 1px;
    border-color: rgb(100, 100, 100);
}
.border-r-1 {
    border-right-width: 1px;
    border-color: rgb(100, 100, 100);
}
</style>