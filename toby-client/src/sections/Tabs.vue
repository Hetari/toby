<template>
  <div class="col-span-5">
    <div class="flex justify-between items-center text-xl flex-row-reverse">
      <button
        class="flex cursor-pointer justify-center hover:text-pink-500"
        @click="addTab"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
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
      </button>
      <div>
        <h1 class="p-3">Tabs</h1>
      </div>
    </div>
    <div class="flex p-3 flex-col">
      <input
        v-model="newTab.title"
        type="text"
        class="border border-gray-300 rounded-md w-full py-2 px-3 mb-4 text-lg focus:outline-none focus:ring-2 focus:ring-pink-500 bg-gray-200 text-black"
        placeholder="Youtube"
      />

      <input
        v-model="newTab.url"
        type="text"
        class="border border-gray-300 rounded-md w-full py-2 px-3 mb-4 text-lg focus:outline-none focus:ring-2 focus:ring-pink-500 bg-gray-200 text-black"
        placeholder="https://youtube.com/"
      />

      <select
        v-model="newTab.collection_id"
        class="border border-gray-300 rounded-md w-full py-2 px-3 mb-4 text-lg focus:outline-none focus:ring-2 focus:ring-pink-500 bg-gray-200 text-black"
      >
        <option
          v-for="collection in collections"
          :key="collection.id"
          :value="collection.id"
        >
          {{ collection.title }}
        </option>
      </select>
    </div>
    <div class="flex flex-col p-3">
      <div
        class="flex justify-between border-b border-white p-2"
        v-for="tab in tabs"
        :key="tab"
      >
        <div class="flex flex-col">
          <h1>{{ tab.title }}</h1>
          <span>{{ tab.url }}</span>
        </div>
        <div class="flex gap-2">
          <!-- <button>
            <svg
              width="21"
              height="21"
              viewBox="0 0 21 21"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M15 3.3253L18 6.3253M8.00005 5.39531C6.24584 5.64525 4.65168 6.55116 3.53916 7.93029C2.42664 9.30943 1.87853 11.0592 2.00541 12.8265C2.13228 14.5939 2.9247 16.2474 4.22281 17.4535C5.52092 18.6596 7.22812 19.3285 9.00005 19.3253C10.6834 19.3255 12.3105 18.719 13.5831 17.6171C14.8557 16.5151 15.6886 14.9914 15.929 13.3253M11 13.3253L19.385 4.9103C19.7788 4.51646 20.0001 3.98229 20.0001 3.4253C20.0001 2.86832 19.7788 2.33415 19.385 1.9403C18.9912 1.54646 18.457 1.3252 17.9 1.3252C17.343 1.3252 16.8088 1.54646 16.415 1.9403L8 10.3253V13.3253H11Z"
                stroke="#354052"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </button> -->
          <button @click="deleteTab(tab.id)">
            <svg
              width="24"
              height="25"
              viewBox="0 0 24 25"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M4 7.3252H20M10 11.3252V17.3252M14 11.3252V17.3252M5 7.3252L6 19.3252C6 19.8556 6.21071 20.3643 6.58579 20.7394C6.96086 21.1145 7.46957 21.3252 8 21.3252H16C16.5304 21.3252 17.0391 21.1145 17.4142 20.7394C17.7893 20.3643 18 19.8556 18 19.3252L19 7.3252M9 7.3252V4.3252C9 4.05998 9.10536 3.80562 9.29289 3.61809C9.48043 3.43055 9.73478 3.3252 10 3.3252H14C14.2652 3.3252 14.5196 3.43055 14.7071 3.61809C14.8946 3.80562 15 4.05998 15 4.3252V7.3252"
                stroke="#354052"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const collections = ref([]);
const tabs = ref([]);
const newTab = ref({
  title: "",
  url: "",
  collection_id: null, // To store the selected collection
});

// Fetch existing tabs
const fetchtabs = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/tabs", {
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        Authorization: "Bearer " + localStorage.getItem("accessToken"),
      },
    });
    tabs.value = response.data.data;
  } catch (error) {
    console.error("Error fetching tabs:", error);
  }
};

// Fetch available collections
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

// Add a new tab when the button is clicked
const addTab = async () => {
  try {
    const response = await axios.post(
      "http://localhost:8000/api/tabs",
      {
        title: newTab.value.title,
        url: newTab.value.url,
        collection_id: newTab.value.collection_id,
      },
      {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("accessToken"),
        },
      }
    );
    fetchtabs();
    // Optional: You can update the tabs list or give feedback to the user after successfully adding
    console.log("Tab added successfully:", response.data);
  } catch (error) {
    console.error("Error adding tab:", error);
  }
};
const deleteTab = async (TabID) => {
  try {
    const response = await axios.delete(
      `http://localhost:8000/api/tabs/${TabID}`, // Include TabID directly in the URL
      {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("accessToken"),
        },
      }
    );
    alert(response.data.message);
    // Refetch the updated tabs list
    fetchtabs();

    console.log("Tab deleted successfully:", response.data);
  } catch (error) {
    console.error("Error deleting tab:", error);
    alert(response.errors);
  }
};

onMounted(() => {
  fetchtabs(); // Fetch tabs when the component is mounted
  fetchCollections(); // Fetch collections when the component is mounted
});
</script>
