<template>
  <div class="movie-stats">
    <h2 class="title-small">Statistiques & performances</h2>

    <div v-if="loading" class="center">Chargement…</div>
    <div v-else-if="error" class="center error">{{ error }}</div>

    <div v-else>
      <StatMovie
        :movies="movies"
        :sortedMovies="sortedMovies"
        :isRankingMode="isRankingMode"
      />

      <CardTopThree
        :movies="movies"
        :sortedMovies="sortedMovies"
        :isRankingMode="isRankingMode"
      />

      <CardRanking
        :movies="movies"
        :sortedMovies="sortedMovies"
        :isRankingMode="isRankingMode"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import StatMovie from "./StatMovie.vue";
import CardTopThree from "./CardTopThree.vue";
import CardRanking from "./CardRanking.vue";

export default {
  components: { StatMovie, CardTopThree, CardRanking },
  data() {
    return {
      movies: [],
      loading: true,
      error: null,
      sortBy: "revenu",
    };
  },
  computed: {
    isRankingMode() {
      return this.sortBy === "revenu";
    },
    sortedMovies() {
      return [...this.movies].sort((a, b) => {
        if (this.sortBy === "titre") return a.titre.localeCompare(b.titre);
        return b.revenu - a.revenu;
      });
    },
  },
  methods: {
    async fetchStats() {
      try {
        const res = await axios.get("/admin/film-stats");

        this.movies = res.data.map((film) => {
          const places_vendues = film.seances.reduce((s, seance) => {
            return (
              s +
              seance.reservations.reduce((r, res) => r + res.reservation_sieges.length, 0)
            );
          }, 0);

          return {
            ...film,
            places_vendues,
            revenu: places_vendues * 12,
          };
        });
      } catch (e) {
        this.error = e.message;
      } finally {
        this.loading = false;
      }
    },
  },
  mounted() {
    this.fetchStats();
  },
};
</script>
