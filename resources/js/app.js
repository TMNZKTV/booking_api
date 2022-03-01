require("./bootstrap");

import Vue from "vue";

import VueRouter from "vue-router";

import App from "./components/App";
// import Vue2TouchEvents from "vue2-touch-events";

Vue.use(VueRouter);

// Vue.use(Vue2TouchEvents, {
//     disableClick: false,
//     touchClass: "",
//     tapTolerance: 10,
//     touchHoldTolerance: 400,
//     swipeTolerance: 30,
//     longTapTimeInterval: 400,
//     namespace: "touch",
// });

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/home",
            name: "Home",
            component: () => import("./components/Home"),
        },
        {
            path: "/booking",
            name: "Booking",
            component: () => import("./components/Booking"),
        },
        {
            path: "/history",
            name: "History",
            component: () => import("./components/History"),
        },
        {
            path: "/login",
            name: "Login",
            component: () => import("./components/Login"),
        },
        {
            path: "/register",
            name: "Register",
            component: () => import("./components/Register"),
        },
    ],
});

// На роутере вызываем метод beforeEach, который проходится по всем роутам
// to - куда, from - откуда, next - следующее событие
router.beforeEach((to, from, next) => {
    // Сначала получаем Токен из локалсторедж
    const token = localStorage.getItem("token");
    // Если токена нет и пользователь идет на любой путь, отличающийся от Логина, перенаправляем на Логин
    if (!token) {
        if (to.name === "Register") {
            return next();
        }
        if (to.name !== "Login") {
            alert("Пожалуйста, войдите в систему!");
            return next({
                name: "Login",
            });
        }
    }
    // Если Токен есть, но юзер хочет попасть на Логин, запрещаем
    if (token && to.name === "Login") {
        alert("Вы авторизованы, не нужно входить заново!");
        return next({
            name: "Home",
        });
    } else {
        // Во всех иных случаях даем полный доступ к роуту
        next();
    }
});

// Обход ошибки при рерауте на Логин во время Логаута
// https://stackoverflow.com/questions/62462276/how-to-solve-avoided-redundant-navigation-to-current-location-error-in-vue
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch((err) => err);
};

// Экспортируем для дальнейшего использования в bootstrap.js, чтобы отлавливать ошибки 401 и 419
export default router;

const app = new Vue({
    el: "#app",
    components: {
        App,
    },
    router,
});
