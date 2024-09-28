<template>
  <div class="grid-cols-24 grid h-screen">
    <sideBar />

    <Users />

    <Collections />
    <Tabs />
  </div>
</template>

<script setup>
import { Collections, sideBar, Users, Tabs } from "../sections";
</script>
