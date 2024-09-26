<template>
  <div class="grid-cols-24 grid h-screen">
    <sideBar />

    <Users />

    <Collections />
  </div>
</template>

<script setup>
  import { Collections, sideBar, Users } from '../components';
</script>
