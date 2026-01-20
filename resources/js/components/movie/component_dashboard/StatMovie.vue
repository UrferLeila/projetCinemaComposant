<template>
  <div class="kpi-grid">
    <div class="kpi-card">
      <span> Revenu total</span>
      <strong>{{ totalRevenue.toFixed(2) }} CHF</strong>
    </div>
    <div class="kpi-card">
      <span> Places vendues</span>
      <strong>{{ totalPlaces }}</strong>
    </div>
    <div class="kpi-card">
      <span> Films</span>
      <strong>{{ movies.length }}</strong>
    </div>
    <div v-if="isRankingMode" class="kpi-card">
      <span> Top film</span>
      <strong>{{ sortedMovies[0]?.titre }}</strong>
    </div>
  </div>
</template>

<script>
export default {
  name: "StatMovie",
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
  computed: {
    totalRevenue() {
      return this.movies.reduce((sum, m) => sum + m.revenu, 0);
    },
    totalPlaces() {
      return this.movies.reduce((sum, m) => sum + m.places_vendues, 0);
    },
  },
};
</script>
