<template>
  <div class="modal-overlay">
    <div class="modal">
      <h2 class="h2-title">S'inscrire</h2>
      <input placeholder="Name" v-model="localConnection.name" class="input" />
      <input
        type="email"
        placeholder="Email"
        v-model="localConnection.email"
        class="input"
      />
      <input
        type="password"
        placeholder="Mot de passe"
        v-model="localConnection.password"
        class="input"
      />

      <input
        type="password"
        placeholder="Confirmer le mot de passe"
        v-model="localConnection.passwordConfirm"
        class="input"
      />

      <h3 class="h3-center">Vous avez déjà un compte ?</h3>
      <h3 class="link" @click="openConnection">Connectez-vous ici</h3>

      <div class="modal-actions">
        <button class="btn-red" @click="registerUser">Inscription</button>
        <button class="btn-red" @click="$emit('close')">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      localConnection: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errorMsg: "",
    };
  },

  methods: {
    openConnection() {
      this.$emit("open-connection");
    },
  },
};
</script>
