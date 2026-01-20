<template>
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
        row[0]?.prix?.type === 'vip'
          ? 'seats-container-vip'
          : 'seats-container-normal',
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
          selected: selectedSeats.some(s => s.nom === seat.nom),
        }"
        @click="$emit('toggle-seat', seat)"
      ></div>
    </div>

    <h1 class="h1">Écran</h1>
  </div>
</template>


<script>
export default {
  name: "SiegeGrid",

  props: {
    seatRows: {
      type: Array,
      required: true,
    },
    selectedSeats: {
      type: Array,
      required: true,
    },
  },
};
</script>
