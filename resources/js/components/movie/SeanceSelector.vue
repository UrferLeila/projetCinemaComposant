<template>
  <div class="selection-column">
    <h1 class="h1-center">Choisir la séance</h1>

    <div class="header-center">
      <button
        v-for="(seance, index) in seances"
        :key="index"
        class="btn-blue"
        :class="{ selected: selectedSeance?.id === seance.id }"
        @click="$emit('select-seance', seance)"
      >
        {{ formatDate(seance.date) }}, {{ seance.heure }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "SeanceSelector",
  props: {
    seances: {
      type: Array,
      required: true,
    },
    selectedSeance: {
      type: Object,
      default: null,
    },
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString("fr-CH");
    },
  },
};
</script>
