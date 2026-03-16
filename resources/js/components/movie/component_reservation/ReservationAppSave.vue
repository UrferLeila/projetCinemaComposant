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

    <!-- <div class="seats-wrapper">
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
    </div> -->

    <SiegeGrid
      @toggle-seat="toggleSeat"
      :seatRows="seatRows"
      :selectedSeats="selectedSeats"
    />

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

<script setup>
import { ref, onMounted } from "vue";
import Details from "@/components/movie/component_reservation/Details.vue";
import SeanceSelector from "@/components/movie/component_reservation/SeanceSelector.vue";
import ResumeMovie from "@/components/movie/component_reservation/ResumeMovie.vue";
import SiegeGrid from "@/components/movie/component_reservation/SiegeGrid.vue";

const props = defineProps(["id"]);

const isAuth = ref(false);
const loading = ref(true);
const error = ref(null);
const seats = ref([]);
const seatRows = ref([]);
const selectedSeats = ref([]);
const showDetails = ref(false);
const movie = ref(null);
const seances = ref([]);
const selectedSeance = ref(null);

const organizeSeats = () => 
{
  const vipSeats = seats.value.filter((s) => s.prix?.type === "vip");
  const normalSeats = seats.value.filter((s) => s.prix?.type !== "vip");
  seatRows.value = [];

  for (let i = 0; i < vipSeats.length; i += 7) {
    seatRows.value.push(vipSeats.slice(i, i + 7));
  }
  for (let i = 0; i < normalSeats.length; i += 13) {
    seatRows.value.push(normalSeats.slice(i, i + 13));
  }
};

const loadOccupiedSeats = async (seanceId) => 
{
  try {
    const res = await fetch(`/seance/${seanceId}/occupied`);
    const occupied = await res.json();
    
    // Update the ref array
    seats.value.forEach((seat) => (seat.occupied = false));
    seats.value.forEach((seat) => {
      if (occupied.includes(seat.nom)) seat.occupied = true;
    });
    organizeSeats();
  } catch (err) {
    console.error("Failed to load occupied seats:", err);
  }
};

const refreshSeats = () => 
{
  if (selectedSeance.value) {
    loadOccupiedSeats(selectedSeance.value.id);
    selectedSeats.value = [];
  }
};

const loadIsAuth = async () => 
{
  try {
    const response = await fetch("/api/isAuth");
    if (!response.ok) throw new Error("Impossible d'obtenir le statut de connexion");
    const data = await response.json();
    isAuth.value = data;
  } catch (err) {
    error.value = err.message;
  }
};

const selectSeance = (seance) => 
{
  selectedSeance.value = seance;
  selectedSeats.value = [];
  loadOccupiedSeats(seance.id);
};

const toggleSeat = (seat) => 
{
  if (!selectedSeance.value) {
    alert("Veuillez sélectionner une séance avant de choisir un siège.");
    return;
  }
  if (seat.occupied) return;

  const index = selectedSeats.value.findIndex((s) => s.nom === seat.nom);
  if (index !== -1) {
    selectedSeats.value.splice(index, 1);
  } else {
    selectedSeats.value.push(seat);
  }
};

const openConnection = () => 
{
  if (!selectedSeance.value || selectedSeats.value.length === 0) {
    alert("Veuillez sélectionner au moins une séance et un siège.");
    return;
  }

  if (isAuth.value) {
    showDetails.value = true;
  } else {
    window.location.href = "/login";
  }
};

const closeAll = () => 
{
  showDetails.value = false;
};

onMounted(async () => 
{
  loading.value = true;
  try {
    const seatsRes = await fetch("/siege");
    if (!seatsRes.ok) throw new Error("Impossible de charger les sièges");
    seats.value = await seatsRes.json();
    organizeSeats();

    const filmRes = await fetch(`/film/${props.id}`);
    if (!filmRes.ok) throw new Error("Impossible de charger le film");
    const filmData = await filmRes.json();
    
    movie.value = filmData;
    seances.value = filmData.seances || [];

    await loadIsAuth();
  } catch (err) {
    error.value = err.message;
  } finally {
    loading.value = false;
  }
});
</script>

