<template>
  <div class="cards-container">
    <div v-for="(movie, index) in displayedMovies" :key="movie.id" class="movie-card">
      <div v-if="isRankingMode" class="rank">#{{ index + 4 }}</div>

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
        </div>l
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()

const props = defineProps({
  movies: {
    type: Array,
    required: true
  },
  sortedMovies: {
    type: Array,
    required: true
  },
  isRankingMode: {
    type: Boolean,
    required: true
  }
})

function goReservation(id) {
  router.push(`/reservation/${id}`)
}

function goEdit(id) {
  router.push(`/film/edit/${id}`)
}

function revenueShare(movie) {
  const total = props.movies.reduce((s, m) => s + m.revenu, 0)
  return total ? Math.round((movie.revenu / total) * 100) : 0
}

const displayedMovies = computed(() => {
  return props.isRankingMode ? props.sortedMovies.slice(3) : props.sortedMovies
})

const maxRevenue = computed(() => {
  return props.movies.length
    ? Math.max(...props.movies.map((m) => m.revenu))
    : 0
})
</script>