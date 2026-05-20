<script setup lang="ts">
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { API_URL, TOKEN_KEY } from "../config";

const router = useRouter();

const form = reactive({
  email: "",
  password: "",
  gender: "",
});
const showPassword = ref(false);
const error = ref("");
const loading = ref(false);

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const submitForm = async () => {
  error.value = "";
  loading.value = true;

  try {
    const response = await fetch(`${API_URL}/registration`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify(form),
    });

    const data = await response.json();
    console.log("Ответ API:", data);

    if (response.ok) {
      localStorage.setItem(TOKEN_KEY, data.token);
      router.push({ name: "profile" });
    } else {
      error.value = data.message || "Ошибка регистрации";
    }
  } catch (err) {
    error.value = "Ошибка соединения с сервером";
    console.error(err);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <section>
    <h1 class="text-2xl font-medium mb-4">Регистрация</h1>
    <form
      @submit.prevent="submitForm"
      class="w-full flex flex-col gap-4 bg-blue-100 p-4 border border-black/25 rounded-xl shadow"
    >
      <div class="form-item">
        <label>Email:</label>
        <input type="email" v-model="form.email" required />
      </div>

      <div class="form-item">
        <label>Пароль:</label>
        <div class="flex items-center gap-2">
          <input
            :type="showPassword ? 'text' : 'password'"
            v-model="form.password"
            required
            minlength="8"
            class="min-w-64"
          />
          <button
            type="button"
            class="min-w-24"
            @click="togglePasswordVisibility"
          >
            {{ showPassword ? "Скрыть" : "Показать" }}
          </button>
        </div>
      </div>

      <div class="form-item">
        <label>Пол:</label>
        <select v-model="form.gender" required class="w-full p-2">
          <option value="" disabled>Выберите пол</option>
          <option value="male">Мужской</option>
          <option value="female">Женский</option>
        </select>
      </div>
      <button type="submit" :disabled="loading" class="p-2 cursor-pointer">
        Зарегистрироваться
      </button>
    </form>
    <p v-if="error" class="text-red-500">{{ error }}</p>
  </section>
</template>
