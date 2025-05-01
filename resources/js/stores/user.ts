import { defineStore } from 'pinia'
import { ref } from 'vue';
import { User } from '@/types/inertia';

export const userStore = defineStore('user', () => {
    const user = ref({});
    const token = ref('');

    const setUser = (value: User) => {
        user.value = value;
    };
    const setToken = (value: string) => {
        token.value = value;
    }

    return {
        user,
        token,

        setUser,
        setToken,
    }
}, {
    persist: true,
});
