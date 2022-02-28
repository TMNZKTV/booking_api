<template>
    <div>
        <form
            class="g-3 needs-validation"
            novalidate
            @submit.prevent="register"
        >
            <!-- Имя -->
            <div class="col-md-4 mx-auto pt-3">
                <label for="register_name" class="form-label">Имя</label>
                <input
                    type="text"
                    class="form-control"
                    id="register_name"
                    v-model="name"
                    required
                    placeholder="Укажите имя..."
                />
                <div class="valid-feedback">Looks good!</div>
            </div>
            <!-- Почта -->
            <div class="col-md-4 mx-auto pt-3">
                <label for="register_email" class="form-label">Email</label>
                <div class="d-flex flex-row">
                    <input
                        type="email"
                        class="form-control"
                        id="register_email"
                        v-model="email"
                        required
                        placeholder="Почта..."
                    />
                    <input
                        type="email"
                        class="form-control"
                        v-model="kimchiEmail"
                        required
                        disabled
                    />
                </div>

                <div class="valid-feedback">Looks good!</div>
            </div>
            <!-- Пароль -->
            <div class="col-md-4 mx-auto pt-3">
                <label for="register_password" class="form-label">Пароль</label>
                <input
                    type="password"
                    class="form-control"
                    id="register_password"
                    v-model="password"
                    required
                    placeholder="Придумайте пароль..."
                />
                <div class="valid-feedback">Looks good!</div>
            </div>
            <!-- Подвердите пароль -->
            <div class="col-md-4 mx-auto pt-3">
                <label for="password_confirmation" class="form-label"
                    >Повторите пароль</label
                >
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    v-model="password_confirmation"
                    required
                    placeholder="Повторите пароль..."
                />
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-4 mx-auto pt-3">
                <label for="AdminPassRegister" class="form-label"
                    >Мастер-Пароль для завершения регистрации</label
                >
                <input
                    v-model="adminPass"
                    type="password"
                    id="AdminPassRegister"
                    class="form-control"
                    aria-describedby="passwordHelpBlock"
                    required
                />
                <div id="passwordHelpBlock" class="form-text">
                    Используйте Мастер-пароль Администратора для завершения
                    регистрации
                </div>
            </div>
            <div class="d-flex justify-content-center pt-3">
                <button class="btn btn-primary" type="submit">
                    Зарегистрироваться
                </button>
            </div>
            <div class="d-flex justify-content-center pt-3 align-items-center">
                <span class="me-2">Есть аккаунта?</span>
                <router-link to="/login"> Войти </router-link>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "register",
    data() {
        return {
            adminPass: "",
            adminChecked: false,
            name: "",
            kimchiEmail: "@kimchi.ru",
            email: "",
            password: "",
            password_confirmation: "",
        };
    },
    methods: {
        checkPass() {
            if (this.adminPass === process.env.MIX_MASTERKEY) {
                this.adminChecked = true;
            } else {
                this.adminChecked = false;
                this.adminPass = "";
            }
        },
        register() {
            this.checkPass();
            // Отправляем запрос за X-XSRF-TOKEN
            if (this.adminChecked) {
                axios.get("/sanctum/csrf-cookie").then((response) => {
                    // Получив, отправляем запрос на /register с объектом (данные пользователя)
                    axios
                        .post("/register", {
                            name: this.name,
                            email: this.email + this.kimchiEmail,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        })
                        .then((res) => {
                            // В локалсторедж сохраняем токен
                            localStorage.setItem(
                                "token",
                                res.config.headers["X-XSRF-TOKEN"]
                            );
                            this.$router.push({ name: "Home" });
                        })
                        .catch((error) => {
                            // Объект ошибки для дальнейшей работы
                            console.log(error);
                        });
                });
                this.adminPass = "";
                this.adminChecked = false;
            } else {
                alert("Используйте Мастер-пароль Администратора");
            }
        },
    },
};
</script>
