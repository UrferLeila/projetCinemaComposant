import { createRouter, createWebHistory } from 'vue-router';
import MovieApp from './components/movie/MovieApp.vue';
import ReservationApp from './components/movie/component_reservation/ReservationAppSave.vue';
import FilmEditApp from './components/movie/component_editAndAdd/component_edit/FilmEditApp.vue';
import FilmAddApp from './components/movie/component_editAndAdd/component_add/FilmAddApp.vue';
import resevationList from './components/movie/component_resume/resevationList.vue';
import dashboard from './components/movie/component_dashboard/dashboard.vue';

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
    {
        path: '/admin/stats/',
        name: 'dashboard',
        component: dashboard,
    },
];

const router = createRouter({
    history: createWebHistory('/vue'),
    routes,
});

export default router;
