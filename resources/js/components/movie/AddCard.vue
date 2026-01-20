<template>
    <div class="details-modal">
      <h2 class="title">Ajouter un film</h2>
      <p class="subtitle">Remplissez les informations du film et les séances.</p>

      <div class="form-group">
        <input
          v-model="film.titre"
          type="text"
          placeholder="Titre du film"
          class="input"
        />
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

      <EditSeance/>

      <p v-if="error" class="error-msg">{{ error }}</p>
      <p v-if="success" class="success-msg">Film et séances ajoutés avec succès !</p>

      <div class="modal-actions">
        <button class="btn btn-add" @click="submitFilm">
          Créer le film et ses séances
        </button>
        <button class="btn btn-cancel" @click="goBack">Annuler</button>
      </div>
  </div>
</template>

<script>
import axios from "axios";
import EditSeance from "@/components/movie/EditSeance.vue";

export default {
  components: {
    EditSeance,
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
  methods: {
    async submitFilm() {
      this.error = null;
      this.success = false;

      if (!this.film.titre || !this.film.auteur || !this.film.image) {
        this.error = "Veuillez remplir tous les champs du film.";
        return;
      }

      if (this.seances.length === 0) {
        this.error = "Vous devez ajouter au moins une séance.";
        return;
      }

      for (let s of this.seances) {
        if (!s.date || !s.heure || !s.salle_id) {
          this.error = "Veuillez remplir toutes les informations des séances.";
          return;
        }
      }

      try {
        const res = await axios.post("/film/add", this.film);
        const filmId = res.data.id; 

        for (let s of this.seances) {
          await axios.post("/seance/add", { ...s, film_id: filmId });
        }

        this.success = true;
        setTimeout(() => {
          this.$router.push("/");
        }, 1200);
      } catch (err) {
        console.error(err);
        this.error = "Erreur lors de l'ajout du film ou des séances.";
      }
    },
    goBack() {
      this.$router.back();
    },
  },
};
</script>
