<template>
  <div class="movie-stats">
    <h2 class="title-small">Statistiques & performances</h2>

    <div v-if="loading" class="center">Chargement…</div>
    <div v-else-if="error" class="center error">{{ error }}</div>

    <div v-else>
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
        <div v-if="isRankingMode" class="kpi-card highlight">
          <span> Top film</span>
          <strong>{{ sortedMovies[0]?.titre }}</strong>
        </div>
      </div>

      <div class="sort-bar">
        <label>Trier par :</label>
        <select v-model="sortBy">
          <option value="revenu">Revenu</option>
          <option value="titre">Titre</option>
        </select>
      </div>

      <div v-if="isRankingMode" class="top-three">
        <div
          v-for="(movie, index) in sortedMovies.slice(0, 3)"
          :key="movie.id"
          class="movie-card top-card"
          :style="{ background: topCardBg(index) }"
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
              <button @click="goSeances(movie.id)">Séances</button>
              <button @click="editMovie(movie.id)">Modifier</button>
            </div>
          </div>
        </div>
      </div>

      <div class="cards-container">
        <div v-for="(movie, index) in displayedMovies" :key="movie.id" class="movie-card">
          <div v-if="isRankingMode" class="rank">#{{ index + 4 }}</div>

          <img :src="movie.image" class="movie-image" />

          <div class="movie-info">
            <h3>{{ movie.titre }}</h3>
            <p>Auteur : {{ movie.auteur }}</p>
            <p>Billet vendu : {{ movie.places_vendues }}</p>
            <p>Revenu : {{ movie.revenu.toFixed(2) }} CHF</p>

            <p v-if="isRankingMode && movie.revenu < maxRevenue * 0.2" class="warning">
              ⚠ Faible revenues
            </p>

            <p>Part du revenu : {{ revenueShare(movie) }}%</p>
            <div class="revenue-bar">
              <div class="bar-fill" :style="{ width: revenueShare(movie) + '%' }" />
            </div>

            <div class="admin-actions">
              <button @click="goSeances(movie.id)">Séances</button>
              <button @click="editMovie(movie.id)">Modifier</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "MovieStats",
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
    displayedMovies() {
      return this.isRankingMode ? this.sortedMovies.slice(3) : this.sortedMovies;
    },
    maxRevenue() {
      return this.movies.length ? Math.max(...this.movies.map((m) => m.revenu)) : 0;
    },
    totalRevenue() {
      return this.movies.reduce((sum, m) => sum + m.revenu, 0);
    },
    totalPlaces() {
      return this.movies.reduce((sum, m) => sum + m.places_vendues, 0);
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
    revenueShare(movie) {
      return this.totalRevenue ? Math.round((movie.revenu / this.totalRevenue) * 100) : 0;
    },
    topCardBg(i) {
      if (i === 0) return "linear-gradient(135deg,#FFD700,#FFC107)";
      if (i === 1) return "linear-gradient(135deg,#C0C0C0,#A9A9A9)";
      return "linear-gradient(135deg,#CD7F32,#B87333)";
    },
    goSeances(id) {
      this.$router.push(`/admin/films/${id}/seances`);
    },
    editMovie(id) {
      this.$router.push(`/admin/films/${id}/edit`);
    },
  },
  mounted() {
    this.fetchStats();
  },
};
</script>
