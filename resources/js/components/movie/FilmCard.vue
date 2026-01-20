<template>
  <div class="item">
    <div class="image-wrapper">
      <img :src="movie.image" />

      <span v-if="isAdmin" class="top-icon-edit" @click="$emit('edit', movie.id)">
        <i class="fa-solid fa-pen"></i>
      </span>

      <span v-if="isAdmin" class="top-icon-delete" @click="$emit('delete', movie.id)">
        <i class="fa-solid fa-trash"></i>
      </span>
    </div>

    <div class="info">
      <h3>{{ movie.titre }}</h3>
      <h3>{{ movie.auteur }}</h3>
    </div>

    <button class="btn-red" @click="$emit('reserve', movie.id)">Réserver</button>
  </div>
</template>

<script>
export default {
  name: "FilmCard",

  props: {
    movie: {
      type: Object,
      required: true,
    },
    isAdmin: {
      type: Boolean,
      default: false,
    },
  },
};
</script>
