<template>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <form class="container-fluid justify-content-start">
                <router-link class="btn btn-outline-success me-2" :to="{name: 'Home'}"type="button">
                    Главная
                </router-link>
                <router-link class="btn btn-outline-success btn-outline-secondary me-2" :to="{name: 'Booking'}" type="button">
                    Бронирования
                </router-link>
                <router-link class="btn btn-outline-success btn-outline-secondary" :to="{name: 'History'}" type="button">
                    История
                </router-link>
            </form>
        </nav>

        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

export default {
    name: "App",
}
</script>


