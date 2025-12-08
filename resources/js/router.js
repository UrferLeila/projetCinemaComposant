import { createRouter, createWebHistory } from 'vue-router';
import MovieApp from './components/movie/MovieApp.vue';
import ReservationApp from './components/movie/ReservationApp.vue';

const routes = [
    { path: '/', component: MovieApp },
    { path: '/reservation', component: ReservationApp },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
