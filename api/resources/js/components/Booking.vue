<template>
    <div>
        <!-- Выбор даты -->
        <div class="d-flex flex-row align-items-center mt-3">
            <span class="me-1">{{dateFilter}}</span>
            <date-picker v-model="today" format="YYYY-MM-DD" type="format" valueType="date"></date-picker>
        </div>

        <!-- Выбор ресторана -->
        <div class="ml-auto my-3">
            <span>Вы выбрали ресторан на </span>
            <select v-model="place" name="places" @change="choosePlace($event)" :style="{height: '30px'}">
                <option value="" selected>...</option>
                <option value="place_1">Марата</option>
                <option value="place_2">Байкальской</option>
                <option value="place_3">Горной</option>
            </select>
        </div>

        <!-- Выбор действия -->
        <div class="btn-group btn-group-lg d-flex mb-3" role="group" aria-label="Basic radio toggle button group">

                <input type="radio" value="changeLayout" v-model="actionType" class="btn-check" id="changeLayout">
                <label class="btn btn-outline-primary" for="changeLayout">Изменить порядок</label>

                <input type="radio" value="addGuest" v-model="actionType" class="btn-check" id="forAddGuest">
                <label class="btn btn-outline-success" for="forAddGuest">Добавить посетителя</label>

                <input type="radio" value="addTable" v-model="actionType" data-bs-toggle="modal" data-bs-target="#AddOneTable" class="btn-check" id="addTable">
                <label class="btn btn-outline-info" for="addTable">Добавить стол</label>

                <input type="radio" value="removeTable" v-model="actionType" class="btn-check" id="removeTable">
                <label class="btn btn-outline-danger" for="removeTable">Удалить стол</label>

                <input type="radio" value="waitingList" v-model="actionType" data-bs-toggle="modal" data-bs-target="#waitingList" class="btn-check" id="waitingListButton" @click="fetchWaitingList">
                <label class="btn btn-outline-warning" for="waitingListButton">Лист ожидания</label>
        </div>

        <h1 v-if="place === ''" class="text-center my-5">Пожалуйста, выберите ресторан</h1>

        <!-- Лоадер -->
        <div class="text-center" v-if="loading">
            <div class="spinner-grow mt-5 text-success" style="width: 6rem; height: 6rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Схема столов + вывод бронирования -->
        <div v-else-if="layout !== []">
            <grid-layout
                :layout.sync="layout"
                :col-num="12"
                :row-height="30"
                :is-draggable="true"
                :is-resizable="false"
                :is-mirrored="false"
                :vertical-compact="false"
                :margin="[10, 10]"
                :use-css-transforms="true"
            >

                    <grid-item v-for="item in tables" :style="{backgroundColor: '#3E2C41', touchAction: 'none', borderRadius: '10px'}"
                               :x="item.x"
                               :y="item.y"
                               :w="item.w"
                               :h="item.h"
                               :i="item.i"
                               :key="item.i"
                               drag-allow-from=".vue-draggable-handle"
                               drag-ignore-from=".no-drag"
                    >
                        <div class="text" >
                            <div v-if="actionType === 'changeLayout'" >
                                <button class="vue-draggable-handle" type="button" @mouseup="updateLayout(item)">=</button>
                            </div>
                            <div v-if="actionType === 'addGuest'">
                                <button type="button" class="btn btn-light btn-sm add_guest"
                                        data-bs-toggle="modal" data-bs-target="#AddGuest"
                                        @click="chooseTable(item)"
                                >
                                    +
                                </button>
                            </div>
                            <div v-if="actionType === 'removeTable'">
                                <button type="button" class="btn btn-light btn-sm delete_table"
                                        data-bs-toggle="modal" data-bs-target="#DeleteTable"
                                        @click="chooseTable(item)"
                                >
                                    -
                                </button>
                            </div>
                            <div class="no-drag text-center">
                                <span :style="{color: 'white'}">{{Number(item.i) === 0 ? null : Number(item.i)}}</span>
                                <img v-if="item.bbq" :src="require('../../svg/bbq.svg').default" alt="bbq" :style="{width: '25px'}">
                                <br/>
                            </div>
                        </div>

                        <div v-for="(item, idx) in item.reservations" :key="idx" :style="{margin: '0', padding: '0'}">
                            <li v-if="new Date(item.date).getDate() === today.getDate()" @click="updateGuestInfo(item)" data-bs-toggle="modal" data-bs-target="#updateGuestInfo"
                                :style="{listStyle: 'none', padding: '0', margin: '0', backgroundColor: colorByTime(item.time), color: '', fontSize: '9px', cursor: 'pointer', borderBottom: '1px solid black'}">

                                <img v-if="!item.prepayment" :src="require('../../svg/no.svg').default" alt="Ruble" :style="{width: '15px'}">
                                <img v-if="item.prepayment" :src="require('../../svg/ruble.svg').default" alt="Ruble" :style="{width: '15px'}">

                                <span class="align-middle">
                                        <b>{{item.time }}. {{item.name}} [{{item.amount}}] | {{item.note}}</b>
                                    </span>

                            </li>
                        </div>
                    </grid-item>
            </grid-layout>
        </div>


        <!-- Модалка для добавления гостя -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="AddGuest" tabindex="-1" aria-labelledby="addGuestModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGuestModal">Форма бронирования</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guestNameAdd" class="form-label" >Имя</label>
                            <input v-model="reservation.name" type="text" class="form-control" id="guestNameAdd" placeholder="Иван Иванов">
                        </div>
                        <div class="mb-3">
                            <label for="guestPhoneAdd" class="form-label" >Телефон</label>
                            <input  v-model="reservation.phone" type="text" class="form-control" id="guestPhoneAdd" placeholder="+7(xxx)xxx-xx-xx">
                        </div>
                        <div class="mb-3">
                            <label for="guestPrepaymentAdd" class="form-label">Предоплата</label>
                            <input v-model="reservation.prepayment" type="number" class="form-control" id="guestPrepaymentAdd" placeholder="Сумма предоплаты">
                        </div>
                        <div class="mb-3">
                            <label for="guestNoteAdd" class="form-label" >Дополнительная информация</label>
                            <input v-model="reservation.note" type="text" class="form-control" id="guestNoteAdd" placeholder="На заметку">
                        </div>
                        <div class="mb-3">
                            <span>Количество гостей</span>
                            <select v-model="reservation.amount" @change="reservation.amount = $event.target.value" :style="{width: '50px'}">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <span>№ стола</span>
                            <select v-model="reservation.table_id" @change="reservation.table_id = $event.target.value">
                                <option v-for="table in layout" :value="table.id" :key="table.id" selected>{{table.i}}</option>
                            </select>
                        </div>
                        <date-picker v-model="reservation.date" format="YYYY-MM-DD" type="date" valueType="format"></date-picker>
                        <date-picker
                            v-model="reservation.time"
                            :minute-step="30"
                            :hour-options="hours"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="HH:mm"
                        ></date-picker>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="() => addGuest()" data-bs-dismiss="modal">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для обновления инфо гостя -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="updateGuestInfo" tabindex="-1" aria-labelledby="updateGuestInfoModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateGuestModal">Форма обновления бронирования</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="() => clearReservationInfo()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guestNameUpdate" class="form-label" >Guest name</label>
                            <input v-model="reservation.name" type="text" class="form-control" id="guestNameUpdate" placeholder="Brad Pitt">
                        </div>
                        <div class="mb-3">
                            <label for="guestPhoneUpdate" class="form-label" >Phone number</label>
                            <input  v-model="reservation.phone" type="number" class="form-control" id="guestPhoneUpdate" placeholder="+7(xxx)xxx-xx-xx">
                        </div>
                        <div class="mb-3">
                            <label for="guestPrepaymentUpdate" class="form-label">Предоплата</label>
                            <input v-model="reservation.prepayment" type="number" class="form-control" id="guestPrepaymentUpdate" placeholder="Сумма предоплаты">
                        </div>
                        <div class="mb-3">
                            <label for="guestNoteUpdate" class="form-label" >Note</label>
                            <input  v-model="reservation.note" type="text" class="form-control" id="guestNoteUpdate" placeholder="Important information">
                        </div>
                        <div class="mb-3">
                            <span>Количество гостей</span>
                            <select v-model="reservation.amount" @change="reservation.amount = $event.target.value">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="6+">Больше 6</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <span>№ стола</span>
                            <select v-model="reservation.table_id" @change="reservation.table_id = $event.target.value">
                                <option v-for="table in layout" :value="table.id" :key="table.id">{{table.i}}</option>
                            </select>
                        </div>
                        <date-picker v-model="reservation.date" format="YYYY-MM-DD" type="date" valueType="format"></date-picker>
                        <date-picker
                            v-model="reservation.time"
                            :minute-step="30"
                            :hour-options="hours"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="HH:mm"
                        ></date-picker>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-danger" data-bs-dismiss="modal" @click="() => deleteGuest()">Удалить гостя</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="() => clearReservationInfo()">Закрыть</button>
                        <button type="button" class="btn btn-primary" @click="() => updateGuest()" data-bs-dismiss="modal">Обновить инфо</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для отображения гостей в ожидании -->
        <div class="modal fade" id="waitingList" aria-hidden="true" aria-labelledby="waitingList" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="waitingListTitle">Лист ожидания</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul v-if="waitingList !== []" :style="{margin: '0px', padding: '0px'}">
                            <li v-for="item in waitingList.reservations"
                                :style="{listStyle: 'none', padding: '0', margin: '0', backgroundColor: colorByTime(item.time), color: '', fontSize: '12px', cursor: 'pointer', borderBottom: '1px solid black'}"
                                @click="updateGuestInfo(item)"
                                data-bs-toggle="modal" data-bs-target="#updateGuestInfo"
                            >
                                {{item.created_at ? getExactTime(new Date(item.created_at)) : null }}. {{item.name}} [{{item.amount}}] | {{item.note}}
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#sendToWaitingList" data-bs-toggle="modal" data-bs-dismiss="modal">Добавить в очередь</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для листа ожидания -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="sendToWaitingList" tabindex="-1" aria-labelledby="sendToWaitingList" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendToWaitingListTitle">Лист ожидания</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="() => clearReservationInfo()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guestName" class="form-label" >Guest name</label>
                            <input v-model="reservation.name" type="text" class="form-control" id="guestName" placeholder="Brad Pitt">
                        </div>
                        <div class="mb-3">
                            <label for="guestPhone" class="form-label" >Phone number</label>
                            <input  v-model="reservation.phone" type="number" class="form-control" id="guestPhone" placeholder="+7(xxx)xxx-xx-xx">
                        </div>
                        <div class="mb-3">
                            <label for="guestPrepayment" class="form-label" >Предоплата</label>
                            <input v-model="reservation.prepayment" type="number" class="form-control"  id="guestPrepayment">
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label" >Note</label>
                            <input  v-model="reservation.note" type="text" class="form-control" id="note" placeholder="Important information">
                        </div>
                        <div class="mb-3">
                            <span>Количество гостей</span>
                            <select v-model="reservation.amount" @change="reservation.amount = $event.target.value">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="6+">Больше 6</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <span>№ стола</span>
                            <select v-model="reservation.table_id" @change="reservation.table_id = $event.target.value">
                                <option v-for="table in layout" :value="table.id" :key="table.id">{{table.i}}</option>
                            </select>
                        </div>
                        <date-picker v-model="reservation.date" format="YYYY-MM-DD" type="date" valueType="format"></date-picker>
                        <date-picker
                            v-model="reservation.time"
                            :minute-step="30"
                            :hour-options="hours"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="HH:mm"
                        ></date-picker>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="() => clearReservationInfo()">Закрыть</button>
                        <button type="button" class="btn btn-primary" @click="() => addToWaitingList()" data-bs-dismiss="modal">Добавить в ожидание</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для добавления стола-->
        <div class="modal fade" id="AddOneTable" tabindex="-1" aria-labelledby="addTableModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTableModal">Do you want to add a table?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="addTable(false)">Add a table</button>
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal" @click="addTable(true)">Add a table with BBQ</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для удаления стола -->
        <div class="modal fade" id="DeleteTable" tabindex="-1" aria-labelledby="DeleteTableModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DeleteTableModal">Are you sure you want to delete a table?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="deleteOneTable()">Delete a table</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
