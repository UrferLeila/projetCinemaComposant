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
      <p v-if="errorMsg" class="error-msg">{{ errorMsg }}</p>
      <div class="modal-actions">
        <button class="btn-red" @click="loginUser">Connexion</button>
        <button class="btn-red" @click="$emit('close')">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      localLogin: {
        email: "",
        password: "",
      },
      errorMsg: "",
    };
  },
  methods: {
    openRegister() {
      this.$emit("open-register");
    },
  },
};
</script>
