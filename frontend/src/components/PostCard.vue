<script setup>
const props = defineProps(["post"]);
import  api  from "../services/api";
import { ref } from 'vue';
import HeartIcon from "./HeartIcon.vue";

const error = ref('');

async function toggleLike() {
    if(!props.post.liked_by_me){
        try {
            const response = await api.post(`like/${props.post.id}`)
            props.post.liked_by_me = true;
            props.post.liked_by_count += 1;
            
            return response;
        } catch (err) {
            error.value = 'error';
        }
    } else {
        try {
            const response = await api.delete(`like/${props.post.id}`)
            props.post.liked_by_me = false;
            props.post.liked_by_count -= 1;

            return response;
        } catch (err) {
            error.value = 'error';
        }
    }
}
</script>

<template>
    <section class="card mb-4" style="max-width: 470px; margin: 0 auto;">
        <div class="card-header d-flex flex-column align-items-start small">
            <div>{{ post.user.username }}</div>
            <div>{{ post.user.name }}</div>
        </div>
        <img :src="post.image_path" class="card-img-top w-100 ratio ratio-1x1 object-fit-cover"/> 
    <div class="card-body d-flex gap-3">
        <p class="card-text">{{ post.caption }}</p>
        <div class= "d-flex align-items-center gap-1" :class="post.liked_by_me ? 'text-danger' : 'text-secondary'" @click="toggleLike">
            <HeartIcon :filled="post.liked_by_me" />
            {{ post.liked_by_count }}
        </div>
        <small class="text-muted d-flex align-items-center gap-1">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
            </svg>
{{ post.comments_count }}</small>
    </div>
    </section>
</template>
