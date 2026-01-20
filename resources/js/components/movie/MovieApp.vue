<template>
  <div class="movie-program">
    <div class="header" style="position: relative; width: 100%">
      <h2 class="title-small">Programme du moment</h2>

      <button
        v-if="isAdmin"
        class="btn-add"
        @click="goStats"
        style="position: absolute; top: 0; right: 0"
      >
        <i class="fa-solid fa-chart-simple"></i> Statistiques
      </button>

      <button v-if="isAdmin" class="btn-add" @click="goAddMovie">
        <i class="fa-solid fa-plus"></i> Ajouter un film
      </button>
    </div>

    <div v-if="loading">
      <p class="title-small">Chargement des films…</p>
    </div>

    <div v-else-if="error">
      <p>Erreur : {{ error }}</p>
    </div>

    <div v-else>
      <div class="container image-container">
        <FilmCard
          v-for="movie in movies"
          :key="movie.id"
          :movie="movie"
          :isAdmin="isAdmin"
          @edit="goFilmModif"
          @delete="deleteFilm"
          @reserve="goReservation"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import FilmCard from "./FilmCard.vue";

export default {
  name: "MovieProgram",

  components: {
    FilmCard,
  },

  data() {
    return {
      movies: [],
      loading: true,
      error: null,
      isAdmin: false,
    };
  },

  methods: {
    async fetchData() {
      try {
        this.loading = true;

        const [moviesRes, adminRes] = await Promise.all([
          fetch("/film/all"),
          fetch("/api/isAdmin"),
        ]);

        if (!moviesRes.ok) throw new Error("Impossible de charger les films");
        if (!adminRes.ok) throw new Error("Impossible d'obtenir le statut admin");

        this.movies = await moviesRes.json();
        this.isAdmin = await adminRes.json();
      } catch (err) {
        this.error = err.message;
      } finally {
        this.loading = false;
      }
    },

    async deleteFilm(id) {
      if (!confirm("Voulez-vous vraiment supprimer ce film ?")) return;

      try {
        await axios.delete(`/film/${id}`);
        this.movies = this.movies.filter((movie) => movie.id !== id);
      } catch (err) {
        alert("Erreur lors de la suppression du film.");
      }
    },

    goReservation(id) {
      this.$router.push(`/reservation/${id}`);
    },

    goFilmModif(id) {
      this.$router.push(`/film/edit/${id}`);
    },

    goAddMovie() {
      this.$router.push(`/film/add`);
    },

    goStats() {
      this.$router.push(`/admin/stats`);
    },
  },

  mounted() {
    this.fetchData();
  },
};
</script>
