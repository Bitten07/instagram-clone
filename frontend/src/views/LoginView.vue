<script setup>

  import { ref } from "vue";
  import { useRouter } from "vue-router";
  import  api  from "../services/api";

  const email = ref('');
  const password = ref('');
  const router = useRouter();
  const error = ref(null);
  const loading = ref(false);
  const hidePassword = ref(true);

  async function handleSubmit() {
    error.value = null;
    loading.value = true;
    try {
      const response = await api.post('/login', {
        email: email.value,
        password: password.value,
      });
      localStorage.setItem('token', response.data.token);
      router.push('/home')
    } catch (e) {
      error.value = 'email or password wrong';
    }

    loading.value = false;
  }
</script>

<template>
  <div class="container mt-5" style="max-width: 400px">
    <h1 class="mb-4 text-center">Login</h1>

    <form @submit.prevent="handleSubmit">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" v-model="email" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Senha</label>
        <div class="position-relative">
          <input 
            :type="hidePassword ? 'password' : 'text'" 
            class="form-control pe-5" 
            v-model="password" 
            required 
          />
          <button
            type="button" 
            class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2" 
            @click="hidePassword = !hidePassword"
          >   
            {{ hidePassword ? '👁' : '🙈' }}
          </button>
        </div>
      </div>

      <div v-if="error" class="alert alert-danger py-2">{{ error }}</div>

      <button type="submit" class="btn btn-primary w-100" :disabled="loading">
        {{ loading ? 'Entrando...' : 'Entrar' }}
      </button>
    </form>

    <p class="text-center mt-3">
      Não tem conta? <RouterLink to="/register">Cadastre-se</RouterLink>
    </p>
  </div>
</template>
