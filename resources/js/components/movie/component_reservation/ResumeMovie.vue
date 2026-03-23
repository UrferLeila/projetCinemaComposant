<template>
  <div class="header-container">
    <img class="poster-square" :src="movie.image" alt="Affiche du film" />
    <div>
      <h1 class="h1">Choisir une place</h1>

      <h2 class="h2-title">Film</h2>
      <h3 class="h3">{{ movie.titre }}</h3>

      <h2 class="h2-title">Date et Horaire</h2>
      <h3 class="h3" v-if="selectedSeance">{{ formatSeance(selectedSeance) }}</h3>
      <h3 class="h3" v-else>Sélectionnez une séance</h3>

      <button class="btn-red" @click="$emit('reserve')">Réserver</button>
    </div>
  </div>
</template>

<script setup lang="ts">
  import type { Seance } from '../../../types/Seance.ts'
  import type { Film } from '../../../types/Film.ts'


   const props = defineProps<{
    movie: Film; 
    selectedSeance: Seance;
  }>()

    const formatSeance = (seance : Seance) => 
    {
      if (!seance) return "";
      const date = new Date(seance.date).toLocaleDateString("fr-CH", {
        weekday: "long",
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });
      return `${date}, ${seance.heure}`;
    };

</script>