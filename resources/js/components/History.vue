<template>
    <div>
        <div>
            <!-- px-4 py-5 my-5 text-center  panel row p-3 mb-2-->
            <div class="px-4 py-3" :style="{ backgroundColor: '#eef1f4' }">
                <div class="col-12">
                    <div class="mb-2">
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
                    class="list-group-item d-flex align-items-center"
                    :key="log.id"
                    :class="{
                        'list-group-item-primary': log.type === 'Бронирование',
                        'list-group-item-warning': log.type === 'Обновление',
                        'list-group-item-danger': log.type === 'Отмена',
                        'list-group-item-success': log.type === 'Завершено',
                        'list-group-item-info': log.type === 'Ожидание',
                        'list-group-item-dark': log.type === 'Восстановление',
                    }"
                >
                    {{ getTimeCreated(new Date(log.created_at)) }}.
                    {{ log.type }}.
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
                        <div class="dropdown-menu p-0">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5
                                        class="modal-title"
                                        id="updateGuestModal"
                                    >
                                        Информация о бронировании
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <!-- Имя и Телефон -->
                                    <div class="row">
                                        <!-- Имя -->
                                        <div class="mb-3 col-6">
                                            <label
                                                for="guestNameLog"
                                                class="form-label"
                                                >Имя</label
                                            >
                                            <input
                                                v-model="log.name"
                                                type="text"
                                                class="form-control"
                                                id="guestNameLog"
                                                placeholder="Brad Pitt"
                                                disabled
                                            />
                                        </div>
                                        <!-- Телефон -->
                                        <div class="mb-3 col-6">
                                            <label
                                                for="guestPhoneUpdate"
                                                class="form-label"
                                                >Телефон</label
                                            >
                                            <input
                                                v-model="log.phone"
                                                type="number"
                                                class="form-control"
                                                id="guestPhoneUpdate"
                                                placeholder="+7(xxx)xxx-xx-xx"
                                                disabled
                                            />
                                        </div>
                                    </div>
                                    <!-- Вредный гость? -->
                                    <div class="form-check mb-3">
                                        <label
                                            class="form-check-label"
                                            for="conflictGuestUpdate"
                                        >
                                            Конфликтный гость?
                                        </label>

                                        <input
                                            v-model="log.conflict"
                                            class="form-check-input"
                                            type="checkbox"
                                            value=""
                                            id="conflictGuestUpdate"
                                            disabled
                                        />
                                    </div>
                                    <!-- Мероприятие и Кол-во гостей -->
                                    <div class="row">
                                        <!-- Мероприятие -->
                                        <div class="mb-3 col-6">
                                            <label
                                                class="form-label"
                                                for="visit_type"
                                                >Мероприятие</label
                                            >
                                            <select
                                                id="visit_type"
                                                class="form-control"
                                                aria-label="Visit type select"
                                                v-model="log.visit_type"
                                                @change="
                                                    log.visit_type =
                                                        $event.target.value
                                                "
                                                disabled
                                            >
                                                <option value="Обычный визит">
                                                    Обычный визит
                                                </option>
                                                <option value="День рождения">
                                                    День рождения
                                                </option>
                                                <option
                                                    value="Романтический ужин"
                                                >
                                                    Романтический ужин
                                                </option>
                                                <option value="Семейный ужин">
                                                    Семейный ужин
                                                </option>
                                            </select>
                                        </div>
                                        <!-- Кол-во гостей -->
                                        <div class="mb-3 col-6">
                                            <label
                                                class="form-label"
                                                for="guest_amount"
                                                >Количество гостей</label
                                            >
                                            <select
                                                id="guest_amount"
                                                v-model="log.amount"
                                                @change="
                                                    log.amount =
                                                        $event.target.value
                                                "
                                                class="form-control w-50"
                                                disabled
                                            >
                                                <option value="1" selected>
                                                    1
                                                </option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Доп.инфо -->
                                    <div class="mb-3">
                                        <label
                                            for="guestNoteUpdate"
                                            class="form-label"
                                            >Дополнительная информация</label
                                        >
                                        <input
                                            v-model="log.note"
                                            type="text"
                                            class="form-control"
                                            id="guestNoteUpdate"
                                            placeholder="На заметку"
                                            disabled
                                        />
                                    </div>
                                    <!-- Предоплата и Стол -->
                                    <div class="row">
                                        <!-- Предоплата -->
                                        <div class="mb-3 col-6">
                                            <label
                                                for="guestPrepaymentUpdate"
                                                class="form-label"
                                                >Предоплата</label
                                            >
                                            <input
                                                v-model="log.prepayment"
                                                type="number"
                                                class="form-control"
                                                id="guestPrepaymentUpdate"
                                                placeholder="Сумма предоплаты"
                                                step="100"
                                                disabled
                                            />
                                        </div>
                                        <!-- Стол -->
                                        <div class="mb-3 col-6">
                                            <label
                                                class="form-label"
                                                for="selectTablesUpdate"
                                                >№ стола</label
                                            >
                                            <input
                                                id="selectTablesUpdate"
                                                class="form-control"
                                                v-model="log.table_id"
                                                disabled
                                            />
                                        </div>
                                    </div>
                                    <!-- Дата и Время -->
                                    <div class="mb-3 row">
                                        <!-- Дата -->
                                        <div class="col-6">
                                            <p class="mb-2">Дата</p>
                                            <date-picker
                                                v-model="log.date"
                                                format="YYYY-MM-DD"
                                                type="date"
                                                valueType="format"
                                                disabled
                                            >
                                            </date-picker>
                                        </div>
                                        <!-- Время -->
                                        <div class="col-6">
                                            <p class="mb-2">Начало</p>
                                            <date-picker
                                                v-model="log.from"
                                                :minute-step="30"
                                                :hour-options="hours"
                                                format="HH:mm"
                                                value-type="format"
                                                type="time"
                                                placeholder="Час:минута"
                                                disabled
                                            ></date-picker>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col offset-6">
                                            <p class="mb-2">Конец</p>
                                            <date-picker
                                                v-model="log.to"
                                                :minute-step="30"
                                                :hour-options="hours"
                                                format="HH:mm"
                                                value-type="format"
                                                type="time"
                                                placeholder="Ч:м"
                                                disabled=""
                                            ></date-picker>
                                        </div>
                                    </div>
                                    <!-- Ответственный -->
                                    <div class="mb-3 row">
                                        <div class="col-6">
                                            <label
                                                class="form-label"
                                                for="responsible_name"
                                                >Ответственный</label
                                            >
                                            <input
                                                type="text"
                                                id="responsible_name"
                                                class="form-control col-6"
                                                v-model="log.responsible_name"
                                                disabled
                                            />
                                        </div>
                                        <div class="col-6">
                                            <label
                                                class="form-label"
                                                for="responsible_email"
                                                >Почта</label
                                            >
                                            <input
                                                type="text"
                                                id="responsible_email"
                                                class="form-control col-6"
                                                v-model="log.responsible_email"
                                                disabled
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="modal-footer"
                                    v-if="log.type === 'Отмена'"
                                >
                                    <button
                                        type="button"
                                        class="btn btn-secondary btn-danger"
                                        @click="() => rebook(log)"
                                    >
                                        Восстановить
                                    </button>
                                </div>
                            </div>
                        </div>
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
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/scss/index.scss";

