<template>
  <div v-if="loading">
    <p class="title-small">Chargement du film…</p>
  </div>

  <div v-else-if="error">
    <p>Erreur : {{ error }}</p>
  </div>

  <div class="header-container" v-else>
    <ResumeMovie
      :movie="movie"
      :selectedSeance="selectedSeance"
      @reserve="openConnection"
    />

    <SeanceSelector
      :seances="seances"
      :selectedSeance="selectedSeance"
      @select-seance="selectSeance"
    />

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
            selected: selectedSeats.some((s) => s.nom === seat.nom),
          }"
          @click="toggleSeat(seat)"
        ></div>
      </div>

      <h1 class="h1">Écran</h1>
    </div>
  </div>

  <Details
    v-if="showDetails"
    @close="closeAll"
    @reservation-made="refreshSeats"
    :selectedMovie="movie"
    :selectedSeance="selectedSeance"
    :selectedSeats="selectedSeats"
  />
</template>

<script>
import Details from "@/components/movie/Details.vue";
import SeanceSelector from "@/components/movie/SeanceSelector.vue";
import ResumeMovie from "@/components/movie/ResumeMovie.vue";

export default {
  props: ["id"],
  components: {
    Details,
    SeanceSelector,
    ResumeMovie,
  },
  data() {
    return {
      isAuth: false,
      loading: true,
      error: null,
      seats: [],
      seatRows: [],
      selectedSeats: [],
      showDetails: false,
    };
  },

  methods: {
    refreshSeats() {
      this.loadOccupiedSeats(this.selectedSeance.id);
      this.selectedSeats = [];
    },

    async loadIsAuth() {
      try {
        const response = await fetch("/api/isAuth");
        if (!response.ok) throw new Error("Impossible d'obtenir le statut de connexion");
        const data = await response.json();
        this.isAuth = data;
      } catch (err) {
        this.error = err.message;
      }
    },

    async loadOccupiedSeats(seanceId) {
      try {
        const res = await fetch(`/seance/${seanceId}/occupied`);
        const occupied = await res.json();
        this.seats.forEach((seat) => (seat.occupied = false));
        this.seats.forEach((seat) => {
          if (occupied.includes(seat.nom)) seat.occupied = true;
        });
        this.organizeSeats();
      } catch (err) {
        console.error("Failed to load occupied seats:", err);
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

      const index = this.selectedSeats.findIndex((s) => s.nom === seat.nom);
      if (index !== -1) {
        this.selectedSeats.splice(index, 1);
      } else {
        this.selectedSeats.push(seat);
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

    openConnection() {
      if (!this.selectedSeance || this.selectedSeats.length === 0) {
        alert("Veuillez sélectionner au moins une séance et un siège.");
        return;
      }

      if (this.isAuth) {
        this.showDetails = true;
      } else {
        window.location.href = "/login";
      }
    },

    closeAll() {
      this.showDetails = false;
    },
  },

  async mounted() {
    this.loading = true;
    try {
      const seatsRes = await fetch("/siege");
      if (!seatsRes.ok) throw new Error("Impossible de charger les sièges");
      this.seats = await seatsRes.json();
      this.organizeSeats();

      const filmRes = await fetch(`/film/${this.id}`);
      if (!filmRes.ok) throw new Error("Impossible de charger le film");
      const filmData = await filmRes.json();
      this.movie = filmData;
      this.seances = filmData.seances || [];

      await this.loadIsAuth();
    } catch (err) {
      this.error = err.message;
    } finally {
      this.loading = false;
    }
  },
};
</script>
