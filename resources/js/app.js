require("./bootstrap");

import Vue from "vue";

import VueRouter from "vue-router";

import App from "./components/App";

Vue.use(VueRouter);
Vue.directive('phone', {
    bind(el) {
        function replaceNumberForInput(value) {
            let val = ''
            const x = value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/)

            if (!x[2] && x[1] !== '') {
                val = x[1] === '8' ? x[1] : '8' + x[1]
            } else {
                val = !x[3] ? x[1] + x[2] : x[1] + '(' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '')
            }
            return val
        }

        function replaceNumberForPaste(value) {
            const r = value.replace(/\D/g, '')
            let val = r
            if (val.charAt(0) === '7') {
                val = '8' + val.slice(1)
            }
            return replaceNumberForInput(val)
        }

        el.oninput = function(e) {
            if (!e.isTrusted) {
                return
            }
            this.value = replaceNumberForInput(this.value)
        }

        el.onpaste = function() {
            setTimeout(() => {
                const pasteVal = el.value
                this.value = replaceNumberForPaste(pasteVal)
            })
        }

    }
})
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
