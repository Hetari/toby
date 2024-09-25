<template>
  <div class="col-span-19 bg-primary content-between border-x border-y border-rgbgray">
    <div class="flex flex-col w-full">
      <div class="flex justify-between w-full pt-4 px-2 pb-4 pr-4 border-b border-rgbgray">
        <p class="text-2xl pl-2">
          My Collections
          <span class="text-sm pl-1 font-light text-[#7C7C9A]"> | </span>
          <span class="text-sm font-light">{{ collections.length }}</span>
          <span class="text-sm font-light"> collections</span>
        </p>
        <button class="hover:text-pink-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="chakra-icon css-sqo9k5" focusable="false"><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
        </button>
      </div>

      <div class="p-[19.2px] place-content-end flex border-b border-rgbgray">
        <button class="border rounded-md py-1 px-6 hover:opacity-80 bg-pink-600 border-pink-600 font-semibold cursor-pointer" @click="togglePopup">
          <span class="text-xl">+</span> ADD COLLECTION
        </button>
      </div>

      <div class="grid p-4 text-2xl font-light">
        <div v-if="collections.length === 0">
          <p class="pl-4">There are no collections</p>
        </div>
        <div v-else>
          <ul>
            <li v-for="(item, index) in collections" :key="index" class="pl-4">
              {{ item }}
            </li>
          </ul>
        </div>
      </div>
    </div>

   
    <div v-if="showPopup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white rounded-lg shadow-xl p-10 w-[600px] text-center relative">
        <h2 class="text-2xl font-semibold mb-4 text-black">Add New Collection</h2>
        <button @click="togglePopup" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl">
          &times;
        </button>

        
        <input 
          v-model="newCollection" 
          type="text" 
          class="border border-gray-300 rounded-md w-full py-2 px-3 mb-4 text-lg focus:outline-none focus:ring-2 focus:ring-pink-500" 
          placeholder="Enter collection name" 
        />

        
        <button 
          @click="addCollection" 
          class="bg-pink-600 text-white font-semibold py-2 px-4 rounded hover:bg-pink-700"
        >
          Add Collection
        </button>
      </div>
    </div>
  </div>
</template>




<script setup lang="ts">
import { ref } from 'vue';

// State for managing collections and popup
const collections = ref<string[]>([]); // Array to store collection names
const showPopup = ref(false);
const newCollection = ref(""); // Input model for new collection name

// Function to toggle the popup window
const togglePopup = () => {
  showPopup.value = !showPopup.value;
};

// Function to add a new collection
const addCollection = () => {
  if (newCollection.value.trim() !== "") {
    collections.value.push(newCollection.value.trim()); // Add new collection
    newCollection.value = ""; // Reset input field
    togglePopup(); // Close the popup
  } 
  else {
    alert("Please enter a valid collection name.");
  }
};
</script>


<style scoped>

.col-span-19 {
  grid-column: span 19 / span 19;
}
</style>