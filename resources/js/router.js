import { createRouter, createWebHistory } from 'vue-router';
import MovieApp from './components/movie/MovieApp.vue';
import ReservationApp from './components/movie/ReservationAppSave.vue';

const routes = [
    {
        path: '/',
        name: MovieApp,
        component: () => import('@/components/movie/MovieApp.vue')
    },
    {
        path: '/reservation/:id',
        name: 'reservation',
        component: ReservationApp,
        props: true,
    },
];

const router = createRouter({
    history: createWebHistory('/vue'),
    routes,
});

export default router;