import VueGridLayout from 'vue-grid-layout';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    name: "Booking",
    components: {
        GridLayout: VueGridLayout.GridLayout,
        GridItem: VueGridLayout.GridItem,
        DatePicker,
    },
    data() {
        return {
            place: '',
            actionType: '',
            today: new Date(),
            layout: [],
            waitingList: [],
            logs: [],
            colors: ['#FFFF8F', '#19DF01', '#FE6126'],
            loading: true,
            error: null,
            showModal: false,
            table: null,
            hours: Array.from({ length: 23 }).map((_, i) => i + 9),
            reservation: {
                name: '',
                phone: '',
                note: '',
                prepayment: 0,
                amount: 1,
                date: new Date(),
                time: null,
                table: null,
                place_id: null
            }
        }
    },
    async mounted() {
        this.loading = false;
    },
    computed: {
        tables() {
            if(this.place === 'place_1') {
                return this.layout.filter(table => table.id !== 100)
            }
            if(this.place === 'place_2') {
                return this.layout.filter(table => table.id !== 101)
            }
            if(this.place === 'place_3') {
                return this.layout.filter(table => table.id !== 102)
            }
        },
        dateFilter() {
            const options = {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            };
            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
            return capitalizeFirstLetter(Intl.DateTimeFormat('ru-RU', options).format(this.today));
        },
    },
    methods: {
        addLeadingZero(date) {
            return (date < 10) ? '0' + date : date;
        },
        getUserTime(date) {
            const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
            let Y = date.getFullYear();
            let M = this.addLeadingZero(date.getMonth() + 1);
            let D = this.addLeadingZero(date.getDate());
            let d = days[date.getDay()];
            let h = this.addLeadingZero(date.getHours());
            let m = this.addLeadingZero(date.getMinutes());

            return `${Y}.${M}.${D} ${h}:${m} (${d})`
        },
        getExactTime(date) {
          return new Date(date).getHours() + ':' + new Date(date).getMinutes()
        },
        colorByTime(value) {
            const newValue = value.slice(0,2);
            if(newValue >= 9 && newValue < 12) {
                return '#FFFF8F';
            }
            if(newValue >= 12 && newValue < 17) {
                return '#19DF01';
            }
            if(newValue >= 17) {
                return '#FE6126';
            }
        },
        choosePlace(event) {
            // СМОТРИ: event.target.value - это value в конкретной опции
            this.place = event.target.value;
            this.fetchTables();
        },
        chooseTable(item) {
            this.reservation.table_id = item.id;
            this.table = item.id;
        },
        clearReservationInfo() {
            this.reservation = {
                    id: null,
                    name: '',
                    phone: '',
                    note: '',
                    prepayment: false,
                    amount: null,
                    date: null,
                    time: null,
                    table: null,
                    place_id: null
                }
        },
        updateGuestInfo(item) {
            console.log(item);
            this.reservation = {
                id: item.id,
                name: item.name,
                phone: item.phone,
                note: item.note,
                prepayment: item.prepayment,
                amount: item.amount,
                date: item.date,
                time: item.time,
                table_id: item.table_id,
                place_id: item.place_id
            }
        },
        async fetchLogs() {
            this.layout = null;
            this.loading = true;
            const response = await axios.get('http://127.0.0.1:8000/api/logs')
            console.log(response.data);
            this.logs = response.data
            this.loading = false;
            console.log(this.logs[0].created_at)
        },
        async fetchTables() {
            switch (this.place) {
                case "place_1" :
                    try {
                        this.loading = true;
                        const response = await axios.get('http://127.0.0.1:8000/api/tables')
                        this.layout = response.data.data.filter((table) => {
                            if(table.place_id === 1) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.error = error;
                    }
                    break;
                case "place_2" :
                    try {
                        this.loading = true;
                        const response = await axios.get('http://127.0.0.1:8000/api/tables')
                        this.layout = response.data.data.filter((table) => {
                            if(table.place_id === 2) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.error = error;
                    }
                    break;
                case "place_3" :
                    try {
                        this.loading = true;
                        const response = await axios.get('http://127.0.0.1:8000/api/tables')
                        this.layout = response.data.data.filter((table) => {
                            if(table.place_id === 3) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.error = error;
                    }
                    break;
                default:
                    console.log('Default message')
            }
        },
        async updateLayout(item) {
            if(this.place === 'place_1') {
                try {
                    await axios.put(`http://127.0.0.1:8000/api/tables/${item.id}`, item);
                    const newLog = {
                        text: `Стол №${newReservation.table_id} был забронирован`,
                        type: 'Расположение',
                        ...item
                    }
                    await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
                } catch (error) {
                    this.error = error;
                }
            }
            if(this.place === 'place_2') {
                try {
                    await axios.put(`http://127.0.0.1:8000/api/tables/${item.id}`, item);
                    const newLog = {
                        text: `Стол №${newReservation.table_id} был забронирован`,
                        type: 'Расположение',
                        ...item
                    }
                    await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
                } catch (error) {
                    this.error = error;
                }
            }
            if(this.place === 'place_3') {
                try {
                    await axios.put(`http://127.0.0.1:8000/api/tables/${item.id}`, item);
                    const newLog = {
                        text: `Стол №${newReservation.table_id} был забронирован`,
                        type: 'Расположение',
                        ...item
                    }
                    await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
                } catch (error) {
                    console.log(error)
                }
            }
        },
        async addGuest() {
            if(this.place === 'place_1') {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    prepayment: this.reservation.prepayment,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    date: this.reservation.date,
                    time: this.reservation.time,
                    table_id: this.table,
                    place_id: 1
                }
                await axios.post(`http://127.0.0.1:8000/api/reservations`, newReservation)
                const newLog = {
                    text: `Стол №${newReservation.table_id} был забронирован.`,
                    type: 'Бронирование',
                    ...newReservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            if(this.place === 'place_2') {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    prepayment: this.reservation.prepayment,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    date: this.reservation.date,
                    time: this.reservation.time,
                    table_id: this.table,
                    place_id: 2
                }
                await axios.post(`http://127.0.0.1:8000/api/reservations`, newReservation)
                const newLog = {
                    text: `Стол №${newReservation.table_id} на Байкальской был забронирован.`,
                    type: 'Бронирование',
                    ...newReservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)

            }
            if(this.place === 'place_3') {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    prepayment: this.reservation.prepayment,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    date: this.reservation.date,
                    time: this.reservation.time,
                    table_id: this.table,
                    place_id: 3
                }
                await axios.post(`http://127.0.0.1:8000/api/reservations`, newReservation)
                const newLog = {
                    text: `Стол №${newReservation.table_id} на Байкальской был забронирован.`,
                    type: 'Бронирование',
                    ...newReservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async updateGuest() {
            if(this.place === 'place_1') {
                await axios.put(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`, this.reservation)
                const newLog = {
                    text: `Обновлены данные гостя.`,
                    type: 'Обновление данных',
                    ...this.reservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            if(this.place === 'place_2') {
                await axios.put(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`, this.reservation)
                const newLog = {
                    text: `Обновлены данные гостя.`,
                    type: 'Обновление данных',
                    ...this.reservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            if(this.place === 'place_3') {
                await axios.put(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`, this.reservation)
                const newLog = {
                    text: `Обновлены данные гостя.`,
                    type: 'Обновление данных',
                    ...this.reservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async fetchWaitingList() {
            if(this.place === 'place_1') {
                const response = await axios.get('http://127.0.0.1:8000/api/tables')
                this.waitingList = response.data.data.find(table => {
                    if(table.id === 100) {
                        return table;
                    }
                })
            }
            console.log(this.waitingList);
        },
        async addToWaitingList() {
            if(this.place === 'place_1') {
                const waitingGuest = {
                    ...this.reservation,
                    place_id: 1,
                    table_id: 100
                }
                await axios.post(`http://127.0.0.1:8000/api/reservations`, waitingGuest)
            }
            if(this.place === 'place_2') {
                const waitingGuest = {
                    ...this.reservation,
                    place_id: 2,
                }
                await axios.post(`http://127.0.0.1:8000/api/waiting`, waitingGuest)
            }
            if(this.place === 'place_3') {
                const waitingGuest = {
                    ...this.reservation,
                    place_id: 3,
                }
                await axios.post(`http://127.0.0.1:8000/api/waiting`, waitingGuest)
            }
            this.clearReservationInfo();
        },
        async deleteGuest() {
            await axios.delete(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`)
            const newLog = {
                text: 'Гость был удален.',
                type: 'Отмена бронирования',
                ...this.reservation
            }
            await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            await this.fetchTables();
        },
        async addTable(type) {
            const response = await axios.get('http://127.0.0.1:8000/api/tables')

            if(this.place === 'place_1') {
                try {
                    const firstLayout = response.data.data.filter((table) => {
                        if(table.place_id === 1) {
                            return table;
                        }
                    })
                    const newTable = {
                            w: 2,
                            place_id: 1,
                            h: 3,
                            x: 9,
                            y: 9,
                            i: (firstLayout.length + 1).toString(),
                            bbq: type,
                            slug: (firstLayout.length + 1).toString()
                        }
                    await axios.post('http://127.0.0.1:8000/api/tables', newTable)
                } catch (error) {
                    console.log(error.message)
                }
            }
            if(this.place === 'place_2') {
                try {
                    const secondLayout = response.data.data.filter((table) => {
                        if(table.place_id === 2) {
                            return table;
                        }
                    })
                    const newTable = {
                        w: 2,
                        place_id: 2,
                        h: 3,
                        x: 9,
                        y: 9,
                        i: (secondLayout.length + 1).toString(),
                        bbq: type,
                        slug: (secondLayout.length + 1).toString()
                    }
                    await axios.post('http://127.0.0.1:8000/api/tables', newTable)
                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === 'place_3') {
                try {
                    const thirdLayout = response.data.data.filter((table) => {
                        if(table.place_id === 3) {
                            return table;
                        }
                    })
                    const newTable = {
                        w: 2,
                        place_id: 3,
                        h: 3,
                        x: 9,
                        y: 9,
                        i: (thirdLayout.length + 1).toString(),
                        bbq: type,
                        slug: (thirdLayout.length + 1).toString()
                    }
                    await axios.post('http://127.0.0.1:8000/api/tables', newTable)
                } catch (error) {
                    console.log(error)
                }
            }

            this.loading = true;
            await this.fetchTables();
            this.loading = false;
        },
        async deleteOneTable() {
            if(this.place === "place_1") {
                try {
                    const table = await axios.get(`http://127.0.0.1:8000/api/tables/${this.table}`)
                    await axios.delete(`http://127.0.0.1:8000/api/tables/${this.table}`)
                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === "place_2") {
                try {
                    await axios.delete(`http://127.0.0.1:8000/api/tables/${this.table}`)
                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === "place_3") {
                try {
                    await axios.delete(`http://127.0.0.1:8000/api/tables/${this.table}`)
                } catch (error) {
                    console.log(error)
                }
            }
            this.loading = true;
            await this.fetchTables();
            this.loading = false;
        }
    },
}
</script>

<style scoped>
.vue-draggable-handle {
    position: absolute;
    width: 20px;
    /*height: 20px;*/
    top: 0;
    right: 0;
    /*padding: 0 8px 8px 0;*/
    padding: 0;
    background-origin: content-box;
    background-color: #757575;
    box-sizing: border-box;
    border-radius: 5px;
    cursor: pointer;
}
.add_guest {
    position: absolute;
    width: 20px;
    /*height: 20px;*/
    top: 0;
    right: 0;
    padding: 0;
    background-origin: content-box;
    background-color: white;
    box-sizing: border-box;
    /*border-radius: 5px;*/
    cursor: pointer;
}
.delete_table {
    position: absolute;
    width: 20px;
    top: 0;
    right: 0;
    padding: 0;
    background-origin: content-box;
    background-color: white;
    box-sizing: border-box;
    /*border-radius: 5px;*/
    cursor: pointer;
}
</style>

