<template>
  <div class="edit-movie-page">
    <EditMovie :id="id" />
  </div>
</template>

<script>
import EditMovie from "@/components/movie/EditMovie.vue";

export default {
  name: "EditMoviePage",
  components: {
    EditMovie,
  },
  props: {
    id: {
      type: [String, Number],
      required: true,
    },
  },
};
</script>
