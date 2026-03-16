<template>
  <div class="seances-section">
    <h3>Modifier les séances</h3>
    <div v-if="localSeances.length === 0" class="no-seances">
    <p>Aucune séance ajoutée.</p>
</div>
    <div
      v-for="(seance, index) in localSeances"
      :key="seance.id || index"
      class="seance-item"
    >
      <input v-model="seance.date" type="date" class="input" />
      <input v-model="seance.heure" type="time" class="input" />
      <select v-model="seance.salle_id" class="input">
        <option value="1">Salle 1</option>
      </select>

      <button class="btn btn-remove" @click="remove(index)">Supprimer</button>
    </div>

    <button class="btn btn-add-seance" @click="add">Ajouter une séance</button>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
  seances: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(["update:seances"]);

const localSeances = ref([...props.seances]);

watch(
  localSeances,
  (value) => {
    emit("update:seances", value);
  },
  { deep: true }
);

watch(
  () => props.seances,
  (value) => {
    localSeances.value = [...value];
  },
  { deep: true }
);

function add() {
  localSeances.value.push({
    date: "",
    heure: "",
    salle_id: 1,
  });
}

function remove(index) {
  localSeances.value.splice(index, 1);
}
</script>
