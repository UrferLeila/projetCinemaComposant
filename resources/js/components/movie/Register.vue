<template>
  <div class="modal-overlay">
    <div class="modal">
      <h2 class="h2-title">S'inscrire</h2>
      <input placeholder="Name" v-model="localLogin.name" class="input" />
      <input type="email" placeholder="Email" v-model="localLogin.email" class="input" />
      <input
        type="password"
        placeholder="Mot de passe"
        v-model="localLogin.password"
        class="input"
      />

      <input
        type="password"
        placeholder="Confirmer le mot de passe"
        v-model="localLogin.passwordConfirm"
        class="input"
      />

      <h3 class="h3-center">Vous avez déjà un compte ?</h3>
      <h3 class="link" @click="openLogin">Connectez-vous ici</h3>

      <div class="modal-actions">
        <button class="btn-red">Inscription</button>
        <button class="btn-red" @click="$emit('close')">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { login: { type: Object, required: true } },
  data() {
    return { localLogin: { ...this.loginRegister } };
  },
  methods: {
    openLogin() {
      this.$emit("open-login");
    },
  },
};
</script>
