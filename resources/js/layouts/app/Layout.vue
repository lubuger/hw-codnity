<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    mdiAccount,
    mdiAccountAlert,
    mdiAccountCog,
    mdiAccountPlus,
    mdiLogin,
    mdiLogout, mdiNewspaper,
    mdiViewDashboard
} from '@mdi/js';
import Footer from '@/components/Footer.vue';

const page = usePage();
const drawer = ref(page.props.sidebarOpen);
const handleLogout = () => {
    router.flushAll();
};
</script>

<template>
    <v-app class="rounded rounded-md border">
        <v-app-bar :elevation="2">
            <template v-slot:prepend>
                <v-app-bar-nav-icon
                    v-if="page.props.auth.user"
                    @click="drawer = !drawer"
                />
            </template>

            <v-app-bar-title>Home work codnity</v-app-bar-title>

            <template v-slot:append>
                <v-menu>
                    <template v-slot:activator="{ props }">
                        <v-btn
                            v-bind="props"
                            rounded
                        >
                            <v-icon :icon="!page.props.auth.user ? mdiAccountAlert : mdiAccount" class="me-2" />

                            <div v-if="!page.props.auth.user">
                                Account
                            </div>
                            <div v-else>
                                Hello, {{ page.props.auth.user.name }}
                            </div>
                        </v-btn>
                    </template>

                    <v-list>
                        <template v-if="!page.props.auth.user">
                            <Link :href="route('login')">
                                <v-list-item link>
                                    <v-list-item-title>
                                        <v-icon :icon="mdiLogin" class="me-2" />
                                        Log in
                                    </v-list-item-title>
                                </v-list-item>
                            </Link>

<!--                            <Link :href="route('register')">-->
<!--                                <v-list-item link>-->
<!--                                    <v-list-item-title>-->
<!--                                        <v-icon :icon="mdiAccountPlus" class="me-2" />-->
<!--                                        Register-->
<!--                                    </v-list-item-title>-->
<!--                                </v-list-item>-->
<!--                            </Link>-->
                        </template>
                        <template v-else>
<!--                            <Link :href="route('profile.edit')">-->
<!--                                <v-list-item link>-->
<!--                                    <v-list-item-title>-->
<!--                                        <v-icon :icon="mdiAccountCog" class="me-2" />-->
<!--                                        Profile-->
<!--                                    </v-list-item-title>-->
<!--                                </v-list-item>-->
<!--                            </Link>-->

                            <Link :href="route('logout')" method="post" @click="handleLogout" class="w-100 text-left">
                                <v-list-item link :href="route('logout')">
                                    <v-list-item-title>
                                        <v-icon :icon="mdiLogout" class="me-2" />
                                        Log out
                                    </v-list-item-title>
                                </v-list-item>
                            </Link>
                        </template>
                    </v-list>
                </v-menu>
            </template>
        </v-app-bar>

        <v-navigation-drawer v-if="page.props.auth.user" v-model="drawer">
            <Link :href="route('dashboard')">
                <v-list-item link :prepend-icon="mdiViewDashboard">
                    <v-list-item-title>
                        Dashboard
                    </v-list-item-title>
                </v-list-item>
            </Link>
            <v-divider></v-divider>

            <Link :href="route('news')">
                <v-list-item link :prepend-icon="mdiNewspaper">
                    <v-list-item-title>
                        News
                    </v-list-item-title>
                    <v-list-item-subtitle>hacker</v-list-item-subtitle>
                </v-list-item>
            </Link>
        </v-navigation-drawer>

        <v-main class="d-flex align-center justify-center">
            <v-container fluid>
                <slot />
            </v-container>
        </v-main>

        <Footer />
    </v-app>
</template>
