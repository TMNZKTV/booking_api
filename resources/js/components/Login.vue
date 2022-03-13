<template>
    <div>
        <form class="g-3 needs-validation" novalidate @submit.prevent="checkForm">
            <div class="col-md-4 mx-auto pt-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control email_input"
                    id="email"
                    name="email"
                    v-model="email"
                    required
                    placeholder="Введите почту..."
                />
                <span class="error"></span>
            </div>
            <div class="col-md-4 mx-auto pt-3">
                <label for="password" class="form-label">Пароль</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="password"
                    required
                    placeholder="Введите ваш пароль..."
                />
                <span class="error"></span>
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
    mounted() {
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
        checkForm() {
            const form  = document.getElementsByTagName('form')[0];

            const email = document.getElementById('email');
            const emailError = document.querySelector('#email + span.error');
            const password = document.getElementById('password')
            const passwordError = document.querySelector('#password + span.error')

            email.addEventListener('input', function (event) {
                // Каждый раз, когда пользователь что-то вводит,
                // мы проверяем, являются ли поля формы валидными

                if (email.validity.valid) {
                    // Если на момент валидации какое-то сообщение об ошибке уже отображается,
                    // если поле валидно, удаляем сообщение
                    emailError.textContent = ''; // Сбросить содержимое сообщения
                    emailError.className = 'error'; // Сбросить визуальное состояние сообщения
                } else {
                    // Если поле не валидно, показываем правильную ошибку
                    showError();
                }
            });
            password.addEventListener('input', function (event) {
                // Каждый раз, когда пользователь что-то вводит,
                // мы проверяем, являются ли поля формы валидными

                if (password.validity.valid) {
                    // Если на момент валидации какое-то сообщение об ошибке уже отображается,
                    // если поле валидно, удаляем сообщение
                    passwordError.textContent = ''; // Сбросить содержимое сообщения
                    passwordError.className = 'error'; // Сбросить визуальное состояние сообщения
                } else {
                    // Если поле не валидно, показываем правильную ошибку
                    showError();
                }
            });
            form.addEventListener('submit', function (event) {
                // Если поле email валдно, позволяем форме отправляться
                if(!email.validity.valid) {
                    // Если поле email не валидно, отображаем соответствующее сообщение об ошибке
                    showError();
                    // Затем предотвращаем стандартное событие отправки формы
                    event.preventDefault();
                }
                if(!password.validity.valid) {
                    // Если поле email не валидно, отображаем соответствующее сообщение об ошибке
                    showError();
                    // Затем предотвращаем стандартное событие отправки формы
                    event.preventDefault();
                }
            });
            function showError() {
                if(email.validity.valueMissing) {
                    // Если поле пустое,
                    // отображаем следующее сообщение об ошибке
                    emailError.textContent = 'Введите Вашу почту!';
                } else if(email.validity.typeMismatch) {
                    // Если поле содержит не email-адрес,
                    // отображаем следующее сообщение об ошибке
                    emailError.textContent = 'Введите Вашу полную почту!';
                }
                if(password.validity.valueMissing) {
                    // Если поле пустое,
                    // отображаем следующее сообщение об ошибке
                    passwordError.textContent = 'Введите Ваш пароль!';
                } else if(password.validity.typeMismatch) {
                    // Если поле содержит не email-адрес,
                    // отображаем следующее сообщение об ошибке
                    passwordError.textContent = 'Введите Ваш пароль!';
                }
                // Задаём соответствующую стилизацию
                emailError.className = 'error active';
                passwordError.className = 'error active';
            }
            if (email.validity.valid && password.validity.valid) {
                this.login();
            }
        },
        async getUser() {
            const response = await axios.get("api/user");
            return response.data;
        },
    },
};
</script>

<style lang="scss">
.error {
    width  : 100%;
    padding: 0;

    font-size: 80%;
    color: white;
    background-color: #900;
    border-radius: 0 0 5px 5px;

    box-sizing: border-box;
}

.error.active {
    padding: 0.3em;
}

</style>
