import { createRouter, createWebHistory } from 'vue-router';
import MovieApp from './components/movie/MovieApp.vue';
import ReservationApp from './components/movie/ReservationAppSave.vue';
import FilmEditApp from './components/movie/FilmEditApp.vue';
import FilmAddApp from './components/movie/FilmAddApp.vue';
import resevationList from './components/movie/resevationList.vue';

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
    {
        path: '/film/edit/:id',
        name: 'film/edit',
        component: FilmEditApp,
        props: true,
    },
    {
        path: '/film/add/',
        name: 'film/add',
        component: FilmAddApp,
        props: true,
    },
    {
        path: '/resevationList/',
        name: 'resevationList',
        component: resevationList,
        props: true,
    },
];

const router = createRouter({
    history: createWebHistory('/vue'),
    routes,
});

export default router;
