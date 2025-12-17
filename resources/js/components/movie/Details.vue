<template>
  <div class="modal-overlay">
    <div class="modal details-modal">
      <h2 class="h1-center">Résume</h2>
      <p class="subtitle">Voici le récapitulatif de votre réservation.</p>
      <div class="details-section">
        <span class="label">Film</span>
        <span class="value">Twilight</span>
      </div>
      <div class="details-section">
        <span class="label">Date et horaire</span>
        <span class="value">04.01.2026, 15:30</span>
      </div>
      <div class="details-section">
        <span class="label">Nombre de places</span>
        <span class="value">3</span>
      </div>
      <div class="details-section">
        <span class="label">Sièges réservés</span>
        <span class="value">3A, 4A, 5A</span>
      </div>
      <div class="total">
        <span>Total</span>
        <strong>90 CHF</strong>
      </div>
      <div class="modal-actions">
        <button class="btn-red">Valider & payer</button>
        <button class="btn-red" @click="$emit('close')">Annuler</button>
      </div>
    </div>
  </div>
</template>
