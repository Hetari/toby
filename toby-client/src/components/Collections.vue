<template>
  <div
    class="col-span-rest content-between border-x border-y border-rgbgray bg-primary"
  >
    <div class="flex w-full flex-col">
      <!-- Header Section -->
      <div
        class="flex w-full justify-between border-b border-rgbgray px-2 pb-4 pr-4 pt-4"
      >
        <p class="pl-2 text-2xl">
          My Collections
          <span class="pl-1 text-sm font-light text-[#7C7C9A]"> | </span>
          <span class="text-sm font-light">{{ collections.length }}</span>
          <span class="text-sm font-light"> collections</span>
        </p>
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
            class="chakra-icon css-sqo9k5"
            focusable="false"
          >
            <path
              d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"
            ></path>
            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
          </svg>
        </button>
      </div>

      <!-- Add Collection Button -->
      <div class="flex place-content-end border-b border-rgbgray p-[19.2px]">
        <button
          class="cursor-pointer rounded-md border border-pink-600 bg-pink-600 px-6 py-1 font-semibold hover:opacity-80"
          @click="togglePopup('add')"
        >
          <span class="text-xl">+</span> ADD COLLECTION
        </button>
      </div>

      <!-- Collection List -->
      <div class="grid p-4 text-2xl font-light">
        <div v-if="collections.length === 0">
          <p class="pl-4">There are no collections</p>
        </div>
        <div v-else>
          <div>
            <div
              v-for="(collection, index) in collections"
              :key="index"
              class="relative mb-4 w-full rounded-lg border border-rgbgray p-4 shadow"
            >
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <h3 class="text-xl font-semibold">{{ collection.name }}</h3>
                  <!-- Show star icon when collection is starred -->
                  <svg
                    v-if="collection.starred"
                    xmlns="http://www.w3.org/2000/svg"
                    class="ml-2 h-6 w-6 text-yellow-500"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    stroke="none"
                  >
                    <path
                      d="M12 .587l3.668 7.513 8.332 1.151-6.001 5.775 1.417 8.148L12 18.896l-7.416 4.278 1.417-8.148L0 9.251l8.332-1.151L12 .587z"
                    ></path>
                  </svg>
                </div>

                <!-- Three dots for dropdown menu -->
                <div class="relative">
                  <button
                    @click="toggleDropdown(index)"
                    class="text-gray-500 hover:text-gray-700"
                  >
                    &#x22EE;
                    <!-- Unicode for three vertical dots -->
                  </button>

                  <!-- Dropdown menu -->
                  <div
                    v-if="dropdownIndex === index"
                    class="absolute right-0 z-20 mt-2 w-48 rounded-md border border-gray-200 bg-[#414150] shadow-lg"
                  >
                    <ul>
                      <li
                        @click="toggleStar(index)"
                        class="cursor-pointer px-4 py-2 hover:bg-[#4c4c5c]"
                      >
                        {{ collection.starred ? 'Unstar' : 'Star' }}
                      </li>
                      <li
                        @click="togglePopup('edit', index)"
                        class="cursor-pointer px-4 py-2 hover:bg-[#4c4c5c]"
                      >
                        Edit
                      </li>
                      <li
                        @click="togglePopup('tag', index)"
                        class="cursor-pointer px-4 py-2 hover:bg-[#4c4c5c]"
                      >
                        Add Tag
                      </li>
                      <li
                        @click="deleteCollection(index)"
                        class="cursor-pointer px-4 py-2 text-red-500 hover:bg-[#4c4c5c]"
                      >
                        Delete
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Tags display -->
              <div class="mt-2">
                <span
                  v-if="collection.tags.length > 0"
                  v-for="(tag, idx) in collection.tags"
                  :key="idx"
                  class="mr-2 inline-block rounded px-2 py-1 text-sm"
                >
                  {{ tag }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Popup for add/edit/tag collection -->
    <div
      v-if="showPopup"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="relative w-96 rounded-lg bg-white p-10 text-center shadow-xl">
        <h2 class="mb-4 text-2xl font-semibold text-black">
          {{
            popupMode === 'add'
              ? 'Add New Collection'
              : popupMode === 'edit'
                ? 'Edit Collection'
                : 'Add Tag'
          }}
        </h2>
        <button
          @click="togglePopup()"
          class="absolute right-4 top-4 text-3xl text-gray-500 hover:text-gray-700"
        >
          &times;
        </button>

        <!-- Input field for popup -->
        <input
          v-model="popupInput"
          type="text"
          class="mb-4 w-full rounded-md border border-gray-300 px-3 py-2 text-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
          :placeholder="
            popupMode === 'add'
              ? 'Enter collection name'
              : popupMode === 'edit'
                ? 'Edit collection name'
                : 'Enter tag'
          "
        />

        <!-- Button to submit form -->
        <button
          @click="submitPopup"
          class="rounded bg-pink-600 px-4 py-2 font-semibold text-white hover:bg-pink-700"
        >
          {{
            popupMode === 'add'
              ? 'Add Collection'
              : popupMode === 'edit'
                ? 'Save Changes'
                : 'Add Tag'
          }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { ref } from 'vue';

  const collections = ref<{ name: string; starred: boolean; tags: string[] }[]>(
    [],
  );
  const showPopup = ref(false);
  const popupMode = ref<string>('');
  const popupInput = ref<string>('');
  const currentEditIndex = ref<number | null>(null);
  const dropdownIndex = ref<number | null>(null);

  const togglePopup = (mode: string = '', index: number | null = null) => {
    showPopup.value = !showPopup.value;
    popupMode.value = mode;
    currentEditIndex.value = index;
    popupInput.value =
      mode === 'edit' && index !== null ? collections.value[index].name : '';
  };

  const submitPopup = () => {
    if (popupMode.value === 'add' && popupInput.value.trim()) {
      collections.value.push({
        name: popupInput.value.trim(),
        starred: false,
        tags: [],
      });
    } else if (
      popupMode.value === 'edit' &&
      currentEditIndex.value !== null &&
      popupInput.value.trim()
    ) {
      collections.value[currentEditIndex.value].name = popupInput.value.trim();
    } else if (
      popupMode.value === 'tag' &&
      currentEditIndex.value !== null &&
      popupInput.value.trim()
    ) {
      collections.value[currentEditIndex.value].tags.push(
        popupInput.value.trim(),
      );
    }
    togglePopup();
  };

  const toggleDropdown = (index: number) => {
    dropdownIndex.value = dropdownIndex.value === index ? null : index;
  };

  const toggleStar = (index: number) => {
    collections.value[index].starred = !collections.value[index].starred;
    dropdownIndex.value = null;
  };

  const deleteCollection = (index: number) => {
    collections.value.splice(index, 1);
    dropdownIndex.value = null;
  };
</script>

<style scoped>
  .col-span-rest {
    grid-column: span 16 / span 16;
  }
  @media (min-width: 1024px) {
    .col-span-rest {
      grid-column: span 19 / span 19;
    }
  }
</style>
