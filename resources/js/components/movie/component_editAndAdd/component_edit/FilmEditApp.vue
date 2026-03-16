<template>
  <div class="edit-movie-page">
    <EditMovie :id="id" />
  </div>
</template>

<script setup>
import { defineProps } from "vue";
import EditMovie from "@/components/movie/component_editAndAdd/component_edit/EditMovie.vue";

const props = defineProps({
  id: {
    type: [String, Number],
    required: true,
  },
});
</script>