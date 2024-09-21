<template>
  <div class="grid grid-cols-10">
     <sideBar/>

     <Users />

     <Collections />
   </div>
</template>

<script setup>
import { Collections, sideBar, Users } from '../components'
</script>

<style>
/* make it smaller */
.grid-cols-24 {
  grid-template-columns: repeat(24, minmax(0, 1fr));
}
</style>
