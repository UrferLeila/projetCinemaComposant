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
          <span>Normal (20CHF)</span>
        </div>
        <div class="legend-item">
          <div class="color vip"></div>
          <span>VIP (45CHF)</span>
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

      <!-- ROW 1 – 7 VIP seats -->
      <div class="seats-container-small">
        <div v-for="seat in seatsRow1"
             :key="seat.id"
             class="seat"
             :class="{
               vip: seat.type === 'vip',
               occupied: seat.occupied,
               selected: selectedSeats.includes(seat.id)
             }"
             @click="toggleSeat(seat)">
        </div>
      </div>

      <!-- ROW 2 – 7 VIP seats -->
      <div class="seats-container-small">
        <div v-for="seat in seatsRow2"
             :key="seat.id"
             class="seat"
             :class="{
               vip: seat.type === 'vip',
               occupied: seat.occupied,
               selected: selectedSeats.includes(seat.id)
             }"
             @click="toggleSeat(seat)">
        </div>
      </div>

      <!-- BIG ROWS – 13 seats each -->
      <div class="seats-container" v-for="(row, rowIndex) in bigSeatRows" :key="rowIndex">
        <div v-for="seat in row"
             :key="seat.id"
             class="seat"
             :class="{
               vip: seat.type === 'vip',
               occupied: seat.occupied,
               selected: selectedSeats.includes(seat.id)
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

      selectedSeats: [],

      // ROW 1 (7 seats)
      seatsRow1: Array.from({ length: 7 }, (_, i) => ({
        id: `row1-${i}`,
        type: "vip",
        occupied: false
      })),

      // ROW 2 (7 seats)
      seatsRow2: Array.from({ length: 7 }, (_, i) => ({
        id: `row2-${i}`,
        type: "vip",
        occupied: false
      })),

      // 3 × rows of 13 seats
      bigSeatRows: [
        Array.from({ length: 13 }, (_, i) => ({ id: `b1-${i}`, type: "normal", occupied: false })),
        Array.from({ length: 13 }, (_, i) => ({ id: `b2-${i}`, type: "normal", occupied: false })),
        Array.from({ length: 13 }, (_, i) => ({ id: `b3-${i}`, type: "normal", occupied: false }))
      ]
    };
  },

  methods: {
    toggleSeat(seat) {
      if (seat.occupied) return;
      if (this.selectedSeats.includes(seat.id)) {
        this.selectedSeats = this.selectedSeats.filter((id) => id !== seat.id);
      } else {
        this.selectedSeats.push(seat.id);
      }
    },

    // Randomly occupy some seats in a given row array
    occupyRandomSeats(row, count) {
      const indices = [...Array(row.length).keys()];
      for (let i = 0; i < count; i++) {
        if (indices.length === 0) break;
        const randIndex = Math.floor(Math.random() * indices.length);
        const seatIndex = indices.splice(randIndex, 1)[0];
        row[seatIndex].occupied = true;
      }
    }
  },

  async mounted() {
    try {
      const response = await fetch(`/film/${this.id}`);
      if (!response.ok) throw new Error("Impossible de charger le film");

      this.movie = await response.json();
    } catch (err) {
      this.error = err.message;
    } finally {
      // Randomly occupy seats after loading
      this.occupyRandomSeats(this.seatsRow1, 2); // 2 random VIP seats
      this.occupyRandomSeats(this.seatsRow2, 2); // 2 random VIP seats
      this.bigSeatRows.forEach(row => this.occupyRandomSeats(row, 4)); // 4 random normal seats per row
      this.loading = false;
    }
  }
};

</script>
