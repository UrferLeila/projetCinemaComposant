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

<script setup>
import { ref, onMounted } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

import EditSeance from "@/components/movie/component_editAndAdd/EditAndAddSeance.vue"

const router = useRouter()

const props = defineProps({
  id: {
    type: [String, Number],
    required: true,
  }
})

const film = ref({
  titre: "",
  auteur: "",
  image: "",
})

const seances = ref([])
const error = ref(null)
const success = ref(false)

async function fetchFilm() {
  try {
    const res = await axios.get(`/film/${props.id}`)

    film.value = {
      titre: res.data.titre,
      auteur: res.data.auteur,
      image: res.data.image,
    }

    seances.value = res.data.seances || []
  } catch (err) {
    console.error(err)
    error.value = "Impossible de charger les informations du film."
  }
}

async function submitFilm() {
  error.value = null
  success.value = false

  if (!film.value.titre || !film.value.auteur || !film.value.image) {
    error.value = "Veuillez remplir tous les champs du film."
    return
  }

  for (let s of seances.value) {
    if (!s.date || !s.heure || !s.salle_id) {
      error.value = "Veuillez remplir toutes les informations des séances."
      return
    }
  }

  try {
    await axios.put(`/film/update/${props.id}`, film.value)

    const serverSeanceIds = seances.value.filter((s) => s.id).map((s) => s.id)

    const { data: existingSeances } = await axios.get(`/film/${props.id}`)
    const existingIds = existingSeances.seances?.map((s) => s.id) || []

    for (let id of existingIds) {
      if (!serverSeanceIds.includes(id)) {
        await axios.delete(`/seance/${id}`)
      }
    }

    for (let s of seances.value) {
      if (s.id) {
        await axios.put(`/seance/${s.id}`, s)
      } else {
        await axios.post("/seance/add", { ...s, film_id: props.id })
      }
    }

    success.value = true

    setTimeout(() => {
      router.push("/")
    }, 1200)
  } catch (err) {
    console.error(err)
    error.value = "Erreur lors de la mise à jour du film ou des séances."
  }
}

function goBack() {
  router.back()
}

onMounted(() => {
  fetchFilm()
})
</script>