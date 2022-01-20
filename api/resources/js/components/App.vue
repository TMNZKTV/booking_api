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
<!--                <router-link class="btn btn-outline-success btn-outline-secondary" :to="{name: 'History'}" type="button">-->
<!--                    История-->
<!--                </router-link>-->
                <div :style="{marginLeft: 'auto'}">
                    <date-picker v-model="date" format="YYYY-MM-DD" type="format" valueType="date"></date-picker>
                </div>
            </form>
        </nav>

        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
export default {
    name: "App",
    components: {DatePicker},
    data() {
        return {
            date: new Date()
        }
    }
}
</script>


