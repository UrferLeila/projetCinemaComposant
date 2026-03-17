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


<script setup lang="ts">
  import { ref, onMounted } from "vue";
  import { useRouter } from "vue-router"; 
  import axios from "axios";
  import FilmCard from "./FilmCard.vue";
  import type { Film } from '../../types/Film.ts'


  const movies = ref<Film[]>([]);
  const loading = ref(true);
  const error = ref(null);
  const isAdmin = ref(false);

  const router = useRouter();

  const fetchData = async () => 
  {
    try {
      loading.value = true;
      const [moviesRes, adminRes] = await Promise.all([
        fetch("/film/all"),
        fetch("/api/isAdmin"),
      ]);

      if (!moviesRes.ok) throw new Error("Impossible de charger les films");
      if (!adminRes.ok) throw new Error("Impossible d'obtenir le statut admin");

      movies.value = await moviesRes.json();
      isAdmin.value = await adminRes.json();
    } catch (err) {
      error.value = err.message;
    } finally {
      loading.value = false;
    }
  };

  const deleteFilm = async (id : number | string) =>
  {
    if (!confirm("Voulez-vous vraiment supprimer ce film ?")) return;
    try {
      await axios.delete(`/film/${id}`);
      movies.value = movies.value.filter((movie) => movie.id !== id);
    } catch (err) {
      alert("Erreur lors de la suppression du film.");
    }
  };

  const goReservation = (id : number | string) => router.push(`/reservation/${id}`);
  const goFilmModif = (id : number | string) => router.push(`/film/edit/${id}`);
  const goAddMovie = () => router.push(`/film/add`);
  const goStats = () => router.push(`/admin/stats`);

  onMounted(() => 
  {
    fetchData();
  });
</script>


