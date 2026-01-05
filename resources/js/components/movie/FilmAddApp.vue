<template>
  <div class="add-movie-page">
    <div class="details-modal">
      <h2 class="title">Ajouter un film</h2>
      <p class="subtitle">
        Remplissez les informations du film à ajouter au programme.
      </p>

      <!-- Form Fields -->
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
        <input
          v-model="film.image"
          type="text"
          placeholder="https://..."
          class="input"
        />
      </div>

      <!-- Image preview -->
      <div v-if="film.image" class="poster-preview">
        <img :src="film.image" alt="Preview" />
      </div>

      <!-- Messages -->
      <p v-if="error" class="error-msg">{{ error }}</p>
      <p v-if="success" class="success-msg">Film ajouté avec succès !</p>

      <!-- Actions -->
      <div class="modal-actions">
        <button class="btn btn-add" @click="submitFilm">Ajouter</button>
        <button class="btn btn-cancel" @click="goBack">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      film: {
        titre: "",
        auteur: "",
        image: "",
      },
      error: null,
      success: false,
    };
  },
  methods: {
    async submitFilm() {
      this.error = null;
      this.success = false;

      if (!this.film.titre || !this.film.auteur || !this.film.image) {
        this.error = "Veuillez remplir tous les champs.";
        return;
      }

      try {
        await axios.post("/film/add", this.film);
        this.success = true;

        setTimeout(() => {
          this.$router.push("/");
        }, 1200);
      } catch (err) {
        console.error(err);
        this.error = "Erreur lors de l'ajout du film.";
      }
    },
    goBack() {
      this.$router.back();
    },
  },
};
</script>
