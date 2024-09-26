<template>
  <div
    class="col-span-6 grid content-between border-y border-rgbgray bg-primary lg:col-span-4"
  >
    <div class="flex w-full flex-col">
      <!-- TODO: <a> to user account -->
      <div class="flex w-full justify-between px-2 pb-4 pr-4 pt-4">
        <a
          class="cursor-pointer pl-2 text-2xl font-medium"
          :click="goToUserInfo()"
          >Ammar</a
        >
        <button class="hover:text-pink-500">
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
            class="chakra-icon css-e13ry2"
            focusable="false"
          >
            <path
              d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"
            ></path>
            <path d="M9 4v16"></path>
            <path d="M15 10l-2 2l2 2"></path>
          </svg>
        </button>
      </div>

      <div
        class="flex cursor-pointer space-x-2 border-b border-t border-rgbgray p-6 hover:text-pink-500"
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
          class="chakra-icon css-ugv5hc"
          focusable="false"
        >
          <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
          <path d="M21 21l-6 -6"></path>
        </svg>
        <p class="text-xl opacity-90">Search</p>
      </div>

      <div class="grid border-b border-rgbgray p-4 text-xl">
        <div
          class="flex cursor-pointer space-x-3 pb-4 pt-2 font-light hover:text-pink-500"
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
            class="chakra-icon css-1pipko8"
            focusable="false"
          >
            <path d="M9 15l6 -6"></path>
            <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
            <path
              d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"
            ></path>
          </svg>
          <p class="opacity-90">To / Links</p>
        </div>

        <div
          class="flex cursor-pointer space-x-3 pb-2 font-light hover:text-pink-500"
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
            class="chakra-icon css-1pipko8"
            focusable="false"
          >
            <path
              d="M14 2a5 5 0 0 1 5 5v14a1 1 0 0 1 -1.555 .832l-5.445 -3.63l-5.444 3.63a1 1 0 0 1 -1.55 -.72l-.006 -.112v-14a5 5 0 0 1 5 -5h4z"
              fill="currentColor"
              stroke-width="0"
            ></path>
          </svg>
          <p class="opacity-90">Next</p>
        </div>
      </div>

      <div class="p-2 pt-4">
        <p class="pb-6 pl-3 pt-2 text-xl font-medium">Spaces</p>

        <div
          class="flex cursor-pointer space-x-2 pb-6 pl-2 text-xl font-light hover:text-pink-500"
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
            class="chakra-icon css-1uje9ol"
            focusable="false"
          >
            <path
              d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
            ></path>
          </svg>
          <p class="opacity-90">Starred Collections</p>
        </div>
        <div
          class="flex cursor-pointer space-x-2 pl-2 text-xl font-light hover:text-pink-500"
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
            class="chakra-icon css-1uje9ol"
            focusable="false"
          >
            <path
              d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z"
            ></path>
            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
            <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
          </svg>
          <p class="opacity-90">My Collections</p>
        </div>
      </div>
    </div>

    <div class="border-t border-rgbgray pb-4 pl-1 pt-3 font-light">
      <div
        class="flex cursor-pointer space-x-2 p-2 pt-2 opacity-90 hover:text-pink-500"
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
          class="chakra-icon css-ugv5hc"
          focusable="false"
        >
          <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
          <path d="M16 19h6"></path>
          <path d="M19 16v6"></path>
          <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
        </svg>
        <p>Invite members</p>
      </div>
      <div
        class="flex cursor-pointer space-x-2 p-2 opacity-90 hover:text-pink-500"
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
          class="chakra-icon css-ugv5hc"
          focusable="false"
        >
          <path
            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"
          ></path>
          <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
        </svg>
        <div>Organization settings</div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  const goToUserInfo = () => {};
</script>

<style scoped></style>
