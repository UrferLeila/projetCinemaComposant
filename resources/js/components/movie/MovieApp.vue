<template>
  <div class="movie-program">
    <h2 class="title-small">Programme du jour</h2>

    <div v-if="loading">
      <p>Chargement des films…</p>
    </div>

    <div v-else-if="error">
      <p>Erreur : {{ error }}</p>
    </div>

    <div class="container image-container" v-else>
      <div class="item" v-for="movie in movies" :key="movie.id">
        <img :src="movie.image" />
        <div class="info">
          <h3>{{ movie.titre }}</h3>
          <h3>{{ movie.auteur }}</h3>
        </div>
        <button class="btn-red" @click="goReservation(movie.id)">Réserver</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      movies: [],
      loading: true,
      error: null,
    };
  },
  methods: {
    async refresh() {
      try {
        const response = await fetch("/film/all");
        if (!response.ok) throw new Error("Impossible de charger les films");
        const data = await response.json();
        this.movies = data;
      } catch (err) {
        this.error = err.message;
      } finally {
        this.loading = false;
      }
    },

    goReservation(id) {
      this.$router.push(`/reservation/${id}`);
    },
  },

  mounted() {
    this.refresh();
  },
};
</script>
