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
          {{ res.total_price }} CHF
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
      return this.reservations.reduce((sum, res) => sum + (res.total_price || 0), 0);
    },
  },
  methods: {
    async fetchData() {
      try {
        this.loading = true;

        // 1. Fetch all reservations
        const resResponse = await fetch("/api/reservations");
        if (!resResponse.ok) throw new Error("Impossible de charger les réservations");
        const reservationsData = await resResponse.json();

        // 2. Fetch total price for each reservation from the API
        const reservationsWithPrice = await Promise.all(
          reservationsData.map(async (res) => {
            const priceResponse = await fetch(`/api/totalPrice/${res.id}`);
            if (!priceResponse.ok) throw new Error(`Impossible de charger le prix pour la réservation ${res.id}`);
            const priceData = await priceResponse.json();
            return {
              ...res,
              total_price: priceData.total_price,
            };
          })
        );

        this.reservations = reservationsWithPrice;

        // 3. Fetch films
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
