<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { mdiChevronRight, mdiEmailOutline, mdiEye, mdiEyeOff, mdiLockOutline } from '@mdi/js';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
    deviceName: 'browser',
});
const visible = ref(false);

const submit = () => {
    form.post(route('login'), {

        onFinish: () => {
            form.reset('password')
        },
    });
};

onMounted(async () => {
    await axios.get('/sanctum/csrf-cookie');
});
</script>

<template>
    <Head title="Log in" />

    <v-app class="rounded rounded-md border">
        <v-main class="d-flex align-center justify-center">
            <v-container fluid>
                <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <v-form @submit.prevent="submit" class="flex flex-col gap-6">
                    <v-img
                        class="mx-auto my-6"
                        max-width="228"
                        src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
                    />

                    <v-card
                        class="mx-auto pa-12 pb-8"
                        elevation="8"
                        max-width="448"
                        rounded="lg"
                    >
                        <div class="text-subtitle-1 text-medium-emphasis">Account</div>

                        <v-text-field
                            density="compact"
                            placeholder="Email address"
                            variant="outlined"
                            v-model="form.email"
                            :prepend-inner-icon="mdiEmailOutline"
                            :error="!!form.errors.email"
                            :error-messages="form.errors.email"
                        />

                        <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                            Password

                            <a
                                class="text-caption text-decoration-none text-blue"
                                href="#"
                                rel="noopener noreferrer"
                                target="_blank"
                            >
                                Forgot login password?</a>
                        </div>

                        <v-text-field
                            density="compact"
                            placeholder="Enter your password"
                            variant="outlined"
                            v-model="form.password"
                            @click:append-inner="visible = !visible"
                            :append-inner-icon="visible ? mdiEyeOff : mdiEye"
                            :type="visible ? 'text' : 'password'"
                            :prepend-inner-icon="mdiLockOutline"
                        />

                        <v-card
                            class="mb-12"
                            color="surface-variant"
                            variant="tonal"
                        >
                            <v-card-text class="text-medium-emphasis text-caption">
                                Warning: After 3 consecutive failed login attempts, you account will be temporarily locked for three hours. If you must login now, you can also click "Forgot login password?" below to reset the login password.
                            </v-card-text>
                        </v-card>

                        <v-btn
                            class="mb-8"
                            color="blue"
                            size="large"
                            variant="tonal"
                            type="submit"
                            block
                        >
                            Log In
                        </v-btn>

                        <v-card-text class="text-center">
                            <a
                                class="text-blue text-decoration-none"
                                :href="route('register')"
                                rel="noopener noreferrer"
                                target="_blank"
                            >
                                Sign up now <v-icon :icon="mdiChevronRight"></v-icon>
                            </a>
                        </v-card-text>
                    </v-card>
                </v-form>
            </v-container>
        </v-main>
    </v-app>

<!--    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">-->
<!--        <Head title="Log in" />-->

<!--        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">-->
<!--            {{ status }}-->
<!--        </div>-->

<!--        <form @submit.prevent="submit" class="flex flex-col gap-6">-->
<!--            <div class="grid gap-6">-->
<!--                <div class="grid gap-2">-->
<!--                    <Label for="email">Email address</Label>-->
<!--                    <Input-->
<!--                        id="email"-->
<!--                        type="email"-->
<!--                        required-->
<!--                        autofocus-->
<!--                        :tabindex="1"-->
<!--                        autocomplete="email"-->
<!--                        v-model="form.email"-->
<!--                        placeholder="email@example.com"-->
<!--                    />-->
<!--                    <InputError :message="form.errors.email" />-->
<!--                </div>-->

<!--                <div class="grid gap-2">-->
<!--                    <div class="flex items-center justify-between">-->
<!--                        <Label for="password">Password</Label>-->
<!--                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm" :tabindex="5">-->
<!--                            Forgot password?-->
<!--                        </TextLink>-->
<!--                    </div>-->
<!--                    <Input-->
<!--                        id="password"-->
<!--                        type="password"-->
<!--                        required-->
<!--                        :tabindex="2"-->
<!--                        autocomplete="current-password"-->
<!--                        v-model="form.password"-->
<!--                        placeholder="Password"-->
<!--                    />-->
<!--                    <InputError :message="form.errors.password" />-->
<!--                </div>-->

<!--                <div class="flex items-center justify-between">-->
<!--                    <Label for="remember" class="flex items-center space-x-3">-->
<!--                        <Checkbox id="remember" v-model="form.remember" :tabindex="3" />-->
<!--                        <span>Remember me</span>-->
<!--                    </Label>-->
<!--                </div>-->

<!--                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">-->
<!--                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />-->
<!--                    Log in-->
<!--                </Button>-->
<!--            </div>-->

<!--            <div class="text-center text-sm text-muted-foreground">-->
<!--                Don't have an account?-->
<!--                <TextLink :href="route('register')" :tabindex="5">Sign up</TextLink>-->
<!--            </div>-->
<!--        </form>-->
<!--    </AuthBase>-->
</template>
