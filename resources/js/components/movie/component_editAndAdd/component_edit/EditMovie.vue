<template>
  <div class="details-modal">
    <h2 class="title">Modifier le film</h2>
    <p class="subtitle">Modifiez les informations du film et les séances.</p>

    <div class="form-group">
      <input v-model="film.titre" type="text" placeholder="Titre du film" class="input" />
    </div>

    <div class="form-group">
      <input
        v-model="film.auteur"
        type="text"
        placeholder="Auteur / Réalisateur"
        class="input"
      />
    </div>

    <div class="form-group">
      <input v-model="film.image" type="text" placeholder="https://..." class="input" />
    </div>

    <div v-if="film.image" class="poster-preview">
      <img :src="film.image" alt="Preview" />
    </div>

    <EditSeance v-model:seances="seances" />

    <p v-if="error" class="error-msg">{{ error }}</p>
    <p v-if="success" class="success-msg">Film et séances mis à jour avec succès !</p>

    <div class="modal-actions">
      <button class="btn btn-add" @click="submitFilm">
        Mettre à jour le film et ses séances
      </button>
      <button class="btn btn-add" @click="goBack">Annuler</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import EditSeance from "@/components/movie/component_editAndAdd/EditAndAddSeance.vue";

export default {
  name: "EditMovie",
  components: {
    EditSeance,
  },
  props: {
    id: {
      type: [String, Number],
      required: true,
    },
  },
  data() {
    return {
      film: {
        titre: "",
        auteur: "",
        image: "",
      },
      seances: [],
      error: null,
      success: false,
    };
  },
  async created() {
    try {
      const res = await axios.get(`/film/${this.id}`);
      this.film = {
        titre: res.data.titre,
        auteur: res.data.auteur,
        image: res.data.image,
      };
      this.seances = res.data.seances || [];
    } catch (err) {
      console.error(err);
      this.error = "Impossible de charger les informations du film.";
    }
  },
  methods: {
    async submitFilm() {
      this.error = null;
      this.success = false;

      if (!this.film.titre || !this.film.auteur || !this.film.image) {
        this.error = "Veuillez remplir tous les champs du film.";
        return;
      }

      for (let s of this.seances) {
        if (!s.date || !s.heure || !s.salle_id) {
          this.error = "Veuillez remplir toutes les informations des séances.";
          return;
        }
      }

      try {
        await axios.put(`/film/update/${this.id}`, this.film);

        const serverSeanceIds = this.seances.filter((s) => s.id).map((s) => s.id);

        const { data: existingSeances } = await axios.get(`/film/${this.id}`);
        const existingIds = existingSeances.seances?.map((s) => s.id) || [];

        for (let id of existingIds) {
          if (!serverSeanceIds.includes(id)) {
            await axios.delete(`/seance/${id}`);
          }
        }

        for (let s of this.seances) {
          if (s.id) {
            await axios.put(`/seance/${s.id}`, s);
          } else {
            await axios.post("/seance/add", { ...s, film_id: this.id });
          }
        }

        this.success = true;
        setTimeout(() => {
          this.$router.push("/");
        }, 1200);
      } catch (err) {
        console.error(err);
        this.error = "Erreur lors de la mise à jour du film ou des séances.";
      }
    },
    goBack() {
      this.$router.back();
    },
  },
};
</script>
