<template>
  <div v-if="isRankingMode" class="top-three">
    <div
      v-for="(movie, index) in sortedMovies.slice(0, 3)"
      :key="movie.id"
      class="movie-card top-card"
    >
      <div class="rank">#{{ index + 1 }}</div>
      <img :src="movie.image" class="movie-image" />
      <div class="movie-info">
        <h3>{{ movie.titre }}</h3>
        <p>Billet vendu : {{ movie.places_vendues }}</p>
        <p>Revenu : {{ movie.revenu.toFixed(2) }} CHF</p>

        <p>Part du revenu : {{ revenueShare(movie) }}%</p>
        <div class="revenue-bar">
          <div class="bar-fill" :style="{ width: revenueShare(movie) + '%' }" />
        </div>

        <div class="admin-actions">
          <button @click="goReservation(movie.id)">Séances</button>
          <button @click="goEdit(movie.id)">Modifier</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";

interface Movie {
  id: number | string;
  titre: string;
  image: string;
  places_vendues: number;
  revenu: number;
}

const router = useRouter();

const props = defineProps<{
  movies: Movie[];
  sortedMovies: Movie[];
  isRankingMode: boolean;
}>();

function goReservation(id: number | string): void {
  router.push(`/reservation/${id}`);
}

function goEdit(id: number | string): void {
  router.push(`/film/edit/${id}`);
}

function revenueShare(movie: Movie): number {
  const total = props.movies.reduce((s, m) => s + m.revenu, 0);
  return total ? Math.round((movie.revenu / total) * 100) : 0;
}
</script>