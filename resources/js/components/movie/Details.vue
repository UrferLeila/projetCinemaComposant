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

<script>
import axios from "axios";

export default {
  props: {
    selectedMovie: { type: Object, required: true },
    selectedSeance: { type: Object, required: true },
    selectedSeats: { type: Array, required: true },
  },
  computed: {
    seatNames() {
      return this.selectedSeats.map((seat) => seat.nom);
    },
    totalPrice() {
      const priceMap = { normal: 20, vip: 45 };
      return this.selectedSeats.reduce((sum, seat) => {
        const type = seat.prix_type || seat.prix?.type || "normal";
        return sum + (priceMap[type] || 0);
      }, 0);
    },
  },
  methods: {
    async confirmReservation() {
      if (!this.selectedSeance.id) {
        alert("Séance invalide, veuillez la sélectionner à nouveau.");
        return;
      }

      if (!this.selectedSeats.length) {
        alert("Veuillez sélectionner au moins un siège.");
        return;
      }

      try {
        const response = await axios.post("/reservations", {
          seance_id: this.selectedSeance.id,
          seats: this.selectedSeats.map((seat) => seat.nom),
        });

        if (response.data.success) {
          alert("Réservation confirmée !");
          this.$emit("close");
          this.$emit("reservation-made");
        }
      } catch (error) {
        if (error.response && error.response.status === 409) {
          alert(error.response.data.message);
        } else if (error.response && error.response.status === 422) {
          alert("Données invalides pour la réservation.");
          console.error(error.response.data.errors);
        } else {
          console.error(error);
          alert("Erreur lors de la réservation.");
        }
      }
    },
  },
};
</script>
