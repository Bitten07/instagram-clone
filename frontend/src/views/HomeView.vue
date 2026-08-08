<script setup>

import { ref, onMounted } from 'vue';
import  api  from "../services/api";
import PostCard from '../components/PostCard.vue';

const page = ref(1);
const posts = ref([]);

async function loadPosts(){
  const response = await api.get('/posts');
  posts.value = response.data.data;
}

onMounted(() => {
  loadPosts();
})
</script>

<template>
  <div class="container mt-4 d-flex flex-column align-items-center">
    <PostCard v-for="post in posts" :key="post.id" :post="post" />
  </div>
</template>
