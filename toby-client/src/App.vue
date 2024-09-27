<script setup lang="ts">
import { useRouter } from "vue-router";
import { onMounted } from "vue";

const router = useRouter();

onMounted(() => {
  // Check if access token exists in localStorage
  const token = localStorage.getItem("accessToken");

  // If no token is found, redirect to login
  if (!token) {
    router.push("/login");
  }
});
</script>

<template>
  <main class="">
    <router-view />
  </main>
</template>

<style scoped></style>
