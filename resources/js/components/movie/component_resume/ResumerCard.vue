<template>
  <div class="resumer-card">
    <div
      class="reservation-item"
      v-for="res in reservations"
      :key="res.id"
    >
      <div class="movie-info">
        <h3>{{ filmsMap[res.seance?.film_id ?? 0] || "Film inconnu" }}</h3>
        <p>
          <strong>Date & Heure :</strong>
          {{ res.seance?.date || "?" }} à {{ res.seance?.heure || "?" }}
        </p>
      </div>
      <div class="seats-info">
        <p>
          <strong>Places réservées :</strong>
          {{ res.reservationSieges?.map((s) => s.siege_nom).join(", ") || "Aucune" }}
        </p>

        <p>
          <strong>Total :</strong> {{ res.total_price || 0 }} CHF
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import type { Film } from '../../../types/Film.ts'
  import type { Reservation } from '../../../types/Reservation.ts'
  import { computed } from "vue";


  const filmsMap = computed(() => 
  {
  const map: Record<number, string> = {};
  props.films.forEach(film => {
    if (film.id) map[Number(film.id)] = film.titre;
  });
  return map;
  });

  //Composition
  const props = defineProps<{
    films: Film[]; 
    reservations: Reservation[];
  }>()

  
</script>

