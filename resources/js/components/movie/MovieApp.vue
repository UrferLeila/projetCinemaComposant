<template>
  <div class="movie-program">
    <div class="header" style="position: relative; width: 100%">
      <h2 class="title-small">Programme du moment</h2>

      <button
        v-if="isAdmin"
        class="btn-add2"
        @click="goStats"
        style="position: absolute; top: 0; right: 0"
      >
        <i class="fa-solid fa-chart-simple"></i> Statistiques
      </button>

      <button v-if="isAdmin" class="btn-add2" @click="goAddMovie">
        <i class="fa-solid fa-plus"></i> Ajouter un film
      </button>
    </div>

    <div v-if="loading">
      <p class="title-small">Chargement des films…</p>
    </div>

    <div v-else-if="error">
      <p>Erreur : {{ error }}</p>
    </div>

    <div class="container image-container" v-else>
      <div class="item" v-for="movie in movies" :key="movie.id">
        <div class="image-wrapper">
          <img :src="movie.image" />

          <span
            v-if="isAdmin"
            class="top-icon-edit"
            title="Modifier le film"
            @click="goFilmModif(movie.id)"
          >
            <i class="fa-solid fa-pen"></i>
          </span>

          <span v-if="isAdmin" class="top-icon-delete" @click="deleteFilm(movie.id)">
            <i class="fa-solid fa-trash"></i>
          </span>
        </div>

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
import axios from "axios";

export default {
  name: "MovieProgram",

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
        console.error(err);
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
