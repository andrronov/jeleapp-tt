<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { API_URL, TOKEN_KEY } from "../config";

const router = useRouter();

const profileData = ref(null);
const loading = ref(false);
const error = ref(null);
const token = localStorage.getItem(TOKEN_KEY);

const getProfile = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await fetch(`${API_URL}/profile`, {
      method: "GET",
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      profileData.value = data.user;
    } else {
      error.value = data.error;
    }
  } catch (err) {
    error.value = "Ошибка сети";
    console.error(err);
  } finally {
    loading.value = false;
  }
};

onMounted(async () => {
  if (!token) {
    router.push("/");
    return;
  }

  await getProfile();
});
</script>

<template>
  <section>
    <h1>Данные профиля</h1>
    <div v-if="loading">Загрузка...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else>
      <pre class="bg-gray-200 p-4 rounded">
        {{ profileData }}
      </pre>
    </div>
  </section>
</template>
