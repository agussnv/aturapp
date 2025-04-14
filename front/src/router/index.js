import { createRouter, createWebHistory } from 'vue-router';
import { useCounterStore } from '../stores/counter';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: "login"
      // name: 'landingPage',
      // component: () => import('../views/LandingPage.vue'),
    },
    {
      path: '/home',
      name: 'home',
      component: () => import('../components/HomeComp.vue'),
      meta: { requiresAuth: true, rol: 1 },
    },
    {
      path: '/access',
      name: 'access',
      component: () => import('../views/access.vue'),
      meta: { public: true },
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../components/login.vue'),
      meta: { public: true },
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../components/register.vue'),
      meta: { public: true },
    },
    {
      path: '/chat',
      name: 'chat',
      component: () => import('../components/ChatComp.vue'),
      meta: {},
      // meta: { requiresAuth: true, rol: 1 },
    },
    {
      path: '/mapa',
      name: 'mapa',
      component: () => import('../components/MapComp.vue'),
      meta: { requiresAuth: true, rol: 1 },
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: () => import('../components/UserComp.vue'),
      meta: { requiresAuth: true, rol: 1 },
    },
    {
      path: '/perfil/alertes',
      name: 'mevesAlertes',
      component: () => import('../components/MevesAlertesComp.vue'),
      meta: { requiresAuth: true, rol: 1 },
    },
    {
      path: '/perfil/dades',
      name: 'dades',
      component: () => import('../components/DadesUserComp.vue'),
      meta: { requiresAuth: true, rol: 1 },
    },
    {
      path: '/soport',
      name: 'soport',
      component: () => import('../components/SoportComp.vue'),
      meta: { public: true },
    },
    {
      path: '/perfil/alertes/editar',
      name: 'editarAlerta',
      component: () => import('../components/EditarAlertaComp.vue'),
      meta: { requiresAuth: true, rol: 1 },
    },
    {
      path: '/enquesta',
      name: 'enquesta',
      component: () => import('../components/enquesta.vue'),
      meta: { requiresAuth: true, rol: 1 },
    },

    // ====== GESTIÓ D'ALUMNES ========================
    {
      path: '/admin/alumnes',
      name: 'alumnes',
      component: () => import('../components/IncidenciasAlumnesComp.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/admin/alumnes/:id',
      name: 'alumne',
      component: () => import('../components/DetallAlumne.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/admin/modificar-alumne/:id',
      name: 'ModificarAlumne',
      component: () => import('../components/ModificarAlumneComp.vue')
    },


    {
      path: '/admin',
      name: 'adminHome',
      component: () => import('../components/HomeAdminComp.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/admin/heatmap',
      name: 'heatmap',
      component: () => import('../components/HeatmapComp.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/admin/sociograma',
      name: 'sociograma',
      component: () => import('../components/sociograma.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/admin/heatmap/sector',
      name: 'sector',
      component: () => import('../components/SectorAlertasComp.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/admin/estadisticas',
      name: 'estadisticas',
      component: () => import('../components/EstadisticasComp.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/admin/denuncies',
      name: 'denuncies',
      component: () => import('../components/DenunciesComp.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
    {
      path: '/password/solicitar',
      name: 'Solicitar reset password',
      component: () => import('../components/SolicitarResetComp.vue'),
      meta: { public: true },
    },
    {
      path: '/password/reset/:token',
      name: 'Reiniciar password',
      component: () => import('../components/ResetPasswordComp.vue'),
    },
    {
      path: '/admin/alertes',
      name: 'alertes',
      component: () => import('../components/AdminAlertes.vue'),
      meta: { requiresAuth: true, rol: 2 },
    },
  ],
});

router.beforeEach((to, from, next) => {
  const store = useCounterStore();

  const SessionIniciada = store.Iniciado;
  const isAdmin = store.userData?.user.rol === 2;
  const isUser = store.userData?.user.rol === 1;

  const EsPaginaPublica = to.matched.some((record) => record.meta.public);
  const RequiereAutenticacion = to.matched.some((record) => record.meta.requiresAuth);
  const RolRequerido = to.meta.rol;

  if (!SessionIniciada && RequiereAutenticacion) {
    next('/login');
  } else if (SessionIniciada && EsPaginaPublica) {
    next(isAdmin ? '/admin' : '/home');
  } else if (RequiereAutenticacion && RolRequerido) {
    if ((RolRequerido === 2 && isAdmin) || (RolRequerido === 1 && isUser)) {
      next();
    } else {
      next('/');
    }
  } else {
    next();
  }
});

export default router;