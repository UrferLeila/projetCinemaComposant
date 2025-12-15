<template>
  <div class="modal-overlay">
    <div class="modal">
      <h2 class="h2-title">Se connecter</h2>
      <input type="email" placeholder="Email" v-model="localLogin.email" class="input" />
      <input
        type="password"
        placeholder="Mot de passe"
        v-model="localLogin.password"
        class="input"
      />

      <h3 class="h3-center">Vous n'avez pas encore de compte ?</h3>
      <h3 class="link" @click="openRegister">Inscrivez-vous ici</h3>

      <p v-if="connected" class="success-msg">Vous êtes connecté !</p>
      <p v-if="errorMsg" class="error-msg">{{ errorMsg }}</p>

      <div class="modal-actions">
        <button class="btn-red" @click="loginUser">Connexion</button>
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
      localLogin: {
        email: "",
        password: "",
      },
      connected: false,
      errorMsg: "",
    };
  },
  methods: {
    openRegister() {
      this.$emit("open-register");
    },
    async loginUser() {
      try {
        const response = await axios.post("/api/login", this.localLogin);
        if (response.data.success) {
          this.connected = true;
          this.errorMsg = "";
          this.$emit("login-success", response.data.user);
        } else {
          this.connected = false;
          this.errorMsg = response.data.message;
        }
      } catch (error) {
        this.connected = false;
        this.errorMsg = "Une erreur est survenue, veuillez réessayer.";
      }
    },
  },
};
</script>
