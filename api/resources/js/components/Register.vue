<template>
    <div>
        <form
            class="g-3 needs-validation"
            novalidate
            @submit.prevent="onSubmit"
        >
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
            <div class="col-md-4 mx-auto pt-3">
                <label for="register_email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="register_email"
                    v-model="email"
                    required
                    placeholder="Укажите почту..."
                />
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-4 mx-auto pt-3">
                <label for="register_password" class="form-label">Пароль</label>
                <input
                    type="password"
                    class="form-control"
                    id="register_password"
                    v-model="password"
                    required
                    placeholder="Не забудьте пароль..."
                />
                <div class="valid-feedback">Looks good!</div>
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
            name: "",
            email: "",
            password: "",
        };
    },
    setup() {},
    validations() {},
    mounted() {},
    methods: {
        onSubmit() {
            this.$router.push("/");
        },
        async onSubmit() {
            console.log("Submit works!");

            const formData = {
                email: this.email,
                password: this.password,
                name: this.name,
            };
            this.$router.push("/");

            // try {
            //     await axios.post(
            //         "http://booking-api.test/api/register",
            //         formData
            //     );
            // } catch (error) {
            //     console.log(error);
            // }
        },
    },
};
</script>
