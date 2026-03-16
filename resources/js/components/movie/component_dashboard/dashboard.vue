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

<script setup>
import { ref, computed, onMounted } from "vue"
import axios from "axios";

import StatMovie from "./StatMovie.vue";
import CardTopThree from "./CardTopThree.vue";
import CardRanking from "./CardRanking.vue";

const movies = ref([])
const loading = ref(true)
const error = ref(null)
const sortBy = ref("revenu")

const isRankingMode = computed(() => {
  return sortBy.value === "revenu"
})

const sortedMovies = computed(() => {
  return [...movies.value].sort((a, b) => {
    if (sortBy.value === "titre") {
      return a.titre.localeCompare(b.titre)
    }
    return b.revenu - a.revenu
  })
})

async function fetchStats() {
  try {
    const res = await axios.get("/admin/film-stats")

    movies.value = res.data.map((film) => {
      const places_vendues = film.seances.reduce((s, seance) => {
        return (
          s +
          seance.reservations.reduce(
            (r, res) => r + res.reservation_sieges.length,
            0
          )
        )
      }, 0)

      return {
        ...film,
        places_vendues,
        revenu: places_vendues * 12,
      }
    })
  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchStats()
})
</script>
