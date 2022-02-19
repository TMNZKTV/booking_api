<template>
    <div>
        <div>
            <!-- px-4 py-5 my-5 text-center  panel row p-3 mb-2-->
            <div class="px-4 py-3" :style="{ backgroundColor: '#eef1f4' }">
                <div class="col-12">
                    <div>
                        <label for="place_selector" class="place_title">
                            <b>Ресторан на </b>
                        </label>
                    </div>

                    <div>
                        <select
                            class="form-control form-select w-full place_input"
                            id="place_selector"
                            v-model="place"
                            @change="choosePlace($event)"
                        >
                            <option value="" selected>...</option>
                            <option value="place_1">Марата</option>
                            <option value="place_2">Байкальской</option>
                            <option value="place_3">Горной</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <h1 v-if="place === ''" class="text-center my-5">
            Пожалуйста, выберите ресторан
        </h1>

        <!-- Loader -->
        <div class="text-center" v-if="loading">
            <div
                class="spinner-grow mt-5 text-success"
                style="width: 6rem; height: 6rem"
                role="status"
            >
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else-if="logs.length">
            <ul class="list-group">
                <li
                    v-for="log in logs"
                    class="list-group-item d-flex"
                    :key="log.id"
                    :class="{
                        'list-group-item-success': log.type === 'Бронирование',
                        'list-group-item-warning':
                            log.type === 'Обновление данных',
                        'list-group-item-danger':
                            log.type === 'Отмена бронирования',
                        'list-group-item-info': log.type === 'Ожидание',
                    }"
                >
                    {{ getUserTime(new Date(log.created_at)) }}. {{ log.type }}.
                    {{ log.text }}
                    <div class="dropdown ms-auto">
                        <button
                            class="btn btn-secondary dropdown-toggle"
                            type="button"
                            id="dropdownMenuClickableInside"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
                            aria-expanded="false"
                        >
                            Инфо
                        </button>
                        <ul
                            class="dropdown-menu p-1"
                            aria-labelledby="dropdownMenuClickableInside"
                            :style="{ minWidth: '250px' }"
                        >
                            <li>
                                <p>Имя: {{ log.name }}</p>
                            </li>
                            <li>
                                <p>Телефон: {{ log.phone }}</p>
                            </li>
                            <li>
                                <p>
                                    Дата: {{ getUserTime(new Date(log.date)) }}
                                </p>
                            </li>
                            <li>
                                <p>Время: {{ log.time }}</p>
                            </li>
                            <li>
                                <p>Cтол №: {{ log.table_id }}</p>
                            </li>
                            <li>
                                <p>
                                    Ресторан:
                                    {{
                                        log.place_id === 1
                                            ? "Марата"
                                            : log.place_id === 2
                                            ? "Байкальская"
                                            : log.place_id === 3
                                            ? "Горная"
                                            : null
                                    }}
                                </p>
                            </li>
                            <li>
                                <p>Предоплата : {{ log.prepayment }}р.</p>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <div v-else>
            <h2 class="text-center">Пока нет никаких записей</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: "History.vue",
    data() {
        return {
            logs: [],
            place: "",
            loading: false,
        };
    },
    computed: {},
    methods: {
        addLeadingZero(date) {
            return date < 10 ? "0" + date : date;
        },
        getUserTime(date) {
            const days = [
                "Воскресенье",
                "Понедельник",
                "Вторник",
                "Среда",
                "Четверг",
                "Пятница",
                "Суббота",
            ];
            let Y = date.getFullYear();
            let M = this.addLeadingZero(date.getMonth() + 1);
            let D = this.addLeadingZero(date.getDate());
            let d = days[date.getDay()];
            let h = this.addLeadingZero(date.getHours());
            let m = this.addLeadingZero(date.getMinutes());

            return `${Y}.${M}.${D} ${h}:${m} (${d})`;
        },
        choosePlace($event) {
            this.place = $event.target.value;
            this.fetchLogs();
        },
        async fetchLogs() {
            if (this.place === "place_1") {
                this.loading = true;
                const response = await axios.get(
                    "http://booking-api.test/api/logs"
                );
                const logs = response.data.filter((log) => {
                    if (log.place_id === 1) {
                        return log;
                    }
                });
                this.logs = logs.reverse();
                this.loading = false;
            }
            if (this.place === "place_2") {
                this.loading = true;
                const response = await axios.get(
                    "http://booking-api.test/api/logs"
                );
                const logs = response.data.filter((log) => {
                    if (log.place_id === 2) {
                        return log;
                    }
                });
                this.logs = logs.reverse();
                this.loading = false;
            }
            if (this.place === "place_3") {
                this.loading = true;
                const response = await axios.get(
                    "http://booking-api.test/api/logs"
                );
                const logs = response.data.filter((log) => {
                    if (log.place_id === 3) {
                        return log;
                    }
                });
                console.log(this.logs);
                this.logs = logs.reverse();
                this.loading = false;
            }
        },
    },
};
</script>

<style lang="scss">
.panel {
    min-height: 100px;
}
.place_input {
    font-weight: 600;
    color: #3c4655;
    background-color: white;
    border-width: 1px;
    border: none;
}
.place_title {
    color: #3c4655;
}
</style>
