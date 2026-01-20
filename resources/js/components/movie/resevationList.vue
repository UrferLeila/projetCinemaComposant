<template>
  <div class="reservation-cart">
    <h2>Résumé de vos réservations</h2>

    <div class="reservation-item" v-for="res in reservations" :key="res.id">
      <div class="movie-info">
        <h3>{{ films[res.seance.film_id] || "Film inconnu" }}</h3>
        <p>
          <strong>Date & Heure :</strong> {{ res.seance.date }} à {{ res.seance.heure }}
        </p>
      </div>

      <div class="seats-info">
        <p>
          <strong>Places réservées :</strong>
          {{ res.reservation_sieges.map((s) => s.siege_nom).join(", ") }}
        </p>

        <p>
          <strong>Total :</strong>
          {{ res.total || res.reservation_sieges.length * 10 }} CHF
        </p>
      </div>
    </div>

    <div class="cart-total" v-if="reservations.length">
      <p><strong>Total général :</strong> {{ totalPrice }} CHF</p>
    </div>
    <p v-else>Vous n'avez aucune réservation.</p>
  </div>
</template>

<script>
export default {
  name: "ReservationSummary",
  data() {
    return {
      reservations: [],
      films: {},
      loading: true,
      error: null,
    };
  },
  computed: {
    totalPrice() {
      const priceMap = { normal: 20, vip: 45 };
      return this.reservations.reduce((sum, seat) => {
        const type = seat.prix_type || seat.prix?.type || "normal";
        return sum + (priceMap[type] || 0);
      }, 0);
    },
  },
  methods: {
    async fetchData() {
      try {
        this.loading = true;

        const resResponse = await fetch("/reservations/");
        if (!resResponse.ok) throw new Error("Impossible de charger les réservations");
        this.reservations = await resResponse.json();

        const filmsResponse = await fetch("/film/all");
        if (!filmsResponse.ok) throw new Error("Impossible de charger les films");
        const filmsArray = await filmsResponse.json();

        this.films = {};
        filmsArray.forEach((f) => {
          this.films[f.id] = f.titre;
        });
      } catch (err) {
        this.error = err.message;
      } finally {
        this.loading = false;
      }
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>
