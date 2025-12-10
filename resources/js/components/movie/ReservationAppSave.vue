<template>
  <div v-if="loading">
    <p>Chargement du film…</p>
  </div>

  <div v-else-if="error">
    <p>Erreur : {{ error }}</p>
  </div>

  <div class="header-container" v-else>
    <img class="poster-square" :src="movie.image" alt="Poster" />

    <div>
      <h1 class="h1">Choisir une place</h1>

      <h2 class="h2-title">Film</h2>
      <h3 class="h3">{{ movie.titre }}</h3>

      <h2 class="h2-title">Date et Horaire</h2>
      <h3 class="h3">Mardi, 02.12.2025, 17h15</h3>

      <button class="btn-red reserved">Réserver</button>
    </div>

    <div class="selection-column">
      <h1 class="h1-center">Date</h1>
      <div class="header-center">
        <button class="btn reserved">Jeudi 4 décembre</button>
        <button class="btn reserved">Samedi 6 décembre</button>
        <button class="btn reserved">Lundi 8 décembre</button>
      </div>

      <h1 class="h1-center">Heure</h1>
      <div class="header-center">
        <button class="btn reserved">13h30</button>
        <button class="btn reserved">15h20</button>
        <button class="btn reserved">17h00</button>
        <button class="btn reserved">20h30</button>
      </div>
    </div>

    <!-- SEATS -->
    <div class="seats-wrapper">

      <!-- LEGEND -->
      <div class="legend-container">
        <div class="legend-item">
          <div class="color normal"></div>
          <span>Normal</span>
        </div>
        <div class="legend-item">
          <div class="color vip"></div>
          <span>VIP</span>
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

      <!-- Seats dynamically rendered -->
      <div v-for="(row, rowIndex) in seatRows" :key="rowIndex" class="seats-container">
        <div v-for="seat in row" 
             :key="seat.nom" 
             class="seat"
             :class="{
               vip: seat.prix?.type === 'vip',
               occupied: seat.occupied,
               selected: selectedSeats.includes(seat.nom)
             }"
             @click="toggleSeat(seat)">
        </div>
      </div>

      <h1 class="h1-center">Écran</h1>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],

  data() {
    return {
      movie: null,
      loading: true,
      error: null,
      seats: [],
      seatRows: [],
      selectedSeats: [],
    };
  },

  methods: {
    toggleSeat(seat) {
      if (seat.occupied) return;
      if (this.selectedSeats.includes(seat.nom)) {
        this.selectedSeats = this.selectedSeats.filter(id => id !== seat.nom);
      } else {
        this.selectedSeats.push(seat.nom);
      }
    },

    // Organize seats into rows for display
    organizeSeats(rowsCount = 3, seatsPerRow = 7) {
      const allSeats = [...this.seats];
      this.seatRows = [];
      for (let i = 0; i < rowsCount; i++) {
        this.seatRows.push(allSeats.splice(0, seatsPerRow));
      }
      // Add remaining seats as extra row
      if (allSeats.length > 0) {
        this.seatRows.push(allSeats);
      }
    }
  },

  async mounted() {
    try {
      // Fetch movie data
      const movieRes = await fetch(`/film/${this.id}`);
      if (!movieRes.ok) throw new Error("Impossible de charger le film");
      this.movie = await movieRes.json();

      // Fetch seats from API
      const seatsRes = await fetch(`/siege`);
      if (!seatsRes.ok) throw new Error("Impossible de charger les sièges");
      this.seats = await seatsRes.json();

      // Randomly occupy some seats for demo purposes
      this.seats.forEach(seat => {
        seat.occupied = Math.random() < 0.2; // 20% seats randomly occupied
      });

      // Organize into rows
      this.organizeSeats();
    } catch (err) {
      this.error = err.message;
    } finally {
      this.loading = false;
    }
  }
};
</script>
