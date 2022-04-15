<template>
    <div>
        <div>
            <transition name="slide">
                <div v-if="token" class="border-bottom header">
                    <div class="header_full px-4">
                        <nav class="nav align-items-center d-flex">
                                <router-link
                                    class="me-2 link"
                                    :to="{ name: 'Home' }"
                                >
                                    Главная
                                </router-link>
                                <router-link
                                    class="me-2 link"
                                    :to="{ name: 'Booking' }"
                                >
                                    Бронирования
                                </router-link>
                                <router-link
                                    class="link me-3"
                                    :to="{ name: 'History' }"
                                >
                                    История
                                </router-link>
                                <a class="link" href="https://kimchi.team/feedback-kitchen/">Проблема с блюдом</a>
                        </nav>
                        <div
                            v-if="token"
                            class="d-flex ms-auto align-items-center"
                        >
                            <div class="px-0 py-3 me-2">
                                <p class="link name m-0">
                                    {{ user }}
                                </p>
                            </div>
                            <div class="px-0 py-3">
                                <a
                                    type="button"
                                    class="btn btn-primary p-2 button_action"
                                    @click.prevent="logout"
                                    >ВЫЙТИ</a
                                >
                            </div>
                        </div>
                    </div>
                    <div class="header_mobile container">
                        <!-- Dropdown для Мобилок -->
                        <div class="dropdown py-3">
                            <button
                                class="btn btn-secondary dropdown-toggle"
                                type="button"
                                id="dropdownMenuButton1"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Меню
                            </button>
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="dropdownMenuButton1"
                            >
                                <li>
                                    <router-link
                                        class="dropdown-item"
                                        :to="{ name: 'Home' }"
                                    >
                                        Главная
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="dropdown-item"
                                        :to="{ name: 'Booking' }"
                                    >
                                        Бронирования
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="dropdown-item"
                                        :to="{ name: 'History' }"
                                    >
                                        История
                                    </router-link>
                                </li>
                                <li>
                                    <a   class="dropdown-item" href="https://kimchi.team/feedback-kitchen/">Проблема с блюдом</a>
                                </li>
                            </ul>
                        </div>
                        <div
                            v-if="token"
                            class="d-flex ms-auto align-items-center"
                        >
                            <div class="px-0 py-3 me-2">
                                <p class="link name m-0">
                                    {{ user }}
                                </p>
                            </div>
                            <div class="px-0 py-3">
                                <a
                                    type="button"
                                    class="btn btn-primary btn-sm button_logout"
                                    @click.prevent="logout"
                                    >ВЫЙТИ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>

            <div>
                <router-view :user="user"></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            user: null,
            token: null,
        };
    },
    watch: {
        token() {
            this.user = null;
            if (this.token !== null) {
                axios
                    .get("/api/user")
                    .then((response) => {
                        this.user = response.data.name;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
    },
    async mounted() {
        this.getToken();
    },
    // Форсированный ре-рендер по выполнению функции
    async updated() {
        this.getToken();
    },
    methods: {
        getToken() {
            this.token = localStorage.getItem("token");
        },
        logout() {
            // Отправляем запрос на logout
            axios.post("/logout").then(() => {
                // Удаляем из локалсторедж токен
                localStorage.removeItem("token");
                // Отправляем на страницу входа
                this.$router.push("/login");
            });
        },
    },
};
</script>

<style lang="scss">
a.router-link-exact-active {
    padding: 20px 3px 20px 3px;
    color: white;
    position: relative;

    &::after {
        position: absolute;
        content: "";
        width: 100%;
        height: 2px;
        left: 0;
        right: 0;
        bottom: 10px;
        background-color: white;
    }
}
.nav a:hover,
.nav a:focus {
    color: white;
}
html,
body {
    font-family: Circe, sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 300;
    line-height: 1.2;
}
.header {
    background-image: linear-gradient(0deg, #7e8ea1 0%, #3c4655 100%);
    background-attachment: fixed;

    .header_full {
        display: none;

        @media (min-width: 767px) {
            display: flex;
        }
    }
}
.link {
    color: #D3D3D3;
    text-transform: uppercase;
    font-weight: 600;
    text-decoration: none;
}
.name {
    color: white;
}
.main {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #eef1f4;
}
.button_logout {
    font-size: 14px;
}
.header_mobile {
    display: none;
    @media (min-width: 375px) {
        display: flex;
    }
    @media (min-width: 767px) {
        display: none;
    }
}

ul {
    cursor: pointer;
}

.slide-enter-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
}

.slide-leave-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to,
.slide-leave {
    max-height: 100px;
    overflow: hidden;
}

.slide-enter,
.slide-leave-to {
    overflow: hidden;
    max-height: 0;
}
</style>
