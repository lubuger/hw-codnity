<!--suppress VueUnrecognizedSlot -->
<script setup lang="ts">
import { ref } from 'vue';
import Layout from '@/layouts/app/Layout.vue';
import axios from 'axios';
import moment from 'moment';
import { mdiMagnify } from '@mdi/js';

const itemsPerPage = ref(10);
const loading = ref(true);
const search = ref('');
const serverItems = ref([{}]);
const totalItems = ref(0);
const headers = [
    {
        title: 'Title',
        key: 'title',
    },
    {
        title: 'Points',
        key: 'points',
    },
    {
        title: 'Link',
        sortable: false,
        key: 'link',
    },
    {
        title: 'Created at',
        key: 'created_at',
    },
    {
        title: 'Updated at',
        key: 'updated_at',
    },
]

type rows = {
    data: {
        data: Array<row>,
        total: number,
        per_page: number,
    }
}

type row = {
    id: number,
    link: string,
    points: number,
    title: string,
    created_at: string,
    updated_at: string,
}

interface loadItemsParams {
    page: number,
    itemsPerPage: number,
    sortBy: string,
}

const loadItems = async (props: loadItemsParams) => {
    loading.value = true;

    const response = await axios.get(route('news.show', {
        page: props.page,
        per_page: props.itemsPerPage,
        sort: props.sortBy,
        search: search.value ? search.value : null,
    })) as rows;

    totalItems.value = response.data.total;
    serverItems.value = response.data.data;
    loading.value = false;
};
</script>

<template>
    <Layout>
        <v-text-field
            v-model="search"
            label="Search"
            :prepend-inner-icon="mdiMagnify"
            variant="outlined"
            hide-details
            single-line
        />

        <v-data-table-server
            v-model:items-per-page="itemsPerPage"
            :headers="headers"
            :items="serverItems"
            :items-length="totalItems"
            :loading="loading"
            :search="search"
            @update:options="loadItems"
        >
            <template v-slot:[`item.link`]="{ item }">
                <a class="text-amber" :href="(item as any).link">
                    {{ (item as any).link && (item as any).link.substring(0, 35) + '...' }}
                </a>
            </template>

            <template v-slot:[`item.created_at`]="{ item }">
                {{ moment((item as any).created_at).format('YYYY-MM-DD HH:mm') }}
            </template>

            <template v-slot:[`item.updated_at`]="{ item }">
                {{ moment((item as any).updated_at).format('YYYY-MM-DD HH:mm') }}
            </template>
        </v-data-table-server>
    </Layout>
</template>

<style scoped lang="scss">

</style>
