<template>
  <div v-if="isRankingMode" class="top-three">
    <div
      v-for="(movie, index) in sortedMovies.slice(0, 3)"
      :key="movie.id"
      class="movie-card top-card"
    >
      <div class="rank">#{{ index + 1 }}</div>
      <img :src="movie.image" class="movie-image" />
      <div class="movie-info dark-text">
        <h3>{{ movie.titre }}</h3>
        <p>Billet vendu : {{ movie.places_vendues }}</p>
        <p>Revenu : {{ movie.revenu.toFixed(2) }} CHF</p>

        <p>Part du revenu : {{ revenueShare(movie) }}%</p>
        <div class="revenue-bar">
          <div class="bar-fill" :style="{ width: revenueShare(movie) + '%' }" />
        </div>

        <div class="admin-actions">
          <button @click="goReservation(movie.id)">Séances</button>
          <button @click="goFilmModif(movie.id)">Modifier</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardTopThree",
  props: {
    movies: {
      type: Array,
      required: true,
    },
    sortedMovies: {
      type: Array,
      required: true,
    },
    isRankingMode: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    goReservation(id) {
      this.$router.push(`/reservation/${id}`);
    },
    goFilmModif(id) {
      this.$router.push(`/film/edit/${id}`);
    },
    revenueShare(movie) {
      const total = this.movies.reduce((s, m) => s + m.revenu, 0);
      return total ? Math.round((movie.revenu / total) * 100) : 0;
    },
  },
};
</script>
