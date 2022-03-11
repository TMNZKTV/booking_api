<template>
    <div>
        <form class="g-3 needs-validation" validate @submit.prevent="login">
            <div class="col-md-4 mx-auto pt-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    v-model="email"
                    required
                    placeholder="Type in your email..."
                />
                <div class="valid-feedback">Looks good!!!</div>
            </div>
            <div class="col-md-4 mx-auto pt-3">
                <label for="password" class="form-label">Пароль</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="password"
                    required
                    placeholder="Type in your password..."
                />
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="d-flex justify-content-center pt-3">
                <button class="btn btn-primary" type="submit">Войти</button>
            </div>
            <div class="d-flex justify-content-center pt-3 align-items-center">
                <span class="me-2">Нет аккаунта?</span>
                <router-link to="/register"> Зарегистрироваться </router-link>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "login",
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        async login() {

            // Сначала получаем cookie на /csrf-cookie
            await axios.get("/sanctum/csrf-cookie").then((response) => {
                // Вместе с TOKEN логинимся
                axios
                    .post("/login", {
                        email: this.email,
                        password: this.password,
                    })
                    .then((res) => {
                        // В локалсторедж сохраняем токен
                        localStorage.setItem(
                            "token",
                            res.config.headers["X-XSRF-TOKEN"]
                        );
                        this.$router.push({ name: "Home" });
                    })
                    .catch((err) => {
                        // Объект для последующей работы
                        alert('Что-то не так с данными!')
                        console.log(err);
                    });
            });
        },
        async getUser() {
            const response = await axios.get("api/user");
            return response.data;
        },
    },
};
</script>
