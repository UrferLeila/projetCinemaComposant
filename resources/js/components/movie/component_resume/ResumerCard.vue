<template>
  <div class="resumer-card">
    <div
      class="reservation-item"
      v-for="res in reservations"
      :key="res.id"
    >
      <div class="movie-info">
        <h3>{{ films[res.seance?.film_id] || "Film inconnu" }}</h3>
        <p>
          <strong>Date & Heure :</strong>
          {{ res.seance?.date || "?" }} à {{ res.seance?.heure || "?" }}
        </p>
      </div>

      <div class="seats-info">
        <p>
          <strong>Places réservées :</strong>
          {{ res.reservation_sieges?.map((s) => s.siege_nom).join(", ") || "Aucune" }}
        </p>

        <p>
          <strong>Total :</strong> {{ res.total_price || 0 }} CHF
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ResumerCard",

  props: {
    films: {
      type: Object, // films as object map
      required: true,
    },
    reservations: {
      type: Array,
      required: true,
    },
  },
};
</script>

