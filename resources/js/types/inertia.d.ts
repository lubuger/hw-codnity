import { PageProps as InertiaPageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';

// Globally page props provided by `./app/Http/Middleware/HandleInertiaRequests.php`
interface AppPageProps {
    name: string,
    quote: {
        message: string,
        author: string,
    },
    auth: {
        user: User | null,
    },
    ziggy: Config & { location: string },
    sidebarOpen: boolean,
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

declare module '@inertiajs/core' {
    interface PageProps extends AppPageProps, InertiaPageProps {}
}
