<template>
  <div v-if="loading">
    <p class="title-small">Chargement du film…</p>
  </div>

  <div v-else-if="error">
    <p>Erreur : {{ error }}</p>
  </div>

  <div class="header-container" v-else>
    <ResumeMovie
      :movie="(movie as Film)"
      :selectedSeance="(selectedSeance as Seance)"
      @reserve="openConnection"
    />

    <SeanceSelector
      :seances="seances"
      :selectedSeance="(selectedSeance as Seance)"
      @select-seance="selectSeance"
    />

    <SiegeGrid
      @toggle-seat="toggleSeat"
      :seatRows="seatRows"
      :selectedSeats="selectedSeats"
    />
  </div>

  <Details
    v-if="showDetails"
    :selectedMovie="(movie as Film)"
    :selectedSeance="(selectedSeance as Seance)"
    :selectedSeats="selectedSeats"
    @close="closeAll"
    @reservation-made="refreshSeats"
  />
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import Details from  "./Details.vue";
import SeanceSelector from "./SeanceSelector.vue";
import ResumeMovie from "./ResumeMovie.vue";
import SiegeGrid from "./SiegeGrid.vue";

import type { Siege } from '../../../types/Siege.ts'
import type { Film } from '../../../types/Film.ts'
import type { Seance } from '../../../types/Seance.ts'


const props = defineProps<{
  id: string | number;
}>();

const isAuth = ref(false);
const loading = ref(true);
const error = ref<string | null>(null);
const showDetails = ref(false);

const seats = ref<Siege[]>([]);
const seatRows = ref<Siege[][]>([]);
const selectedSeats = ref<Siege[]>([]);
const movie = ref<Film | null>(null);
const seances = ref<Seance[]>([]);
const selectedSeance = ref<Seance | null>(null);

const organizeSeats = () => 
{
  const vipSeats = seats.value.filter((s: Siege) => s.prix?.type === "vip");
  const normalSeats = seats.value.filter((s: Siege) => s.prix?.type !== "vip");
  seatRows.value = [];

  for (let i = 0; i < vipSeats.length; i += 7) {
    seatRows.value.push(vipSeats.slice(i, i + 7));
  }
  for (let i = 0; i < normalSeats.length; i += 13) {
    seatRows.value.push(normalSeats.slice(i, i + 13));
  }
};

const loadOccupiedSeats = async (seanceId: number | String) => 
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
      error.value = err instanceof Error ? err.message : String(err);
    } finally {
      loading.value = false; 
    }
};

const selectSeance = (seance : Seance) => 
{
  selectedSeance.value = seance;
  selectedSeats.value = [];
  loadOccupiedSeats(seance.id);
};

const toggleSeat = (seat: Siege) => 
{
  if (!selectedSeance.value) {
    alert("Veuillez sélectionner une séance avant de choisir un siège.");
    return;
  }
  if (seat.occupied) return;

  const index = selectedSeats.value.findIndex((s: Siege) => s.nom === seat.nom);
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
  } 
  catch (err) {
    error.value = err instanceof Error ? err.message : String(err);
  } finally {
    loading.value = false; 
  }
});
</script>

