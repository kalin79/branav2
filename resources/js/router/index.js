import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '@/js/stores/user';
const routes = [
    {
        path: '/',
        component: () => import('@/js/pages/Home.vue'),
        meta: { layout: 'front' }
    },
    {
        path: '/contacto',
        component: () => import('@/js/pages/Contacto.vue'),
        meta: { layout: 'front' }
    },
    {
        path: '/productos',
        component: () => import('@/js/pages/Productos.vue'),
        meta: { layout: 'front' }
    },
    {
        path: '/producto/:slug',
        name: 'ProductoDetalle',
        component: () => import('@/js/pages/ProductoDetalle.vue'),
        meta: { layout: 'front' },
        props: true
    },
    // Auth
    {
        path: '/auth/login',
        component: () => import('@/js/pages/auth/Login.vue'),
        meta: { layout: 'auth' }
    },
    {
        path: '/auth/registro',
        component: () => import('@/js/pages/auth/Register.vue'),
        meta: { layout: 'auth' }
    },
    {
        path: '/auth/recuperar-contrasena',
        component: () => import('@/js/pages/auth/ForgotPassword.vue'),
        meta: { layout: 'auth' }
    },
    {
        path: '/auth/registro-exitoso',
        component: () => import('@/js/pages/auth/Success.vue'),
        meta: { layout: 'auth' }
    },

    // user

    {
        path: '/user/profile',
        component: () => import('@/js/pages/user/Profile.vue'),
        meta: { layout: 'front' }
    },

    // cart 

    {
        path: '/cart',
        component: () => import('@/js/pages/cart/Cart.vue'),
        meta: { layout: 'front' }
    },
    {
        path: '/cart/checkouts',
        component: () => import('@/js/pages/cart/Checkouts.vue'),
        meta: { layout: 'auth' }
    },
    {
        path: '/cart/gracias',
        component: () => import('@/js/pages/cart/Gracias.vue'),
        meta: { layout: 'auth' }
    },

    // NotFound

    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('@/js/pages/NotFound.vue'),
        meta: { layout: 'front' }
    },

]




const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        // Siempre hacer scroll al inicio al cambiar de ruta
        return { top: 0 }
    }
});


router.beforeEach((to, from, next) => {
    const userStore = useUserStore();

    // Excluir rutas que comienzan con /admin para que Laravel las maneje
    if (to.path.startsWith('/admin')) {
        window.location.href = to.fullPath; // Redirige al backend
        return;
    }

    // Si está logueado y accede a /auth/*
    if (to.path.startsWith('/auth') && userStore.isAuthenticate) {
        return next('/')
    }

    // Si la ruta necesita autenticación
    if (to.meta.requiresAuth && !userStore.isAuthenticate) {
        return next('/auth/login')
    }

    // Protegemos todo lo que esta dentro de la carpeta user

    if (to.path.startsWith('/user') && !userStore.isAuthenticate) {
        return next('/auth/login')
    }

    next()
});

export default router;