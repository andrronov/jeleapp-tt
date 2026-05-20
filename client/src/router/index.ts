import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "home",
    component: () => import("../pages/Home.vue"),
  },
  {
    path: "/profile",
    name: "profile",
    component: () => import("../pages/Profile.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
