<template>
  <div class="modal-overlay">
    <div class="modal details-modal">
      <h2 class="h1-center">Résumé</h2>
      <p class="subtitle">Voici le récapitulatif de votre réservation.</p>

      <div class="details-section">
        <span class="label">Film</span>
        <span class="value">{{ selectedMovie.titre }}</span>
      </div>

      <div class="details-section">
        <span class="label">Date et horaire</span>
        <span class="value">{{ selectedSeance.date }} {{ selectedSeance.heure }}</span>
      </div>

      <div class="details-section">
        <span class="label">Nombre de places</span>
        <span class="value">{{ selectedSeats.length }}</span>
      </div>

      <div class="details-section">
        <span class="label">Sièges réservés</span>
        <span class="value">{{ seatNames.join(", ") }}</span>
      </div>

      <div class="total">
        <span>Total</span>
        <strong>{{ totalPrice }} CHF</strong>
      </div>

      <div class="modal-actions">
        <button class="btn-red" @click="confirmReservation">Confirmer</button>
        <button class="btn-red" @click="$emit('close')">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { computed } from "vue";
  import axios from "axios";

  import type { Film } from '../../../types/Film.ts';
  import type { Seance } from '../../../types/Seance.ts';
  import type { Siege } from '../../../types/Siege.ts';

  const props = defineProps<{
    selectedMovie: Film;
    selectedSeance: Seance;
    selectedSeats: Siege[]; 
  }>();

  const emit = defineEmits(['close', 'reservation-made']);

  const seatNames = computed(() => 
  {
    return props.selectedSeats.map((seat) => seat.nom);
  });

  const totalPrice = computed(() => 
  {
    return props.selectedSeats.reduce((sum, seat) => {
      const price = seat.prix?.prix ?? 20; 
      return sum + price;
    }, 0);
  });

  const confirmReservation = async () => 
  {
    if (!props.selectedSeance.id) {
      alert("Séance invalide.");
      return;
    }

    try {
      const response = await axios.post("/reservations", {
        seance_id: props.selectedSeance.id,
        seats: props.selectedSeats.map(s => s.nom),
      });

      if (response.status === 200 || response.status === 201) {
        alert('Réservation confirmée !');
        emit('close');
        emit('reservation-made');
      }
    } 
    
    // catch (error) {
    //   const status = error.response?.status;
    //   if (status === 409) {
    //     alert(error.response.data.message);
    //   } else {
    //     alert("Erreur lors de la réservation.");
    //   }
    // }

   catch (error) {
    let message: string = "Une erreur inconnue est survenue.";

  if (axios.isAxiosError(error)) {
    const status = error.response?.status;
    const serverMessage = error.response?.data?.message;

    if (status === 409 && serverMessage) {
      message = serverMessage;
    } else if (status === 422) {
      message = "Données invalides pour la réservation.";
    } else {
      message = "Erreur lors de la réservation (Serveur).";
    }
  } 
  else if (error instanceof Error) {
    message = error.message;
  } 
  else {
    message = String(error);
  }
  
  alert(message);
}
  }
</script>