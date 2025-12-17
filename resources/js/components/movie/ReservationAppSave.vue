<template>
  <div v-if="loading">
    <p class="title-small">Chargement du film…</p>
  </div>

  <div v-else-if="error">
    <p>Erreur : {{ error }}</p>
  </div>

  <div class="header-container" v-else>
    <img class="poster-square" :src="movie.image" />
    <div>
      <h1 class="h1">Choisir une place</h1>
      <h2 class="h2-title">Film</h2>
      <h3 class="h3">{{ movie.titre }}</h3>
      <h2 class="h2-title">Date et Horaire</h2>
      <h3 class="h3" v-if="selectedSeance">{{ formatSeance(selectedSeance) }}</h3>
      <h3 class="h3" v-else>Sélectionnez une séance</h3>

      <button class="btn-red" v-if="isAuth" @click="openConnection">Réserver</button>
      <button class="btn-red" v-else="isAuth" @click="openConnection">Réserver</button>
    </div>
    <div class="selection-column">
      <h1 class="h1-center">Choisir la séance</h1>
      <div class="header-center">
        <button
          v-for="(seance, index) in seances"
          :key="index"
          class="btn"
          :class="{ selected: selectedSeance === seance }"
          @click="selectSeance(seance)"
        >
          {{ new Date(seance.date).toLocaleDateString("fr-CH") }}, {{ seance.heure }}
        </button>
      </div>
    </div>

    <div class="seats-wrapper">
      <div class="legend-container">
        <div class="legend-item">
          <div class="color normal"></div>
          <span>Normal (20 CHF)</span>
        </div>
        <div class="legend-item">
          <div class="color vip"></div>
          <span>VIP (45 CHF)</span>
        </div>
        <div class="legend-item">
          <div class="color selected"></div>
          <span>Votre choix</span>
        </div>
        <div class="legend-item">
          <div class="color occupied"></div>
          <span>Occupé</span>
        </div>
      </div>

      <div
        v-for="(row, rowIndex) in seatRows"
        :key="rowIndex"
        :class="[
          'seats-container',
          row[0]?.prix?.type === 'vip' ? 'seats-container-vip' : 'seats-container-normal',
        ]"
      >
        <div
          v-for="seat in row"
          :key="seat.nom"
          class="seat"
          :class="{
            vip: seat.prix?.type === 'vip',
            normal: seat.prix?.type !== 'vip',
            occupied: seat.occupied,
            selected: selectedSeats.includes(seat.nom),
          }"
          @click="toggleSeat(seat)"
        ></div>
      </div>

      <h1 class="h1">Écran</h1>
    </div>
  </div>

  <Details v-if="showDetails" @close="closeAll" />
</template>

<script>
import Details from "@/components/movie/Details.vue";

export default {
  props: ["id"],
  components: {
    Details,
  },

  data() {
    return {
      isAuth: false,
      movie: null,
      loading: true,
      error: null,
      seats: [],
      seatRows: [],
      selectedSeats: [],
      seances: [],
      selectedSeance: null,
      showDetails: false,
    };
  },

  methods: {
    async loadIsAuth() {
      try {
        const response = await fetch("/api/isAuth");
        if (!response.ok) throw new Error("Impossible d'obtenir le statue de connection");
        const data = await response.json();
        this.isAuth = data;
      } catch (err) {
        this.error = err.message;
      } finally {
        this.loading = false;
      }
    },

    async loadOccupiedSeats(seanceId) {
      try {
        const res = await fetch(`/seance/${seanceId}/occupied`);
        const occupied = await res.json();
        this.seats.forEach((seat) => (seat.occupied = false));
        this.seats.forEach((seat) => {
          if (occupied.includes(seat.nom)) {
            seat.occupied = true;
          }
        });
        this.organizeSeats();
      } catch (error) {
        console.error("Failed to load occupied seats:", error);
      }
    },

    selectSeance(seance) {
      this.selectedSeance = seance;
      this.selectedSeats = [];
      this.loadOccupiedSeats(seance.id);
    },

    toggleSeat(seat) {
      if (!this.selectedSeance) {
        alert("Veuillez sélectionner une séance avant de choisir un siège.");
        return;
      }
      if (seat.occupied) return;
      if (this.selectedSeats.includes(seat.nom)) {
        this.selectedSeats = this.selectedSeats.filter((id) => id !== seat.nom);
      } else {
        this.selectedSeats.push(seat.nom);
      }
    },

    organizeSeats() {
      const vipSeats = this.seats.filter((s) => s.prix?.type === "vip");
      const normalSeats = this.seats.filter((s) => s.prix?.type !== "vip");
      this.seatRows = [];
      for (let i = 0; i < vipSeats.length; i += 7) {
        this.seatRows.push(vipSeats.slice(i, i + 7));
      }
      for (let i = 0; i < normalSeats.length; i += 13) {
        this.seatRows.push(normalSeats.slice(i, i + 13));
      }
    },

    formatSeance(seance) {
      const date = new Date(seance.date).toLocaleDateString("fr-CH", {
        weekday: "long",
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });
      return `${date}, ${seance.heure}`;
    },

    openConnection() {
      if (this.isAuth) {
        this.showDetails = true;
      } else {
        window.location.href = "/login";
      }
    },

    openDetails() {
      this.closeAll();
      this.showDetails = true;
    },

    closeAll() {
      this.showDetails = false;
    },
  },

  async mounted() {
    this.loading = true;
    try {
      // Load seats
      const seatsRes = await fetch(`/siege`);
      if (!seatsRes.ok) throw new Error("Impossible de charger les sièges");
      this.seats = await seatsRes.json();
      this.organizeSeats();

      // Load film
      const filmRes = await fetch(`/film/${this.id}`);
      if (!filmRes.ok) throw new Error("Impossible de charger le film");
      const filmData = await filmRes.json();
      this.movie = filmData;
      this.seances = filmData.seances || [];

      // Load auth status
      await this.loadIsAuth();
    } catch (err) {
      this.error = err.message;
    } finally {
      this.loading = false;
    }
  },
};
</script>
