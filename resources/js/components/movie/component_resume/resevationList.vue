<template>
  <div class="reservation-cart">
    <h2>Résumé de vos réservations</h2>

    <ResumerCard :films="films" :reservations="reservations" />

    <div class="cart-total" v-if="reservations.length">
      <p><strong>Total général :</strong> {{ totalPrice }} CHF</p>
    </div>
    <p v-else>Vous n'avez aucune réservation.</p>

    <p v-if="loading">Chargement...</p>
    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
  //Composition

  import ResumerCard from "./ResumerCard.vue";
  import { ref, onMounted, computed } from "vue";
  import type { Reservation } from '../../../types/Reservation.ts';
  import type { Film } from '../../../types/Film.ts';

  const reservations = ref<Reservation[]>([]);  
  const films = ref<Film[]>([]); 
  const loading = ref(false);
  const error = ref<string | null>(null);

  const totalPrice = computed(() => 
  {
      return reservations.value.reduce(
        (sum, res: Reservation) => sum + (res.total_price || 0),
        0
      );
  });
  
  const fetchData = async () => 
  {
    try {
      loading.value = true; 

      const resResponse = await fetch("/api/reservations");
      if (!resResponse.ok) throw new Error("Impossible de charger les réservations");
      
      const reservationsData = await resResponse.json();

      const reservationsWithPrice = await Promise.all(
        reservationsData.map(async (res : Reservation) => {
          const priceResponse = await fetch(`/api/totalPrice/${res.id}`);
          if (!priceResponse.ok) throw new Error(`Erreur prix ID: ${res.id}`);
          const priceData = await priceResponse.json();
          return { ...res, total_price: priceData.total_price };
        })
      );

      reservations.value = reservationsWithPrice;

      const filmsResponse = await fetch("/film/all");
      if (!filmsResponse.ok) throw new Error("Impossible de charger les films");
      const filmsArray: Film[] = await filmsResponse.json();      
      
      films.value = filmsArray;

    } catch (err) {
      error.value = err instanceof Error ? err.message : String(err);
    } finally {
      loading.value = false; 
    }
  };

  onMounted(() => 
  {
    fetchData();
  });

</script>
