<script setup>
  import { ref } from "vue";
  import { useRouter } from "vue-router";
  import  api  from "../services/api";

  const name = ref('');
  const username = ref('');
  const email = ref('');
  const password = ref('');  
  const password_confirmation = ref('');  
  const hidePassword = ref(true);
  const generalError = ref(null);
  const creating = ref(false);
  const router = useRouter();
  const fieldErrors = ref({});

  async function handleSubmit() {
    generalError.value = null;
    creating.value = true;
    if (password.value === password_confirmation.value) {
      try {
        const response = await api.post('/register', {
          name: name.value,
          username: username.value,
          email: email.value,
          password: password.value,
          password_confirmation: password_confirmation.value,
        });

        localStorage.setItem('token', response.data.token);
        router.push('/home')
      } catch (e) {
        fieldErrors.value = e.response.data.errors
      }
    } else {
      generalError.value = 'The entered password does not match the confirmation.'
    }

    creating.value = false;
  }


</script>

<template>
  <div class="container mt-5" style="max-width: 400px">
    <h1 class="mb-4 text-center">Create account</h1>
      <form @submit.prevent="handleSubmit">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" v-model="name" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" v-model="username" required />
          <div v-if="fieldErrors.username" class="alert alert-danger py-2" > {{ fieldErrors.username?.[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="text" class="form-control" v-model="email" required />
          <div v-if="fieldErrors.email" class="alert alert-danger py-2" > {{ fieldErrors.email?.[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="position-relative">
            <input
              :type=" hidePassword ? 'password': 'text'"
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

        <div class="mb-3">
          <label class="form-label">Confirm password</label>
          <div class="position-relative">
            <input
              :type=" hidePassword ? 'password': 'text'"
              class="form-control pe-5"
              v-model="password_confirmation"
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

        <div v-if="generalError" class="alert alert-danger py-2">{{ generalError }}</div>

        <button type="submit" class="btn btn-primary w-100" :disabled="creating">
          {{ creating ? 'creating' : 'Create' }}
        </button>
      </form>
  </div>
</template>
