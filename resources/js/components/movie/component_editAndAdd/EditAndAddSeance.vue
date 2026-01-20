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

<script>
export default {
  name: "EditAndAddSeance",
  props: {
    seances: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      localSeances: [...this.seances],
    };
  },
  watch: {
    localSeances: {
      deep: true,
      handler(value) {
        this.$emit("update:seances", value);
      },
    },
    seances: {
      deep: true,
      handler(value) {
        this.localSeances = [...value];
      },
    },
  },
  methods: {
    add() {
      this.localSeances.push({
        date: "",
        heure: "",
        salle_id: 1,
      });
    },
    remove(index) {
      this.localSeances.splice(index, 1);
    },
  },
};
</script>
