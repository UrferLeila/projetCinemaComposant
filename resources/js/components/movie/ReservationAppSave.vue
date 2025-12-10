<template>
  <div v-if="loading">
    <p>Chargement du film…</p>
  </div>

  <div v-else-if="error">
    <p>Erreur : {{ error }}</p>
  </div>

  <div class="header-container" v-else>
    <img class="img" :src="movie.image" alt="Poster" />

    <div>
      <h1 class="h1">Choisir une place :</h1>

      <h2 class="h2-title">Film</h2>
      <h3 class="h3">{{ movie.titre }}</h3>

      <h2 class="h2-title">Date et Horaire</h2>
      <h3 class="h3" v-if="selectedSeance">
        {{ formatSeance(selectedSeance) }}
      </h3>

      <h3 class="h3" v-else>Sélectionnez une séance</h3>

      <button class="btn-red">Réserver</button>
    </div>

    <div class="selection-column">
      <h1 class="h1-center">Choisir la date :</h1>
      <div class="header-center">
        <button
          v-for="(seance, index) in seances"
          :key="index"
          class="btn"
          :class="{ selected: selectedSeance === seance }"
          @click="selectedSeance = seance"
        >
          {{ new Date(seance.date).toLocaleDateString("fr-CH") }} : {{ seance.heure }}
        </button>
      </div>
    </div>

    <div class="seats-wrapper">
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

      <div class="seats-container-small">
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
      </div>

      <div class="seats-container-small">
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-2.svg.svg" />
      </div>

      <div class="seats-container">
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
      </div>

      <div class="seats-container">
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
      </div>

      <div class="seats-container">
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
      </div>

      <div class="seats-container">
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
        <img class="svg" src="file:///C:/Users/cp-23leu/Pictures/cinema-seat-1.svg.svg" />
      </div>

      <div><h1 class="h1-center">Écran</h1></div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      isSelected: false,
      movie: null,
      loading: true,
      error: null,
      seances: [],
      selectedSeance: null,
    };
  },
  methods: {
    formatSeance(seance) {
      const date = new Date(seance.date).toLocaleDateString("fr-CH", {
        weekday: "long",
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });

      return `${date}, ${seance.heure}`;
    },
  },
  async mounted() {
    try {
      const response = await fetch(`/film/${this.id}`);
      if (!response.ok) throw new Error("Impossible de charger le film");
      const data = await response.json();
      this.movie = data;
      this.seances = data.seances || [];
    } catch (err) {
      console.error(err);
      this.error = err.message;
    } finally {
      this.loading = false;
    }
  },
};
</script>
