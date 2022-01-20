<template>
    <div>
        <!-- Сделать стилизацию этого блока. Добавить читабельности и выделить опции. -->
        <div class="ml-auto my-3">
            <span>Вы выбрали ресторан на </span>
            <select v-model="place" name="places" @change="choosePlace($event)">
                <option value="" selected>...</option>
                <option value="place_1">Марата</option>
                <option value="place_2">Байкальской</option>
                <option value="place_3">Горной</option>
            </select>
        </div>

        <!-- 13.01. 12:11. Сделал радиокнопки для действий -->
        <div class="btn-group btn-group-lg d-flex mb-3" role="group" aria-label="Basic radio toggle button group">

                <input type="radio" value="changeLayout" v-model="actionType" class="btn-check" id="changeLayout">
                <label class="btn btn-outline-primary" for="changeLayout">Изменить порядок</label>

                <input type="radio" value="addGuest" v-model="actionType" class="btn-check" id="forAddGuest">
                <label class="btn btn-outline-success" for="forAddGuest">Добавить посетителя</label>

                <input type="radio" value="addTable" v-model="actionType" data-bs-toggle="modal" data-bs-target="#AddOneTable" class="btn-check" id="addTable">
                <label class="btn btn-outline-secondary" for="addTable">Добавить стол</label>

                <input type="radio" value="removeTable" v-model="actionType" class="btn-check" id="removeTable">
                <label class="btn btn-outline-danger" for="removeTable">Удалить стол</label>

                <input type="radio" value="waitingList" v-model="actionType" class="btn-check" id="waitingList">
                <label class="btn btn-outline-warning" for="waitingList">Лист ожидания</label>

                <input type="radio" value="history" v-model="actionType" class="btn-check" id="history" @click="fetchLogs">
                <label class="btn btn-outline-info" for="history">История</label>
        </div>

        <h1 v-if="place === ''" class="text-center my-5">Пожалуйста, выберите ресторан</h1>

        <!-- Loader -->
        <div class="text-center" v-if="loading">
            <div class="spinner-grow mt-5 text-success" style="width: 6rem; height: 6rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Layout of tables -->
        <div v-else-if="!loading && layout !== null">
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
                    <grid-item v-for="item in layout" :style="{backgroundColor: '#3E2C41', touchAction: 'none', borderRadius: '10px'}"
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
                                <span :style="{color: 'white'}">{{Number(item.i)}}</span>
                                <br/>
                            </div>
                        </div>
                        <!-- 17.01. Добавил вывод бронирования по столам + обновление и удаление брони -->
                        <!-- 18.01. Добавил вывод по сегодняшней дате -->
                        <!-- 19.01. Добавил выделение цветом по времени суток -->
                            <div v-for="(item, idx) in item.reservations" :key="idx" :style="{margin: '0', padding: '0'}">
                                <li v-if="new Date(item.date).getDate() === today.getDate()" @click="updateGuestInfo(item)" data-bs-toggle="modal" data-bs-target="#updateGuestInfo"
                                    :style="{listStyle: 'none', padding: '0', margin: '0', backgroundColor: colorByTime(item.time), color: '', fontSize: '9px', cursor: 'pointer', borderBottom: '1px solid black'}">

                                    <img v-if="!item.prepayment" :src="require('../../svg/no.svg').default" alt="Ruble" :style="{width: '15px'}">
                                    <img v-if="item.prepayment" :src="require('../../svg/ruble.svg').default" alt="Ruble" :style="{width: '15px'}">


                                    <span class="align-middle">{{item.time }}. {{item.name}} [{{item.amount}}] | {{item.note}}</span>

                                </li>
                            </div>
                    </grid-item>
            </grid-layout>
        </div>

        <div v-else-if="logs !== null">
            <ul class="list-group">
                <li v-for="log in logs" class="list-group-item">
                    <span v-for="item in log">{{item.created_at}}</span>
                </li>
            </ul>
        </div>

        <!-- Modal for adding a guest -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="AddGuest" tabindex="-1" aria-labelledby="addGuestModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGuestModal">Форма бронирования</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guestName" class="form-label" >Имя</label>
                            <input v-model="reservation.name" type="text" class="form-control" id="guestName" placeholder="Иван Иванов">
                        </div>
                        <div class="mb-3">
                            <label for="guestPhone" class="form-label" >Телефон</label>
                            <input  v-model="reservation.phone" type="number" class="form-control" id="guestPhone" placeholder="+7(xxx)xxx-xx-xx">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input v-model="reservation.prepayment" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Предоплата</label>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label" >Дополнительная информация</label>
                            <input  v-model="reservation.note" type="text" class="form-control" id="note" placeholder="На заметку">
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
        <!-- Modal for updating / deleting a guest       -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="updateGuestInfo" tabindex="-1" aria-labelledby="updateGuestInfoModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateGuestModal">Форма обновления бронирования</h5>
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
                        <div class="form-check form-switch mb-3">
                            <input v-model="reservation.prepayment" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Предоплата</label>
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
                        <button type="button" class="btn btn-secondary btn-danger" data-bs-dismiss="modal" @click="() => deleteGuest()">Удалить гостя</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="() => clearReservationInfo()">Закрыть</button>
                        <button type="button" class="btn btn-primary" @click="() => updateGuest()" data-bs-dismiss="modal">Обновить инфо</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vertical modal for adding a table-->
        <div class="modal fade" id="AddOneTable" tabindex="-1" aria-labelledby="addTableModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTableModal">Do you want to add a table?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="addTable">Add a table</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for deleting a table -->
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
            logs: [],
            colors: ['#FFFF8F', '#19DF01', '#FE6126'],
            loading: true,
            error: null,
            showModal: false,
            table: null,
            hours: Array.from({ length: 23 }).map((_, i) => i + 9),
            reservation: {
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
        }
    },
    async mounted() {
        this.loading = false;
    },
    computed: {
        // orderDate() {
        //     const [reservations] = this.layout;
        //     return this.layout.sort((a,b) => new Date(reservations.date) - new Date(reservations.date))
        // }
    },
    methods: {
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
        // logAction(text, type, info, date = new Date()) {
        //     return {
        //         text, type, date, info
        //     }
        // },
        async fetchLogs() {
            this.layout = null;
            this.loading = true;
            const response = await axios.get('http://127.0.0.1:8000/api/logs')
            console.log(response.data);
            this.logs = response.data
            this.loading = false;
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
                    this.logs.push(this.logAction(`Стол #${item.i} на Марата был передвинут`, 'Расстановка столов'))
                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === 'place_2') {
                try {
                    await axios.put(`http://127.0.0.1:8000/api/tables/${item.id}`, item);
                    this.logs.push(this.logAction(`Стол #${item.i} на Байкальской был передвинут`, 'Расстановка столов'))
                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === 'place_3') {
                try {
                    await axios.put(`http://127.0.0.1:8000/api/tables/${item.id}`, item);
                    this.logs.push(this.logAction(`Стол #${item.i} на Горной был передвинут`, 'Расстановка столов'))
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
                    text: `Стол ${newReservation.table_id} был забронирован`,
                    type: 'Бронирование',
                    ...newReservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
                this.reservation = {
                    name: '',
                    phone: '',
                    note: '',
                    date: null,
                    time: null,
                    table: null,
                    layout_id: null
                }
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
                    text: `Стол ${newReservation.table_id} на Байкальской был забронирован`,
                    type: 'Бронирование',
                    ...newReservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
                this.reservation = {
                    name: '',
                    phone: '',
                    note: '',
                    date: null,
                    time: null,
                    table: null,
                    layout_id: null
                }
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
                    text: `Стол ${newReservation.table_id} на Байкальской был забронирован`,
                    type: 'Бронирование',
                    ...newReservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
                this.reservation = {
                    name: '',
                    phone: '',
                    note: '',
                    date: null,
                    time: null,
                    table: null,
                    layout_id: null
                }
            }
            await this.fetchTables();
        },
        async updateGuest() {
            if(this.place === 'place_1') {
                await axios.put(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`, this.reservation)
                const newLog = {
                    text: `Обновлены данные гостя`,
                    type: 'Обновление данных',
                    ...this.reservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            if(this.place === 'place_2') {
                await axios.put(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`, this.reservation)
                const newLog = {
                    text: `Обновлены данные гостя`,
                    type: 'Обновление данных',
                    ...this.reservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            if(this.place === 'place_3') {
                await axios.put(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`, this.reservation)
                const newLog = {
                    text: `Обновлены данные гостя`,
                    type: 'Обновление данных',
                    ...this.reservation
                }
                await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            }
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async deleteGuest() {
            await axios.delete(`http://127.0.0.1:8000/api/reservations/${this.reservation.id}`)
            const newLog = {
                text: 'Гость был удален',
                type: 'Отмена бронирования',
                ...this.reservation
            }
            await axios.post(`http://127.0.0.1:8000/api/logs`, newLog)
            await this.fetchTables();
        },
        async addTable() {
            if(this.place === 'place_1') {
                try {
                    const response = await axios.get('http://127.0.0.1:8000/api/tables')
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
                        slug: (firstLayout.length + 1).toString()
                    }
                    await axios.post('http://127.0.0.1:8000/api/tables', newTable)
                    this.loading = true;
                    await this.fetchTables();
                    this.loading = false;
                    this.logs.push(this.logAction(`Стол #${newTable.i} на Марата был добавлен`, 'Добавление столов'))
                    console.log(this.logs);

                } catch (error) {
                    console.log(error.message)
                }
            }
            if(this.place === 'place_2') {
                try {
                    const response = await axios.get('http://127.0.0.1:8000/api/tables')
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
                        slug: (secondLayout.length + 1).toString()
                    }
                    await axios.post('http://127.0.0.1:8000/api/tables', newTable)
                    this.loading = true;
                    await this.fetchTables();
                    this.loading = false;
                    this.logs.push(this.logAction(`Стол #${newTable.i} на Байкальской был добавлен`, 'Добавление столов'))

                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === 'place_3') {
                try {
                    const response = await axios.get('http://127.0.0.1:8000/api/tables')
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
                        slug: (thirdLayout.length + 1).toString()
                    }
                    await axios.post('http://127.0.0.1:8000/api/tables', newTable)
                    this.loading = true;
                    await this.fetchTables();
                    this.loading = false;
                    this.logs.push(this.logAction(`Стол #${newTable.i} на Горной был добавлен`, 'Добавление столов'))

                } catch (error) {
                    console.log(error)
                }
            }
        },
        async deleteOneTable() {
            if(this.place === "place_1") {
                try {
                    await axios.delete(`http://127.0.0.1:8000/api/tables/${this.table}`)
                    this.loading = true;
                    await this.fetchTables();
                    this.loading = false;
                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === "place_2") {
                try {
                    await axios.delete(`http://127.0.0.1:8000/api/tables/${this.table}`)
                    this.loading = true;
                    await this.fetchTables();
                    this.loading = false;
                } catch (error) {
                    console.log(error)
                }
            }
            if(this.place === "place_3") {
                try {
                    await axios.delete(`http://127.0.0.1:8000/api/tables/${this.table}`)
                    this.loading = true;
                    await this.fetchTables();
                    this.loading = false;
                } catch (error) {
                    console.log(error)
                }
            }
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

