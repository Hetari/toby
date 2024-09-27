<template>
  <div
    class="col-span-19 bg-primary content-between border-x border-y border-rgbgray"
  >
    <div class="flex flex-col w-full">
      <!-- Header Section -->
      <div
        class="flex justify-between w-full pt-4 px-2 pb-4 pr-4 border-b border-rgbgray"
      >
        <p class="text-2xl pl-2">
          My Collections
          <span class="text-sm pl-1 font-light text-[#7C7C9A]"> | </span>
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
      <div class="p-[19.2px] place-content-end flex border-b border-rgbgray">
        <button
          class="border rounded-md py-1 px-6 hover:opacity-80 bg-pink-600 border-pink-600 font-semibold cursor-pointer"
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
              class="border-rgbgray border rounded-lg shadow p-4 mb-4 w-full relative"
            >
              <div class="flex justify-between items-center">
                <div class="flex items-center">
                  <h3 class="text-xl font-semibold">{{ collection.title }}</h3>
                  <!-- Show star icon when collection is starred -->
                  <svg
                    v-if="collection.is_fav"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 ml-2 text-yellow-500"
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
                    class="absolute right-0 mt-2 w-48 bg-[#414150] border border-gray-200 rounded-md shadow-lg z-20"
                  >
                    <ul>
                      <li
                        @click="toggleStar(index)"
                        class="px-4 py-2 hover:bg-[#4c4c5c] cursor-pointer"
                      >
                        {{ collection.is_fav ? "Unstar" : "Star" }}
                      </li>
                      <li
                        @click="togglePopup('edit', collection.id)"
                        class="px-4 py-2 hover:bg-[#4c4c5c] cursor-pointer"
                      >
                        Edit
                      </li>
                      <li
                        @click="togglePopup('tag', collection.id)"
                        class="px-4 py-2 hover:bg-[#4c4c5c] cursor-pointer"
                      >
                        Add Tag
                      </li>
                      <li
                        @click="deleteCollection(collection.id)"
                        class="px-4 py-2 hover:bg-[#4c4c5c] cursor-pointer text-red-500"
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
                  class="inline-block text-sm px-2 py-1 rounded mr-2"
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
      class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
    >
      <div class="bg-white rounded-lg shadow-xl p-10 w-96 text-center relative">
        <h2 class="text-2xl font-semibold mb-4 text-black">
          {{
            popupMode === "add"
              ? "Add New Collection"
              : popupMode === "edit"
              ? "Edit Collection"
              : "Add Tag"
          }}
        </h2>
        <button
          @click="togglePopup()"
          class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl"
        >
          &times;
        </button>

        <!-- Input field for popup -->
        <input
          v-model="popupInput"
          type="text"
          class="border border-gray-300 rounded-md w-full py-2 px-3 mb-4 text-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
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
          class="bg-pink-600 text-white font-semibold py-2 px-4 rounded hover:bg-pink-700"
        >
          {{
            popupMode === "add"
              ? "Add Collection"
              : popupMode === "edit"
              ? "Save Changes"
              : "Add Tag"
          }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import axios from "axios";

const collections = ref<{ name: string; starred: boolean; tags: string[] }[]>(
  []
);
const showPopup = ref(false);
const popupMode = ref<string>("");
const popupInput = ref<string>("");
const currentEditIndex = ref<number | null>(null);
const dropdownIndex = ref<number | null>(null);

const togglePopup = (mode: string = "", index: number | null = null) => {
  showPopup.value = !showPopup.value;
  popupMode.value = mode;
  currentEditIndex.value = index;
  popupInput.value =
    mode === "edit" && index !== null ? collections.value[index].name : "";
};
const submitPopup = async () => {
  if (popupMode.value === "add" && popupInput.value.trim()) {
    try {
      // Send a POST request to add the new collection
      await axios.post(
        "http://localhost:8000/api/collections",
        {
          title: popupInput.value.trim(),
          is_fav: false,
          description: "New collection description", // Add other fields if necessary
        },
        {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            Authorization: "Bearer " + localStorage.getItem("accessToken"),
          },
        }
      );

      // Refetch collections from the server after adding
      await fetchCollections();
    } catch (error) {
      console.error("Error adding new collection:", error);
    }
  } else if (
    popupMode.value === "edit" &&
    currentEditIndex.value !== null &&
    popupInput.value.trim()
  ) {
    const collectionId = collections.value[currentEditIndex.value].id; // Get the collection ID
    try {
      // Send a PUT request to update the collection
      await axios.put(
        `http://localhost:8000/api/collections/${collectionId}`,
        {
          title: popupInput.value.trim(),
          is_fav: collections.value[currentEditIndex.value].is_fav,
          description: "Updated description", // Add other fields if necessary
        },
        {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            Authorization: "Bearer " + localStorage.getItem("accessToken"),
          },
        }
      );

      // Refetch collections from the server after the update
      await fetchCollections();
    } catch (error) {
      console.error("Error updating collection:", error);
    }
  } else if (
    popupMode.value === "tag" &&
    currentEditIndex.value !== null &&
    popupInput.value.trim()
  ) {
    collections.value[currentEditIndex.value].tags.push(
      popupInput.value.trim()
    );
  }
  togglePopup();
};

const toggleDropdown = (index) => {
  dropdownIndex.value = dropdownIndex.value === index ? null : index;
};

const toggleStar = (index) => {
  collections.value[index].is_fav = !collections.value[index].is_fav;
  dropdownIndex.value = null;
};

const deleteCollection = async (id: number) => {
  try {
    // Send a DELETE request to delete the collection
    await axios.delete(`http://localhost:8000/api/collections/${id}`, {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("accessToken"),
      },
    });

    // Refetch collections from the server after deletion
    await fetchCollections();
  } catch (error) {
    console.error("Error deleting collection:", error);
  }

  dropdownIndex.value = null; // Close the dropdown after deletion
};

const fetchCollections = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/collections", {
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        Authorization: "Bearer " + localStorage.getItem("accessToken"),
      },
    });
    collections.value = response.data.data;
  } catch (error) {
    console.error("Error fetching collections:", error);
  }
};

onMounted(() => {
  fetchCollections(); // Fetch collections when the component is mounted
});
</script>

<style scoped>
.col-span-19 {
  grid-column: span 19 / span 19;
}
</style>