export default {
    name: "History.vue",
    components: {
        DatePicker,
    },
    data() {
        return {
            logs: [],
            hours: Array.from({ length: 23 }).map((_, i) => i + 9),
            log: {
                id: null,
                name: "",
                phone: "",
                conflict: false,
                visit_type: "",
                amount: 1,
                note: "",
                prepayment: 0,
                table_id: null,
                place_id: null,
                date: new Date(),
                from: "",
                to: "",
                responsible_email: "",
                responsible_name: "",
            },
            place: "",
            loading: false,
        };
    },
    computed: {},
    methods: {
        addLeadingZero(date) {
            return date < 10 ? "0" + date : date;
        },
        getTimeCreated(date) {
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
        getReservationDate(date) {
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

            return `${Y}.${M}.${D} (${d})`;
        },
        choosePlace($event) {
            this.place = $event.target.value;
            this.fetchLogs();
        },
        async rebook(log) {
            if (this.place === "place_1") {
                const newReservation = {
                    id: log.id,
                    name: log.name,
                    phone: log.phone,
                    conflict: log.conflict,
                    visit_type: log.visit_type,
                    amount: log.amount,
                    note: log.note,
                    prepayment: log.prepayment,
                    table_id: log.table_id,
                    place_id: 1,
                    date: log.date,
                    from: log.from,
                    to: log.to,
                    responsible_email: log.responsible_email,
                    responsible_name: log.responsible_name,
                };
                try {
                    await axios.post(
                        `/api/reservations`,
                        newReservation
                    );
                    const newLog = {
                        text: `Стол №${newReservation.table_id} был забронирован.`,
                        type: "Восстановление",
                        ...newReservation,
                    };
                    await axios.post(
                        `/api/logs`,
                        newLog
                    );
                } catch (error) {
                    console.log(error.message);
                }
            }
            if (this.place === "place_2") {
                const newReservation = {
                    id: log.id,
                    name: log.name,
                    phone: log.phone,
                    conflict: log.conflict,
                    visit_type: log.visit_type,
                    amount: log.amount,
                    note: log.note,
                    prepayment: log.prepayment,
                    table_id: log.table_id,
                    place_id: 2,
                    date: log.date,
                    from: log.from,
                    to: log.to,
                    responsible_email: log.responsible_email,
                    responsible_name: log.responsible_name,
                };
                try {
                    await axios.post(
                        `/api/reservations`,
                        newReservation
                    );

                    const newLog = {
                        text: `Стол №${newReservation.table_id} был забронирован.`,
                        type: "Восстановление",
                        ...newReservation,
                    };
                    await axios.post(
                        `/api/logs`,
                        newLog
                    );
                } catch (error) {
                    console.log(error);
                }
            }
            if (this.place === "place_3") {
                const newReservation = {
                    id: log.id,
                    name: log.name,
                    phone: log.phone,
                    conflict: log.conflict,
                    visit_type: log.visit_type,
                    amount: log.amount,
                    note: log.note,
                    prepayment: log.prepayment,
                    table_id: log.table_id,
                    place_id: 3,
                    date: log.date,
                    from: log.from,
                    to: log.to,
                    responsible_email: log.responsible_email,
                    responsible_name: log.responsible_name,
                };
                try {
                    await axios.post(
                        `/api/reservations`,
                        newReservation
                    );
                    const newLog = {
                        text: `Стол №${newReservation.table_id} был забронирован.`,
                        type: "Восстановление",
                        ...newReservation,
                    };
                    await axios.post(
                        `/api/logs`,
                        newLog
                    );
                } catch (error) {
                    console.log(error);
                }
            }
            this.fetchLogs();
        },
        async fetchLogs() {
            if (this.place === "place_1") {
                this.loading = true;
                const response = await axios.get(
                    "/api/logs"
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
                    "/api/logs"
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
                    "/api/logs"
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
.dropdown-menu {
    min-width: 500px;
}
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
.log_info {
    font-weight: bold;
}
</style>
