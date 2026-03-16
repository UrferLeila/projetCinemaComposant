<template>
  <div class="reservation-cart">
    <h2>Résumé de vos réservations</h2>

    <!-- Résumer Card Component -->
    <ResumerCard :films="films" :reservations="reservations" />

    <!-- Total général -->
    <div class="cart-total" v-if="reservations.length">
      <p><strong>Total général :</strong> {{ totalPrice }} CHF</p>
    </div>
    <p v-else>Vous n'avez aucune réservation.</p>

    <!-- Error / Loading -->
    <p v-if="loading">Chargement...</p>
    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script setup>
  //Composition

  import ResumerCard from "./ResumerCard.vue";
  import { ref, onMounted, computed } from "vue";

  const reservations = ref([]);
  const films = ref({});
  const loading = ref(false);
  const error = ref(null);

  const totalPrice = computed(() => 
  {
      return reservations.value.reduce(
        (sum, res) => sum + (res.total_price || 0),
        0
      );
  });
  
  const fetchData = async () => 
  {
    try {
      loading.value = true; // Use .value

      const resResponse = await fetch("/api/reservations");
      if (!resResponse.ok) throw new Error("Impossible de charger les réservations");
      
      const reservationsData = await resResponse.json();

      const reservationsWithPrice = await Promise.all(
        reservationsData.map(async (res) => {
          const priceResponse = await fetch(`/api/totalPrice/${res.id}`);
          if (!priceResponse.ok) throw new Error(`Erreur prix ID: ${res.id}`);
          const priceData = await priceResponse.json();
          return { ...res, total_price: priceData.total_price };
        })
      );

      reservations.value = reservationsWithPrice; // Use .value

      const filmsResponse = await fetch("/film/all");
      if (!filmsResponse.ok) throw new Error("Impossible de charger les films");
      const filmsArray = await filmsResponse.json();

      // Resetting the object map
      const tempFilms = {};
      filmsArray.forEach((f) => {
        tempFilms[f.id] = f.titre;
      });
      films.value = tempFilms; // Update the ref

    } catch (err) {
      error.value = err.message;
    } finally {
      loading.value = false;
    }
  };

  onMounted(() => 
  {
    fetchData();
  });

</script>


<!-- <script>
  //Options
import ResumerCard from "./ResumerCard.vue";

export default {
  name: "ReservationSummary",
  components: { ResumerCard },

  data() {
    return {
      reservations: [],
      films: {}, // films as an object map { id: titre }
      loading: false,
      error: null,
    };
  },

  computed: {
    totalPrice() {
      return this.reservations.reduce(
        (sum, res) => sum + (res.total_price || 0),
        0
      );
    },
  },

  methods: {
    async fetchData() 
    {
      try {
        this.loading = true;

        // 1️⃣ Fetch reservations
        const resResponse = await fetch("/api/reservations");
        if (!resResponse.ok)
          throw new Error("Impossible de charger les réservations");
        const reservationsData = await resResponse.json();

        // 2️⃣ Fetch total price for each reservation
        const reservationsWithPrice = await Promise.all(
          reservationsData.map(async (res) => {
            const priceResponse = await fetch(`/api/totalPrice/${res.id}`);
            if (!priceResponse.ok)
              throw new Error(
                `Impossible de charger le prix pour la réservation ${res.id}`
              );
            const priceData = await priceResponse.json();
            return { ...res, total_price: priceData.total_price };
          })
        );
        this.reservations = reservationsWithPrice;

        // 3️⃣ Fetch films
        const filmsResponse = await fetch("/film/all");
        if (!filmsResponse.ok) throw new Error("Impossible de charger les films");
        const filmsArray = await filmsResponse.json();

        // Map films as object for fast lookup
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
</script> -->
