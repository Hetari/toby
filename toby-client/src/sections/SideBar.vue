<template>
  <div
    class="grid h-screen columns-sm content-between border-x border-y border-rgbgray bg-primary py-[16px]"
    :class="sideBarGrid"
  >
    <div class="">
      <div class="my-2 flex cursor-pointer justify-center">
        <img src="../assets/vue.svg" alt="" class="size-10" />
      </div>
      <div class="flex cursor-pointer justify-center pt-4 hover:text-pink-500">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="chakra-icon css-48tmls size-9"
          focusable="false"
        >
          <path d="M12 5l0 14"></path>
          <path d="M5 12l14 0"></path>
        </svg>
      </div>
    </div>

    <div class="font-light">
      <div
        class="my-4 flex cursor-pointer flex-col items-center justify-center pr-1 opacity-50 hover:text-pink-500"
      >
        <svg
          viewBox="0 0 24 24"
          focusable="false"
          class="chakra-icon css-1dapl4j size-6"
        >
          <svg
            viewBox="0 0 16 24"
            focusable="false"
            class="chakra-icon css-onkibi"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M0 6.57287C0 -1.86837 15.7936 -2.41303 15.7936 6.30049C15.7936 11.474 10.6201 11.2015 9.53056 16.1035C8.9858 18.5541 5.71815 18.2816 5.71815 15.5587C5.71815 10.9302 9.53056 10.6577 11.1641 7.66241C12.2536 5.48428 10.3469 3.30509 8.16878 3.30509C3.5402 3.30509 5.17348 8.47857 2.17818 8.47857C1.08863 8.47857 0 7.66146 0 6.57287ZM7.62387 24C4.35612 24 4.62858 19.099 7.62387 19.099C10.8916 19.099 10.8916 24 7.62387 24Z"
              fill="currentColor"
            ></path>
          </svg>
        </svg>
        <p>FAQ</p>
      </div>
      <div
        class="my-4 flex cursor-pointer flex-col items-center justify-center pr-1 text-sm opacity-50 hover:text-pink-500"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="chakra-icon css-q2fpm4 size-8"
          focusable="false"
        >
          <path
            d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"
          ></path>
          <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
        </svg>
        <p>Updates</p>
      </div>
      <div
        class="my-4 flex cursor-pointer flex-col items-center justify-center pr-1 text-sm hover:text-pink-500"
      >
        <img src="../assets/vue.svg" alt="" />
        <p class="">Account</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { sideBarGrid } from '.';
</script>
