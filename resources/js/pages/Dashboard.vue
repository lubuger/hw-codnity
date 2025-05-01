<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import Layout from '@/layouts/app/Layout.vue';
import { onBeforeMount } from 'vue';
import { userStore } from '@/stores/user';
import type { SharedData, User } from '@/types';

const props = defineProps<{
    token: string|null;
}>();
const page = usePage<SharedData>();
const user = page.props.auth.user as User;
const piniaUserStore = userStore();

onBeforeMount(() => {
    piniaUserStore.setUser(user);

    if (props.token && props.token !== '') {
        piniaUserStore.setToken(props.token);
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div>
            <p>
                user:
            </p>
            <pre>
                <span class="text-amber">{{ piniaUserStore.user }}</span>
            </pre>
        </div>
        <div>
            <p>
                token:<span class="text-amber ms-3">{{ piniaUserStore.token }}</span>
            </p>
        </div>
    </Layout>
</template>
