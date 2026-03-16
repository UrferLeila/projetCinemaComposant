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

      <EditAndAddSeance/>

      <p v-if="error" class="error-msg">{{ error }}</p>
      <p v-if="success" class="success-msg">Film et séances ajoutés avec succès !</p>

      <div class="modal-actions">
        <button class="btn btn-add" @click="submitFilm">
          Créer le film et ses séances
        </button>
        <button class="btn btn-add" @click="goBack">Annuler</button>
      </div>
  </div>
</template>

<script setup>
import { ref } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

import EditAndAddSeance from "@/components/movie/component_editAndAdd/EditAndAddSeance.vue"

const router = useRouter()

const film = ref({
  titre: "",
  auteur: "",
  image: "",
})

const seances = ref([])
const error = ref(null)
const success = ref(false)

async function submitFilm() {
  error.value = null
  success.value = false

  if (!film.value.titre || !film.value.auteur || !film.value.image) {
    error.value = "Veuillez remplir tous les champs du film."
    return
  }

  if (seances.value.length === 0) {
    error.value = "Vous devez ajouter au moins une séance."
    return
  }

  for (let s of seances.value) {
    if (!s.date || !s.heure || !s.salle_id) {
      error.value = "Veuillez remplir toutes les informations des séances."
      return
    }
  }

  try {
    const res = await axios.post("/film/add", film.value)
    const filmId = res.data.id

    for (let s of seances.value) {
      await axios.post("/seance/add", { ...s, film_id: filmId })
    }

    success.value = true

    setTimeout(() => {
      router.push("/")
    }, 1200)
  } catch (err) {
    console.error(err)
    error.value = "Erreur lors de l'ajout du film ou des séances."
  }
}

function goBack() {
  router.back()
}
</script>