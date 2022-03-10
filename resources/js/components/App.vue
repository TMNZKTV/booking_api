<template>
    <div>
        <div>
            <transition name="slide">
                <div v-if="token" class="border-bottom header">
                    <div class="header_full px-4 py-2">
                        <ul class="nav align-items-center">
                            <li class="nav-item me-3">
                                <router-link
                                    class="nav-link px-0 py-3 link active"
                                    :to="{ name: 'Home' }"
                                >
                                    Главная
                                </router-link>
                            </li>
                            <li class="nav-item me-3">
                                <router-link
                                    class="nav-link px-0 py-3 link"
                                    :to="{ name: 'Booking' }"
                                >
                                    Бронирования
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    class="nav-link px-0 py-3 link"
                                    :to="{ name: 'History' }"
                                >
                                    История
                                </router-link>
                            </li>
                        </ul>
                        <div
                            v-if="token"
                            class="d-flex ms-auto align-items-center"
                        >
                            <div class="px-0 py-3 me-2">
                                <p class="link m-0">
                                    {{ user }}
                                </p>
                            </div>
                            <div class="px-0 py-3">
                                <a
                                    type="button"
                                    class="btn btn-primary btn-sm button_action"
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
                            </ul>
                        </div>
                        <div
                            v-if="token"
                            class="d-flex ms-auto align-items-center"
                        >
                            <div class="px-0 py-3 me-2">
                                <p class="link m-0">
                                    {{ user }}
                                </p>
                            </div>
                            <div class="px-0 py-3">
                                <a
                                    type="button"
                                    class="btn btn-primary btn-sm button_action"
                                    @click.prevent="logout"
                                    >ВЫЙТИ</a
                                >
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
                        console.log("This is user: ", response);
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
            axios.post("/logout").then((res) => {
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
// * {
//     font-family: Nunito, system-ui, BlinkMacSystemFont, -apple-system,
//         sans-serif;
// }
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
    color: white;
    text-transform: uppercase;
    font-weight: 600;
}
.main {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #eef1f4;
}
//.button_action {
//    color: white;
//    background-color: #4099de;
//    font-weight: 600;
//    font-size: 16px;
//    padding-left: 10px;
//    padding-right: 10px;
//    border-radius: 8px;
//    display: inline-block;
//    min-width: 70px;
//    border: 1px solid transparent;
//}
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
