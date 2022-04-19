<template>
    <div>
        <!-- Панель управления -->
        <div class="px-4 py-3 mb-5 history_panel">
                <div class="row">
                            <!-- Календарь -->
                            <div class="col-auto">
                                <div class="card col-lg-6 border border-4">
                                    <div class="card-body card_content_info text-center">
                                        <p class="day_full m-0">
                                            {{ dayFilter }}
                                        </p>
                                        <p class="date_full m-0">
                                            {{ dateFilter }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p class="date_full_mobile d-none">
                                        <b>{{ dateFilter }}</b>
                                    </p>
                                </div>
                            </div>
                            <!-- Дата и Ресторан -->
                            <div class="date_picker_full col-6 col-sm-6 col-md-6">
                                <p class="p-0 mb-2"><b>Дата</b></p>
                                <date-picker
                                    v-model="date"
                                    format="YYYY-MM-DD"
                                    valueType="format"
                                    :style="{ width: '150px' }"
                                ></date-picker>

                                <div class="row mt-md-2 mt-xl-4">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="mb-2">
                                            <label
                                                for="place_selector"
                                                class="place_title"
                                            >
                                                <b>Ресторан на</b>
                                            </label>
                                        </div>

                                        <div>
                                            <select
                                                class="form-control form-select w-full select_input border border-2"
                                                id="place_selector"
                                                v-model="place"
                                                @change="choosePlace($event)"
                                            >
                                                <option value="" selected>
                                                    ...
                                                </option>
                                                <option value="place_1">
                                                    Марата
                                                </option>
                                                <option value="place_2">
                                                    Байкальской
                                                </option>
                                                <option value="place_3">
                                                    Горной
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <!-- Выбор Стола -->
                                                <div class="mb-2">
                                                    <label class="place_title">
                                                        <b>Стол №</b>
                                                    </label>
                                                </div>
                                                <div>
                                                    <select
                                                        class="form-control form-select w-full select_input border border-2"
                                                        id="table_selector"
                                                        v-model="table"
                                                        @change="chooseTable($event)"

                                                    >
                                                        <option value="" selected>Все столы</option>
                                                        <option v-for="item in tables" :value="item.id">{{item.i}}</option>
                                                    </select>
                                                </div>
                                    </div>
                                </div>
                            </div>
                </div>
        </div>

        <!-- Выберите ресторан   -->
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

        <!-- Все логи -->
        <div v-if="allLogs.length">
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
                                                type="tel"
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
                                            <input
                                                id="guest_amount"
                                                v-model="log.amount"
                                                class="form-control w-50"
                                                disabled
                                            />
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
                                        <div class="col-6">
                                            <div class="form-check form-switch col-auto mb-3">
                                                <label class="form-check-label" for="guestArrivedToggleUpdate">Гость пришел</label>
                                                <input
                                                    v-model="log.arrived"
                                                    id="guestArrivedToggleUpdate"
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    disabled
                                                />
                                            </div>
                                            <div class="form-check form-switch col-auto">
                                                <label class="form-check-label" for="guestLateToggleUpdate">Гость опаздывает</label>
                                                <input
                                                    v-model="log.late"
                                                    id="guestLateToggleUpdate"
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    disabled
                                                />
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <p class="mb-2">Конец</p>
                                            <date-picker
                                                v-model="log.to"
                                                :minute-step="30"
                                                :hour-options="hours"
                                                format="HH:mm"
                                                value-type="format"
                                                type="time"
                                                placeholder="Ч:м"
                                                disabled
                                            ></date-picker>
                                        </div>
                                    </div>
                                    <div v-if="log.type === 'Отмена'" class="mb-3">
                                            <label
                                                for="reasonFailed"
                                                class="form-label"
                                            >Причина отмены</label
                                            >
                                            <textarea
                                                v-model="log.reason_failed"
                                                type="text"
                                                class="form-control"
                                                id="reasonFailed"
                                                placeholder="..."
                                                disabled
                                                :style="{resize: 'none', height: '100px'}"
                                            ></textarea>
                                    </div>
                                    <div v-if="log.type === 'Завершено'" class="mb-3">
                                        <label
                                            for="feedback"
                                            class="form-label"
                                        >Комментарий</label
                                        >
                                        <textarea
                                            v-model="log.feedback"
                                            type="text"
                                            class="form-control"
                                            id="feedback"
                                            placeholder="..."
                                            disabled
                                            :style="{resize: 'none', height: '100px'}"
                                        ></textarea>
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
                                    <a
                                        id="rebookBtn"
                                        class="btn btn-secondary btn-danger"
                                        @click="() => rebook(log)"
                                    >
                                        Восстановить
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Если записей нет -->
        <div v-if="logs.length === 0 && place !== '' && !loading" class="text-center mt-3">
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
            date: this.datePicker(new Date()),
            allLogs: [],
            allTables: [],
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
                arrived: false,
                late: false,
                responsible_email: "",
                responsible_name: "",
            },
            place: "",
            table: '',
            loading: false,
        };
    },
    async mounted() {
      const response = await axios.get('/api/tables');
      this.allTables = response.data.data;
    },
    computed: {
        dayFilter() {
            const options = {
                day: "numeric",
            };
            return Intl.DateTimeFormat("ru-RU", options).format(new Date(this.date));
        },
        dateFilter() {
            const options = {
                weekday: "long",
                year: "numeric",
                month: "long",
            };
            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
            return capitalizeFirstLetter(
                Intl.DateTimeFormat("ru-RU", options).format(new Date(this.date))
            );
        },
        tables() {
            if(this.place === 'place_1') {
                return this.allTables.filter(
                    (table) => table.place_id === 1
                );
            }
            if(this.place === 'place_2') {
                return this.allTables.filter(
                    (table) => table.place_id === 2
                );
            }
            if(this.place === 'place_3') {
                return this.allTables.filter(
                    (table) => table.place_id === 3
                );
            }
        },
        logs() {
            if(this.table === '' && this.place !== '') {
                return this.allLogs;
            }
            if(this.table !== '' || this.table !== 'Ожидание' || this.table !== 'Бар') {
                return this.allLogs.filter((log) => log.table_id === Number(this.table))
            }
            if(this.table === 'Ожидание' && this.place === 'place_1') {
                return this.allLogs.filter((log) => log.table_id === 100)
            }
            if(this.table === 'Бар' && this.place === 'place_1') {
                return this.allLogs.filter((log) => log.table_id === 101)
            }

            if(this.table === 'Ожидание' && this.place === 'place_2') {
                return this.allLogs.filter((log) => log.table_id === 102)
            }
            if(this.table === 'Бар' && this.place === 'place_2') {
                return this.allLogs.filter((log) => log.table_id === 103)
            }

            if(this.table === 'Ожидание' && this.place === 'place_3') {
                return this.allLogs.filter((log) => log.table_id === 104)
            }
            if(this.table === 'Бар' && this.place === 'place_3') {
                return this.allLogs.filter((log) => log.table_id === 105)
            }
        }
    },
    watch: {
        async date() {
            await this.fetchLogs();
        }
    },
    methods: {
        datePicker(date) {
            let Y = date.getFullYear();
            let M = this.addLeadingZero(date.getMonth() + 1);
            let D = this.addLeadingZero(date.getDate());

            return `${Y}-${M}-${D}`;
        },
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
            this.allLogs = [];
            this.place = $event.target.value;
            this.table = '';
            this.fetchLogs();
        },
        chooseTable($event) {
            this.table = $event.target.value;
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
                    arrived: log.arrived,
                    late: log.late,
                    responsible_email: log.responsible_email,
                    responsible_name: log.responsible_name,
                };
                try {
                    await axios.post(
                        `/api/reservations`,
                        newReservation
                    );
                    const newLog = {
                        text: `Стол №${newReservation.table_id} на Марата был забронирован.`,
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
                    arrived: log.arrived,
                    late: log.late,
                    responsible_email: log.responsible_email,
                    responsible_name: log.responsible_name,
                };
                try {
                    await axios.post(
                        `/api/reservations`,
                        newReservation
                    );

                    const newLog = {
                        text: `Стол №${newReservation.table_id} на Байкальской был забронирован.`,
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
                    arrived: log.arrived,
                    late: log.late,
                    responsible_email: log.responsible_email,
                    responsible_name: log.responsible_name,
                };
                try {
                    await axios.post(
                        `/api/reservations`,
                        newReservation
                    );
                    const newLog = {
                        text: `Стол №${newReservation.table_id} на Горной был забронирован.`,
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

            const dropdownToggleEl = document.getElementById('dropdownMenuClickableInside');
            const dropdownList = new bootstrap.Dropdown(dropdownToggleEl);
            dropdownList.hide();
            await this.fetchLogs();
            window.scrollTo(0, -1000)
        },
        async fetchLogs() {
            this.loading = true;
            const response = await axios.get("/api/logs", { params: {date: this.date}})
            console.log(response)
            if (this.place === "place_1") {
                this.allLogs = response.data.filter((log) => log.place_id === 1).reverse();
            }
            if (this.place === "place_2") {
                this.allLogs = response.data.filter((log) => log.place_id === 2).reverse();
            }
            if (this.place === "place_3") {
                this.allLogs = response.data.filter((log) => log.place_id === 3).reverse();
            }
            this.loading = false;
        },
    },
};
</script>

<style lang="scss">
.history_panel {
    background-color: #eef1f4;
    .date_picker_full {
        @media (min-width: 1440px) {
            padding-top: 20px;
        }
        @media (min-width: 2559px) {
            padding-top: 45px;
        }

        .place_title {
            width: 160px;
            font-weight: 500;
            color: #3c4655;
            @media (min-width: 2560px) {
                font-size: 25px;
            }
        }

        p {
            font-weight: 500;
            @media (min-width: 2560px) {
                font-size: 25px;
            }
        }
    }
    .select_input {
        height: 50px;
        font-weight: 600;
        color: #3c4655;
        background-color: white;
        border: 1px none;
        @media (min-width: 2560px) {
            font-size: 20px;
        }
    }
     .date_full_mobile {
        @media (min-width: 375px) and (max-width: 767px) {
            display: block;
        }
        @media (min-width: 768px) {
            display: none;
        }
    }
     .card {
         width: 115px;
         height: 130px;
        @media (min-width: 767px) {
            width: 150px;
            height: 157px;
        }
        @media (min-width: 992px) {
            min-width: 182px;
            min-height: 182px;
        }
        @media (min-width: 1200px) and (max-width: 1500px) {
            min-width: 240px;
            min-height: 240px;
        }
        @media (min-width: 1501px) {
            min-width: 300px;
            min-height: 300px;
        }
        @media (min-width: 1999px) {
            min-width: 390px;
            min-height: 300px;
        }
         .card_content_info {
             padding: 15px 5px 15px 5px;
            @media (min-width: 576px) {
                padding: 15px 5px 15px 5px;
            }
            @media (min-width: 767px) {
                padding: 20px 5px 20px 5px;
            }
            @media (min-width: 992px) {
                padding: 17px 5px 20px 5px;
            }
            @media (min-width: 1200px) {
                padding: 25px 10px 15px 10px;
            }
            @media (min-width: 1500px) {
                padding: 50px 10px 15px 10px;
            }
            @media (min-width: 2000px) {
                padding: 45px 10px 15px 10px;
            }
        }
         .card-body {
            .day_full {
                font-weight: 500;
                @media (min-width: 375px) {
                    font-size: 30px;
                }
                @media (min-width: 576px) {
                    font-size: 30px;
                }
                @media (min-width: 767px) {
                    font-size: 40px;
                }
                @media (min-width: 998px) {
                    font-size: 60px;
                }
                @media (min-width: 1203px) {
                    font-size: 80px;
                }
            }
            .date_full {

                //@media (min-width: 375px) {
                //    display: none;
                //}
                @media (min-width: 767px) {
                    display: block;
                    font-size: 15px;
                }
                @media (min-width: 992px) {
                    font-size: 25px;
                }
                @media (min-width: 1440px) {
                    font-size: 28px;
                }
                @media (min-width: 2000px) {
                    font-size: 35px;
                }
                @media (min-width: 2560px) {
                    font-size: 40px;
                }
            }
        }
    }
}
.dropdown-menu {
    min-width: 500px;
}
.log_info {
    font-weight: bold;
}
</style>
