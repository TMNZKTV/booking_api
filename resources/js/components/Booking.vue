<template>
    <div>
        <div class="px-4 py-3 mb-5" :style="{ backgroundColor: '#eef1f4' }">
            <div class="row">
                <div class="xs col-12 col-sm-4 col-md-6 mb-2">
                    <!-- Календарь -->
                    <div class="row">
                        <div class="col-sm-10 col-md-5 col-lg-5">
                            <div
                                class="card col-md card_md col-lg-6 border border-4"
                            >
                                <div
                                    class="card-body card_content_info text-center"
                                >
                                    <p class="day_full m-0">
                                        {{ dayFilter }}
                                    </p>

                                    <p class="date_full m-0">
                                        {{ dateFilter }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="date_full_mobile">
                                    <b>{{ dateFilter }}</b>
                                </p>
                            </div>
                        </div>

                        <!-- Дата и Ресторан-->
                        <div class="date_picker_full col-sm-10 col-md-6">
                            <p class="p-0 mb-2"><b>Дата</b></p>
                            <date-picker
                                v-model="today"
                                format="YYYY-MM-DD"
                                type="format"
                                valueType="date"
                                :style="{ width: '150px' }"
                            ></date-picker>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label
                                            for="place_selector"
                                            class="place_title"
                                        >
                                            <b>Ресторан на </b>
                                        </label>
                                    </div>

                                    <div>
                                        <select
                                            class="form-control form-select w-full place_input border border-2"
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Выбор действия -->
                <div class="xs col-12 col-sm-8 col-md-6">
                    <!-- 1 ряд -->
                    <div class="row row-cols-2 g-1 mb-1">
                        <!-- Изменить расположение -->
                        <div class="col-xs-auto col-sm-4 col-md-4 col-lg-auto">
                            <div class="btn btn-outline-primary button_action">
                                <input
                                    type="radio"
                                    value="changeLayout"
                                    v-model="actionType"
                                    class="btn-check"
                                    data-bs-toggle="modal"
                                    data-bs-target="#passwordCheck"
                                    id="changeLayout"
                                />
                                <label for="changeLayout" class="py-2"
                                    >Изменить порядок</label
                                >
                            </div>
                        </div>
                        <!-- Добавить посетителя -->
                        <div class="col-xs-auto col-sm-4 col-md-4 col-lg-auto">
                            <div class="btn btn-outline-success button_action">
                                <input
                                    type="radio"
                                    value="addGuest"
                                    v-model="actionType"
                                    class="btn-check"
                                    id="forAddGuest"
                                />
                                <label for="forAddGuest" class="py-2"
                                    >Добавить посетителя</label
                                >
                            </div>
                        </div>

                        <!-- Добавить стол -->
                        <div class="col-sm-3 col-md-4 col-lg-auto">
                            <div class="btn btn-outline-info button_action">
                                <input
                                    type="radio"
                                    value="addTable"
                                    v-model="actionType"
                                    data-bs-toggle="modal"
                                    data-bs-target="#AddOneTable"
                                    class="btn-check"
                                    id="addTable"
                                />
                                <label for="addTable" class="py-2"
                                    >Добавить стол</label
                                >
                            </div>
                        </div>
                    </div>

                    <!-- 2 ряд -->
                    <div class="row row-cols-2 g-1 mb-1">
                        <!-- Добавить стол -->
                        <div class="col-sm-3 col-md-4 col-lg-auto">
                            <div class="btn btn-outline-info button_action">
                                <input
                                    type="radio"
                                    value="addTable"
                                    v-model="actionType"
                                    data-bs-toggle="modal"
                                    data-bs-target="#AddOneTable"
                                    class="btn-check"
                                    id="addTable"
                                />
                                <label for="addTable" class="py-2"
                                    >Добавить стол</label
                                >
                            </div>
                        </div>
                        <!-- Удалить стол -->
                        <div class="col-sm-3 col-md-4 col-lg-auto">
                            <div class="btn btn-outline-danger button_action">
                                <input
                                    type="radio"
                                    value="removeTable"
                                    v-model="actionType"
                                    class="btn-check"
                                    id="removeTable"
                                />
                                <label for="removeTable" class="py-2"
                                    >Удалить стол</label
                                >
                            </div>
                        </div>
                        <!-- Лист ожидания -->
                        <div class="col-sm-3 col-md-4 col-lg-auto">
                            <div class="btn btn-outline-warning button_action">
                                <input
                                    type="radio"
                                    value="waitingList"
                                    v-model="actionType"
                                    data-bs-toggle="modal"
                                    data-bs-target="#waitingList"
                                    class="btn-check"
                                    id="waitingListButton"
                                    @click="fetchWaitingList"
                                />
                                <label for="waitingListButton" class="py-2"
                                    >Лист ожидания</label
                                >
                            </div>
                        </div>
                        <!-- Ограничение по бронированию -->
                        <div class="col-sm-3 col-md-4 col-lg-auto">
                            <div class="btn btn-outline-warning button_action">
                                <input
                                    type="radio"
                                    value="addRestriction"
                                    v-model="actionType"
                                    class="btn-check"
                                    id="addRestriction"
                                />
                                <label for="addRestriction" class="py-2"
                                    >Выставить ограничение</label
                                >
                            </div>
                        </div>
                    </div>

                    <!-- 3 ряд с иконками -->
                    <div class="col-md-12 col-xl-8">
                        <div
                            class="row row-cols-2 g-1 mt-3 p-3"
                            :style="{
                                backgroundColor: 'white',
                            }"
                        >
                            <div class="col-md-5 col-5 m-0">
                                <img
                                    :src="require('../../svg/bbq.svg').default"
                                    alt="bbq"
                                    :style="{ width: '15px' }"
                                />
                                <span>Стол BBQ</span>
                            </div>

                            <div class="col-md-6 col-7 m-0">
                                <img
                                    :src="
                                        require('../../svg/ruble.svg').default
                                    "
                                    alt="Ruble"
                                    :style="{ width: '15px' }"
                                />
                                <span>Есть предоплата</span>
                            </div>
                            <div class="w-100"></div>

                            <div class="col-md-5 col-5">
                                <img
                                    :src="
                                        require('../../svg/birthday.svg')
                                            .default
                                    "
                                    alt="birthday"
                                    :style="{ width: '15px' }"
                                />
                                <span>День рождения</span>
                            </div>
                            <div class="col-md-7 col-7">
                                <img
                                    :src="
                                        require('../../svg/heart.svg').default
                                    "
                                    alt="romantic dinner"
                                    :style="{ width: '15px' }"
                                />
                                <span>Романтический ужин</span>
                            </div>
                            <div class="w-100"></div>

                            <div class="col-5 col-md-7 col-lg-5">
                                <img
                                    :src="
                                        require('../../svg/family.svg').default
                                    "
                                    alt="family dinner"
                                    :style="{ width: '15px' }"
                                />
                                <span>Семейный ужин</span>
                            </div>
                            <div class="col-md-7 col-7">
                                <img
                                    :src="
                                        require('../../svg/conflict.svg')
                                            .default
                                    "
                                    alt="conflict guest"
                                    :style="{ width: '15px' }"
                                />
                                <span>Конфликтный гость</span>
                            </div>
                            <div class="col-md-7 col-7">
                                <!-- <img
                                    :src="require('../../svg/lock.svg').default"
                                    alt="restrictions"
                                    :style="{ width: '15px' }"
                                /> -->
                                <span>Ограничения по времени</span>
                            </div>
                            <div class="w-100"></div>

                            <div class="col-4">
                                <img
                                    :src="
                                        require('../../svg/morning.svg').default
                                    "
                                    alt="morning time"
                                    :style="{ width: '15px' }"
                                />
                                <span>9-12 часов</span>
                            </div>
                            <div class="col-4">
                                <img
                                    :src="require('../../svg/day.svg').default"
                                    alt="day time"
                                    :style="{ width: '15px' }"
                                />
                                <span>12-18 часов</span>
                            </div>
                            <div class="col-4">
                                <img
                                    :src="
                                        require('../../svg/evening.svg').default
                                    "
                                    alt="evening time"
                                    :style="{ width: '15px' }"
                                />
                                <span>18-23 часов</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h1 v-if="place === ''" class="text-center my-5">
            Пожалуйста, выберите ресторан
        </h1>

        <!-- Лоадер -->
        <div class="text-center" v-if="loading">
            <div
                class="spinner-grow mt-5 text-success"
                style="width: 6rem; height: 6rem"
                role="status"
            >
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Схема столов + вывод бронирования -->
        <div v-if="layout !== [] && loading !== true" class="mt-3">
            <!-- Отключить отзывчивость -> Расположение сохраняется на всех устройствах -->
            <!-- Если включить, кол-во колонок указывается в :cols -->
            <grid-layout
                :layout.sync="layout"
                :col-num="14"
                :row-height="60"
                :is-draggable="true"
                :is-resizable="false"
                :is-mirrored="false"
                :vertical-compact="false"
                :margin="[20, 20]"
                :use-css-transforms="true"
                :responsive="false"
                :cols="{ lg: 12, md: 12, sm: 10, xs: 6, xxs: 4 }"
            >
                <grid-item
                    class="py-1"
                    v-for="item in tables"
                    :style="{
                        backgroundColor: '#3E2C41',
                        touchAction: 'none',
                        borderRadius: '10px',
                    }"
                    :x="item.x"
                    :y="item.y"
                    :w="item.w"
                    :h="item.h"
                    :i="item.i"
                    :key="item.i"
                    drag-allow-from=".vue-draggable-handle"
                    drag-ignore-from=".no-drag"
                >
                    <div class="text">
                        <!-- v-if="actionType === 'changeLayout' && admin" -->
                        <div v-if="passCheck === true">
                            <button
                                class="vue-draggable-handle"
                                type="button"
                                @click="updateLayout(item)"
                            >
                                =
                            </button>
                        </div>
                        <div v-if="actionType === 'addGuest'">
                            <button
                                type="button"
                                class="btn btn-light btn-sm add_guest"
                                data-bs-toggle="modal"
                                data-bs-target="#AddGuest"
                                @click="chooseTable(item)"
                            >
                                +
                            </button>
                        </div>
                        <div v-if="actionType === 'removeTable'">
                            <button
                                type="button"
                                class="btn btn-light btn-sm delete_table"
                                data-bs-toggle="modal"
                                data-bs-target="#DeleteTable"
                                @click="chooseTable(item)"
                            >
                                -
                            </button>
                        </div>
                        <div v-if="actionType === 'addRestriction'">
                            <button
                                type="button"
                                class="btn btn-light btn-sm add_guest"
                                data-bs-toggle="modal"
                                data-bs-target="#AddRestriction"
                                @click="chooseTable(item)"
                            >
                                !
                            </button>
                        </div>
                        <!-- Номер и иконки стола -->
                        <div class="no-drag text-center">
                            <!-- <div v-if="item.restriction">
                                <img
                                    :src="
                                        require('../../svg/lockSign.svg')
                                            .default
                                    "
                                    alt="restriction"
                                    :style="{
                                        width: '15px',
                                        paddingBottom: '3px',
                                        marginLeft: 'auto',
                                    }"
                                />
                                <span :style="{ color: 'white' }">c 16:00</span>
                            </div> -->
                            <div class="pt-1 align-middle">
                                <span
                                    :style="{
                                        color: '#FFF0F5',
                                        fontWeight: '600',
                                    }"
                                    >{{
                                        Number(item.i) === 0
                                            ? null
                                            : Number(item.i)
                                    }}</span
                                >
                                <img
                                    class="bbq_table"
                                    v-if="item.bbq"
                                    :src="
                                        require('../../svg/bbqSign.svg').default
                                    "
                                    alt="bbq"
                                    :style="{
                                        width: '15px',
                                        paddingBottom: '3px',
                                    }"
                                />
                                <br />
                            </div>
                        </div>
                    </div>
                    <!-- Вывод информации о бронированияя -->
                    <div
                        v-for="(item, idx) in item.reservations"
                        :key="idx"
                        :style="{ margin: '0', padding: '0' }"
                    >
                        <li
                            v-if="
                                new Date(item.date).getDate() ===
                                today.getDate()
                            "
                            @click="updateGuestInfo(item)"
                            data-bs-toggle="modal"
                            data-bs-target="#updateGuestInfo"
                            :style="{
                                listStyle: 'none',
                                padding: '0',
                                margin: '0',
                                backgroundColor: colorByTime(item.time),
                                color: '',
                                fontSize: '9px',
                                cursor: 'pointer',
                                borderBottom: '1px solid black',
                            }"
                        >
                            <div :style="{ padding: '1px' }">
                                <!-- Иконка предоплаты -->
                                <img
                                    v-if="item.prepayment"
                                    :src="
                                        require('../../svg/ruble.svg').default
                                    "
                                    alt="Ruble"
                                    :style="{ width: '15px' }"
                                />
                                <!-- Тип визита -->
                                <img
                                    v-if="item.visit_type === 'День рождения'"
                                    :src="
                                        require('../../svg/birthday.svg')
                                            .default
                                    "
                                    alt="Birthday cake"
                                    :style="{ width: '15px' }"
                                />
                                <img
                                    v-if="
                                        item.visit_type === 'Романтический ужин'
                                    "
                                    :src="
                                        require('../../svg/heart.svg').default
                                    "
                                    alt="Heart"
                                    :style="{ width: '15px' }"
                                />
                                <img
                                    v-if="item.visit_type === 'Семейный ужин'"
                                    :src="
                                        require('../../svg/family.svg').default
                                    "
                                    alt="Family"
                                    :style="{ width: '15px' }"
                                />
                                <!-- Конфликтный гость -->
                                <img
                                    v-if="item.conflict"
                                    :src="
                                        require('../../svg/conflict.svg')
                                            .default
                                    "
                                    alt="Warning!"
                                    :style="{ width: '15px' }"
                                />
                                <span class="align-middle">
                                    <b
                                        >{{ item.time }}. {{ item.name }} [{{
                                            item.amount
                                        }}]
                                    </b>
                                </span>
                            </div>
                        </li>
                    </div>
                </grid-item>
            </grid-layout>
        </div>

        <!-- Модалка для добавления гостя -->
        <div
            class="modal fade"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            id="AddGuest"
            tabindex="-1"
            aria-labelledby="addGuestModal"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGuestModal">
                            Форма бронирования
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <!-- Имя и Телефон -->
                        <div class="row">
                            <!-- Имя -->
                            <div class="mb-3 col-6">
                                <label for="guestNameAdd" class="form-label"
                                    >Имя</label
                                >
                                <input
                                    v-model="reservation.name"
                                    type="text"
                                    class="form-control"
                                    id="guestNameAdd"
                                    placeholder="Иван Иванов"
                                />
                            </div>
                            <!-- Телефон -->
                            <div class="mb-3 col-6">
                                <label for="guestPhoneAdd" class="form-label"
                                    >Телефон</label
                                >
                                <input
                                    v-model="reservation.phone"
                                    type="text"
                                    class="form-control"
                                    id="guestPhoneAdd"
                                    placeholder="+7(xxx)xxx-xx-xx"
                                />
                            </div>
                        </div>
                        <!-- Вредный гость? -->
                        <div class="form-check mb-3">
                            <label class="form-check-label" for="conflictGuest">
                                Конфликтный гость?
                            </label>

                            <input
                                v-model="reservation.conflict"
                                class="form-check-input"
                                type="checkbox"
                                value=""
                                id="conflictGuest"
                            />
                        </div>
                        <!-- Мероприятие и Кол-во гостей -->
                        <div class="row">
                            <!-- Мероприятие -->
                            <div class="mb-3 col-6">
                                <span>Мероприятие</span>
                                <select
                                    class="form-control form-select"
                                    v-model="reservation.visit_type"
                                    @change="
                                        reservation.visit_type =
                                            $event.target.value
                                    "
                                >
                                    <option value="Обычный визит" selected>
                                        Обычный визит
                                    </option>
                                    <option value="День рождения">
                                        День рождения
                                    </option>
                                    <option value="Романтический ужин">
                                        Романтический ужин
                                    </option>
                                    <option value="Семейный ужин">
                                        Семейный ужин
                                    </option>
                                </select>
                            </div>
                            <!-- Кол-во гостей -->
                            <div class="mb-3 col-6">
                                <span>Количество гостей</span>
                                <select
                                    class="form-control form-select w-50"
                                    v-model="reservation.amount"
                                    @change="
                                        reservation.amount = $event.target.value
                                    "
                                >
                                    <option value="1" selected>1</option>
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
                            <label for="guestNoteAdd" class="form-label"
                                >Дополнительная информация</label
                            >
                            <input
                                v-model="reservation.note"
                                type="text"
                                class="form-control"
                                id="guestNoteAdd"
                                placeholder="На заметку"
                            />
                        </div>
                        <!-- Предоплата и Стол -->
                        <div class="row">
                            <!-- Предоплата -->
                            <div class="mb-3 col-6">
                                <label
                                    for="guestPrepaymentAdd"
                                    class="form-label"
                                    >Предоплата</label
                                >
                                <input
                                    v-model="reservation.prepayment"
                                    type="number"
                                    class="form-control"
                                    id="guestPrepaymentAdd"
                                    placeholder="Сумма предоплаты"
                                    step="100"
                                />
                            </div>
                            <!-- Стол -->
                            <div class="mb-3 col-6">
                                <label class="form-label" for="tables"
                                    >№ стола</label
                                >
                                <select
                                    id="selectTables"
                                    class="form-control form-select"
                                    v-model="reservation.table_id"
                                    @change="
                                        reservation.table_id =
                                            $event.target.value
                                    "
                                >
                                    <option
                                        v-for="table in layout"
                                        :value="table.id"
                                        :key="table.id"
                                        selected
                                    >
                                        {{ table.i }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Дата и Время -->
                        <div class="row">
                            <!-- Дата -->
                            <div class="col-6">
                                <date-picker
                                    v-model="reservation.date"
                                    format="YYYY-MM-DD"
                                    type="date"
                                    valueType="format"
                                >
                                </date-picker>
                            </div>
                            <!-- Время -->
                            <div class="col-6">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Закрыть
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="() => addGuest()"
                            data-bs-dismiss="modal"
                        >
                            Добавить гостя
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для обновления инфо гостя -->
        <div
            class="modal fade"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            id="updateGuestInfo"
            tabindex="-1"
            aria-labelledby="updateGuestInfoModal"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateGuestModal">
                            Форма обновления бронирования
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="() => clearReservationInfo()"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <!-- Имя и Телефон -->
                        <div class="row">
                            <!-- Имя -->
                            <div class="mb-3 col-6">
                                <label for="guestNameUpdate" class="form-label"
                                    >Имя</label
                                >
                                <input
                                    v-model="reservation.name"
                                    type="text"
                                    class="form-control"
                                    id="guestNameUpdate"
                                    placeholder="Brad Pitt"
                                />
                            </div>
                            <!-- Телефон -->
                            <div class="mb-3 col-6">
                                <label for="guestPhoneUpdate" class="form-label"
                                    >Телефон</label
                                >
                                <input
                                    v-model="reservation.phone"
                                    type="number"
                                    class="form-control"
                                    id="guestPhoneUpdate"
                                    placeholder="+7(xxx)xxx-xx-xx"
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
                                v-model="reservation.conflict"
                                class="form-check-input"
                                type="checkbox"
                                value=""
                                id="conflictGuestUpdate"
                            />
                        </div>
                        <!-- Мероприятие и Кол-во гостей -->
                        <div class="row">
                            <!-- Мероприятие -->
                            <div class="mb-3 col-6">
                                <span>Мероприятие</span>
                                <select
                                    id="visit_type"
                                    class="form-control"
                                    aria-label="Visit type select"
                                    v-model="reservation.visit_type"
                                    @change="
                                        reservation.visit_type =
                                            $event.target.value
                                    "
                                >
                                    <option value="Обычный визит">
                                        Обычный визит
                                    </option>
                                    <option value="День рождения">
                                        День рождения
                                    </option>
                                    <option value="Романтический ужин">
                                        Романтический ужин
                                    </option>
                                    <option value="Семейный ужин">
                                        Семейный ужин
                                    </option>
                                </select>
                            </div>
                            <!-- Кол-во гостей -->
                            <div class="mb-3 col-6">
                                <span>Количество гостей</span>
                                <select
                                    v-model="reservation.amount"
                                    @change="
                                        reservation.amount = $event.target.value
                                    "
                                    class="form-control w-50"
                                >
                                    <option value="1" selected>1</option>
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
                            <label for="guestNoteUpdate" class="form-label"
                                >Дополнительная информация</label
                            >
                            <input
                                v-model="reservation.note"
                                type="text"
                                class="form-control"
                                id="guestNoteUpdate"
                                placeholder="На заметку"
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
                                    v-model="reservation.prepayment"
                                    type="number"
                                    class="form-control"
                                    id="guestPrepaymentUpdate"
                                    placeholder="Сумма предоплаты"
                                    step="100"
                                />
                            </div>
                            <!-- Стол -->
                            <div class="mb-3 col-6">
                                <label
                                    class="form-label"
                                    for="selectTablesUpdate"
                                    >№ стола</label
                                >
                                <select
                                    id="selectTablesUpdate"
                                    class="form-control"
                                    v-model="reservation.table_id"
                                    @change="
                                        reservation.table_id =
                                            $event.target.value
                                    "
                                >
                                    <option
                                        v-for="table in layout"
                                        :value="table.id"
                                        :key="table.id"
                                        selected
                                    >
                                        {{ table.i }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Дата и Время -->
                        <div class="row">
                            <!-- Дата -->
                            <div class="col-6">
                                <date-picker
                                    v-model="reservation.date"
                                    format="YYYY-MM-DD"
                                    type="date"
                                    valueType="format"
                                >
                                </date-picker>
                            </div>
                            <!-- Время -->
                            <div class="col-6">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="me-auto">
                            <button
                                type="button"
                                class="btn btn-secondary btn-danger"
                                data-bs-dismiss="modal"
                                @click="() => deleteReservation()"
                            >
                                Удалить
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary btn-success"
                                data-bs-dismiss="modal"
                                @click="() => completeReservation()"
                            >
                                Завершить
                            </button>

                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="() => updateGuest()"
                                data-bs-dismiss="modal"
                            >
                                Обновить
                            </button>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                                @click="() => clearReservationInfo()"
                            >
                                Закрыть
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для отображения гостей в ожидании -->
        <div
            class="modal fade"
            id="waitingList"
            aria-hidden="true"
            aria-labelledby="waitingList"
            tabindex="-1"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="waitingListTitle">
                            Лист ожидания
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <ul
                            v-if="waitingList"
                            :style="{ margin: '0px', padding: '0px' }"
                        >
                            <li
                                v-for="item in waitingList.reservations"
                                :key="item.id"
                                :style="{
                                    listStyle: 'none',
                                    padding: '2px',
                                    margin: '0',
                                    backgroundColor: colorByTime(
                                        getExactTime(item.created_at)
                                    ),
                                    color: '',
                                    fontSize: '12px',
                                    cursor: 'pointer',
                                    borderBottom: '1px solid black',
                                }"
                                @click="updateGuestInfo(item)"
                                data-bs-toggle="modal"
                                data-bs-target="#updateGuestInfo"
                            >
                                {{
                                    item.created_at
                                        ? getExactTime(
                                              new Date(item.created_at)
                                          )
                                        : null
                                }}. {{ item.name }} [{{ item.amount }}] |
                                {{ item.phone }}
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-primary"
                            data-bs-target="#AddGuest"
                            data-bs-toggle="modal"
                            data-bs-dismiss="modal"
                        >
                            Добавить в очередь
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Использую модалку Добавления Гостяя, а не отдальную. Пока не удалять. -->
        <div
            class="modal fade"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            id="sendToWaitingList"
            tabindex="-1"
            aria-labelledby="sendToWaitingList"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendToWaitingListTitle">
                            Лист ожидания
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="() => clearReservationInfo()"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guestName" class="form-label"
                                >Имя</label
                            >
                            <input
                                v-model="reservation.name"
                                type="text"
                                class="form-control"
                                id="guestName"
                                placeholder="Brad Pitt"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="guestPhone" class="form-label"
                                >Телефон</label
                            >
                            <input
                                v-model="reservation.phone"
                                type="number"
                                class="form-control"
                                id="guestPhone"
                                placeholder="+7(xxx)xxx-xx-xx"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="guestPrepayment" class="form-label"
                                >Предоплата</label
                            >
                            <input
                                v-model="reservation.prepayment"
                                type="number"
                                class="form-control"
                                id="guestPrepayment"
                                placeholder="Сумма предоплаты"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label"
                                >Дополнительная информация</label
                            >
                            <input
                                v-model="reservation.note"
                                type="text"
                                class="form-control"
                                id="note"
                                placeholder="Important information"
                            />
                        </div>
                        <div class="mb-3">
                            <span>Количество гостей</span>
                            <select
                                v-model="reservation.amount"
                                @change="
                                    reservation.amount = $event.target.value
                                "
                            >
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
                            <select
                                v-model="reservation.table_id"
                                @change="
                                    reservation.table_id = $event.target.value
                                "
                            >
                                <option
                                    v-for="table in layout"
                                    :value="table.id"
                                    :key="table.id"
                                >
                                    {{ table.i }}
                                </option>
                            </select>
                        </div>
                        <date-picker
                            v-model="reservation.date"
                            format="YYYY-MM-DD"
                            type="date"
                            valueType="format"
                        ></date-picker>
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
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            @click="() => clearReservationInfo()"
                        >
                            Закрыть
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="() => addToWaitingList()"
                            data-bs-dismiss="modal"
                        >
                            Добавить в ожидание
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модалка для добавления стола-->
        <div
            class="modal fade"
            id="AddOneTable"
            tabindex="-1"
            aria-labelledby="addTableModal"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTableModal">
                            Хотите добавить стол?
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <label for="AddTablePasswordCheck"
                            >Введите пароль</label
                        >
                        <input
                            v-if="showPassword"
                            class="form-control"
                            v-model="password"
                            type="text"
                            id="AddTablePasswordCheck"
                            required
                        />
                        <input
                            v-else-if="!showPassword"
                            class="form-control"
                            v-model="password"
                            type="password"
                            id="AddTablePasswordCheck"
                            required
                        />
                        <div>
                            <button
                                class="btn btn-primary btn-sm mt-2"
                                @click="toggleShow()"
                            >
                                <span class="icon is-small is-right">
                                    Показать пароль
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                            @click="addTable(false, password)"
                        >
                            Добавить обычный стол
                        </button>
                        <button
                            type="button"
                            class="btn btn-warning"
                            data-bs-dismiss="modal"
                            @click="addTable(true, password)"
                        >
                            Добавить стол BBQ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для удаления стола -->
        <div
            class="modal fade"
            id="DeleteTable"
            tabindex="-1"
            aria-labelledby="DeleteTableModal"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DeleteTableModal">
                            Уверены, что хотите удалить стол?
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <label for="RemoveTablePasswordCheck"
                            >Введите пароль</label
                        >
                        <input
                            v-if="showPassword"
                            class="form-control"
                            v-model="password"
                            type="text"
                            id="RemoveTablePasswordCheck"
                            required
                        />
                        <input
                            v-else-if="!showPassword"
                            class="form-control"
                            v-model="password"
                            type="password"
                            id="RenoveTablePasswordCheck"
                            required
                        />
                        <div>
                            <button
                                class="btn btn-primary btn-sm mt-2"
                                @click="toggleShow()"
                            >
                                <span class="icon is-small is-right">
                                    Показать пароль
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            @click="deleteOneTable(password)"
                        >
                            Удалить стол
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                        >
                            Закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для проверки пароля -->
        <div
            class="modal fade"
            id="passwordCheck"
            tabindex="-1"
            aria-labelledby="passwordCheck"
            aria-hidden="true"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Мастер-пароль
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <label for="passwordCheckInput">Введите пароль</label>
                        <input
                            v-if="showPassword"
                            class="form-control"
                            v-model="password"
                            type="text"
                            id="passwordCheckInput"
                        />
                        <input
                            v-else-if="!showPassword"
                            class="form-control"
                            v-model="password"
                            type="password"
                            id="passwordCheckInput"
                        />
                        <div>
                            <button
                                class="btn btn-primary btn-sm mt-2"
                                @click="toggleShow()"
                            >
                                <span class="icon is-small is-right">
                                    Показать пароль
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="checkPass(password)"
                            data-bs-dismiss="modal"
                        >
                            Проверить
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для ограничения по времени -->
        <div
            class="modal fade"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            id="AddRestriction"
            tabindex="-1"
            aria-labelledby="addRestrictionModal"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRestrictionModal">
                            Ограничение по времени
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <!--Стол -->
                        <div class="mb-3">
                            <label class="form-label" for="tables"
                                >№ стола</label
                            >
                            <select
                                id="selectTables"
                                class="form-control form-select"
                                v-model="reservation.table_id"
                                @change="
                                    reservation.table_id = $event.target.value
                                "
                            >
                                <option
                                    v-for="table in layout"
                                    :value="table.id"
                                    :key="table.id"
                                    selected
                                >
                                    {{ table.i }}
                                </option>
                            </select>
                        </div>

                        <!-- Дата и Время -->
                        <div class="row">
                            <!-- Дата -->
                            <div>
                                <date-picker
                                    v-model="restriction.date"
                                    format="YYYY-MM-DD"
                                    type="date"
                                    valueType="format"
                                >
                                </date-picker>
                            </div>
                            <!-- Время -->
                            <div>
                                <span>C</span>
                                <date-picker
                                    v-model="restriction.from"
                                    :minute-step="30"
                                    :hour-options="hours"
                                    format="HH:mm"
                                    value-type="format"
                                    type="time"
                                    placeholder="HH:mm"
                                ></date-picker>
                            </div>
                            <div>
                                <span>До</span>
                                <date-picker
                                    v-model="restriction.to"
                                    :minute-step="30"
                                    :hour-options="hours"
                                    format="HH:mm"
                                    value-type="format"
                                    type="time"
                                    placeholder="HH:mm"
                                ></date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Закрыть
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="() => addRestriction()"
                            data-bs-dismiss="modal"
                        >
                            Добавить ограничение
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueGridLayout from "vue-grid-layout";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/scss/index.scss";

export default {
    name: "Booking",
    // props: ["user"],
    components: {
        GridLayout: VueGridLayout.GridLayout,
        GridItem: VueGridLayout.GridItem,
        DatePicker,
    },
    data() {
        return {
            timer: null,
            showPassword: false,
            password: "",
            passCheck: false,
            place: "",
            actionType: "",
            today: new Date(),
            layout: [],
            selected: "Ожидание",
            waitingList: null,
            logs: [],
            colors: ["#FFFF8F", "#19DF01", "#EE4B2B"],
            loading: true,
            error: null,
            showModal: false,
            table: {
                id: null,
                x: 9,
                y: 9,
                w: 2,
                h: 3,
            },
            restriction: {
                date: new Date(),
                from: "",
                to: "",
            },
            hours: Array.from({ length: 23 }).map((_, i) => i + 9),
            reservation: {
                name: "",
                phone: "",
                conflict: false,
                visit_type: "Обычный визит",
                amount: 1,
                note: "",
                prepayment: 0,
                table_id: null,
                place_id: null,
                date: new Date(),
                time: "",
                responsible_email: "",
                responsible_name: "",
            },
        };
    },
    async mounted() {
        console.log(this.user);
        this.loading = false;

        axios
            .get("api/user")
            .then((response) => {
                this.reservation.responsible_name = response.data.name;
                this.reservation.responsible_email = response.data.email;
            })
            .catch((err) => {
                console.log(err);
            });

        console.log(this.reservation);
    },
    computed: {
        tables() {
            if (this.place === "place_1") {
                return this.layout.filter(
                    (table) => table.id !== 100 && table.place_id === 1
                );
            }
            if (this.place === "place_2") {
                return this.layout.filter(
                    (table) => table.id !== 101 && table.place_id === 2
                );
            }
            if (this.place === "place_3") {
                return this.layout.filter(
                    (table) => table.id !== 102 && table.place_id === 3
                );
            }
        },
        dayFilter() {
            const options = {
                day: "numeric",
            };
            return Intl.DateTimeFormat("ru-RU", options).format(this.today);
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
                Intl.DateTimeFormat("ru-RU", options).format(this.today)
            );
        },
    },
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
            // let h = this.addLeadingZero(date.getHours());
            // let m = this.addLeadingZero(date.getMinutes());

            return `${Y}.${M}.${D} (${d})`;
        },
        getExactTime(date) {
            return (
                new Date(date).getHours() + ":" + new Date(date).getMinutes()
            );
        },
        colorByTime(value) {
            const newValue = value.slice(0, 2);
            if (newValue >= 9 && newValue < 12) {
                return "#FFFF8F";
            }
            if (newValue >= 12 && newValue < 17) {
                return "#19DF01";
            }
            if (newValue >= 17) {
                return "#EE4B2B";
            }
        },
        choosePlace(event) {
            this.place = event.target.value;
            this.fetchTables();
        },
        chooseTable(item) {
            this.reservation.table_id = item.id;
            this.table.id = item.id;
        },
        clearReservationInfo() {
            this.reservation.name = "";
            this.reservation.phone = "";
            this.reservation.conflict = false;
            this.reservation.visit_type = "Обычный визит";
            this.reservation.amount = 1;
            this.reservation.note = "";
            this.reservation.prepayment = 0;
            this.reservation.table_id = null;
            this.reservation.place_id = null;
            this.reservation.date = null;
            this.reservation.time = "";
            // Не очищаю имя и почту ответственного, чтобы использовать на всех 3-х точках
        },
        updateGuestInfo(item) {
            this.reservation = {
                id: item.id,
                name: item.name,
                phone: item.phone,
                conflict: item.conflict,
                visit_type: item.visit_type,
                prepayment: item.prepayment,
                amount: item.amount,
                note: item.note,
                table_id: item.table_id,
                place_id: item.place_id,
                date: item.date,
                time: item.time,
                responsible_email: this.reservation.responsible_email,
                responsible_name: this.reservation.responsible_name,
            };
        },
        checkPass(value) {
            this.password = value;

            if (this.password === process.env.MIX_MASTERKEY) {
                this.passCheck = true;
                this.timer = setTimeout(() => {
                    this.passCheck = false;
                }, 20000);
            }
            this.password = "";
        },
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        async fetchLogs() {
            this.layout = null;
            this.loading = true;
            const response = await axios.get(
                "http://booking-api.test/api/logs"
            );
            this.logs = response.data;
            this.loading = false;
        },
        async fetchTables() {
            switch (this.place) {
                case "place_1":
                    try {
                        this.loading = true;
                        const response = await axios.get(
                            "http://booking-api.test/api/tables"
                        );
                        this.layout = response.data.data.filter((table) => {
                            if (table.place_id === 1) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.error = error;
                    }
                    break;
                case "place_2":
                    try {
                        this.loading = true;
                        const response = await axios.get(
                            "http://booking-api.test/api/tables"
                        );
                        this.layout = response.data.data.filter((table) => {
                            if (table.place_id === 2) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.error = error;
                    }
                    break;
                case "place_3":
                    try {
                        this.loading = true;
                        const response = await axios.get(
                            "http://booking-api.test/api/tables"
                        );
                        this.layout = response.data.data.filter((table) => {
                            if (table.place_id === 3) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.error = error;
                    }
                    break;
                default:
                    console.log("Default message");
            }
        },
        async updateLayout(item) {
            if (this.place === "place_1") {
                try {
                    await axios.put(
                        `http://booking-api.test/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    this.error = error;
                }
            }
            if (this.place === "place_2") {
                try {
                    await axios.put(
                        `http://booking-api.test/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    this.error = error;
                }
            }
            if (this.place === "place_3") {
                try {
                    await axios.put(
                        `http://booking-api.test/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    console.log(error);
                }
            }
        },
        async addGuest() {
            if (this.place === "place_1") {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    conflict: this.reservation.conflict,
                    visit_type: this.reservation.visit_type,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    prepayment: this.reservation.prepayment,
                    table_id: this.reservation.table_id,
                    place_id: 1,
                    date: this.reservation.date,
                    time: this.reservation.time,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };

                try {
                    await axios.post(
                        `http://booking-api.test/api/reservations`,
                        newReservation
                    );
                    const newLog = {
                        text: `Стол №${newReservation.table_id} был забронирован.`,
                        type: "Бронирование",
                        ...newReservation,
                    };
                    await axios.post(
                        `http://booking-api.test/api/logs`,
                        newLog
                    );
                } catch (error) {
                    console.log(error.message);
                }
            }
            if (this.place === "place_2") {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    conflict: this.reservation.conflict,
                    visit_type: this.reservation.visit_type,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    prepayment: this.reservation.prepayment,
                    table_id: this.reservation.table_id,
                    place_id: 2,
                    date: this.reservation.date,
                    time: this.reservation.time,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };
                await axios.post(
                    `http://booking-api.test/api/reservations`,
                    newReservation
                );
                const newLog = {
                    text: `Стол №${newReservation.table_id} на Байкальской был забронирован.`,
                    type: "Бронирование",
                    ...newReservation,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            if (this.place === "place_3") {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    conflict: this.reservation.conflict,
                    visit_type: this.reservation.visit_type,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    prepayment: this.reservation.prepayment,
                    table_id: this.reservation.table_id,
                    place_id: 3,
                    date: this.reservation.date,
                    time: this.reservation.time,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };
                await axios.post(
                    `http://booking-api.test/api/reservations`,
                    newReservation
                );
                const newLog = {
                    text: `Стол №${newReservation.table_id} на Байкальской был забронирован.`,
                    type: "Бронирование",
                    ...newReservation,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async updateGuest() {
            if (this.place === "place_1") {
                await axios.put(
                    `http://booking-api.test/api/reservations/${this.reservation.id}`,
                    this.reservation
                );
                const newLog = {
                    text: `Новые данные гостя.`,
                    type: "Обновление",
                    ...this.reservation,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            if (this.place === "place_2") {
                await axios.put(
                    `http://booking-api.test/api/reservations/${this.reservation.id}`,
                    this.reservation
                );
                const newLog = {
                    text: `Новые данные гостя.`,
                    type: "Обновление",
                    ...this.reservation,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            if (this.place === "place_3") {
                await axios.put(
                    `http://booking-api.test/api/reservations/${this.reservation.id}`,
                    this.reservation
                );
                const newLog = {
                    text: `Новые данные гостя.`,
                    type: "Обновление",
                    ...this.reservation,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async fetchWaitingList() {
            const response = await axios.get(
                "http://booking-api.test/api/tables"
            );
            if (this.place === "place_1") {
                this.waitingList = response.data.data.find((table) => {
                    if (table.id === 100) {
                        return table;
                    }
                });
            }
            if (this.place === "place_2") {
                this.waitingList = response.data.data.find((table) => {
                    if (table.id === 101) {
                        return table;
                    }
                });
            }
            if (this.place === "place_3") {
                this.waitingList = response.data.data.find((table) => {
                    if (table.id === 102) {
                        return table;
                    }
                });
            }
        },
        async addToWaitingList() {
            if (this.place === "place_1") {
                const waitingGuest = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    prepayment: this.reservation.prepayment,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    date: this.reservation.date,
                    time:
                        this.reservation.time === ""
                            ? "Ожидание"
                            : this.reservation.time,
                    table_id: 100,
                    place_id: 1,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };
                await axios.post(
                    `http://booking-api.test/api/reservations`,
                    waitingGuest
                );

                const newLog = {
                    text: `Гость был добавлен в лист ожидания.`,
                    type: "Ожидание",
                    ...waitingGuest,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            if (this.place === "place_2") {
                const waitingGuest = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    prepayment: this.reservation.prepayment,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    date: this.reservation.date,
                    time:
                        this.reservation.time === ""
                            ? "Ожидание"
                            : this.reservation.time,
                    table_id: 101,
                    place_id: 2,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };
                await axios.post(
                    `http://booking-api.test/api/reservations`,
                    waitingGuest
                );

                const newLog = {
                    text: `Гость был добавлен в лист ожидания.`,
                    type: "Ожидание",
                    ...waitingGuest,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            if (this.place === "place_3") {
                const waitingGuest = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    prepayment: this.reservation.prepayment,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    date: this.reservation.date,
                    time:
                        this.reservation.time === ""
                            ? "Ожидание"
                            : this.reservation.time,
                    table_id: 102,
                    place_id: 3,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };
                await axios.post(
                    `http://booking-api.test/api/reservations`,
                    waitingGuest
                );

                const newLog = {
                    text: `Гость был добавлен в лист ожидания.`,
                    type: "Ожидание",
                    ...waitingGuest,
                };
                await axios.post(`http://booking-api.test/api/logs`, newLog);
            }
            this.clearReservationInfo();
        },
        async deleteReservation() {
            try {
                await axios.post(
                    `http://booking-api.test/api/failed_reservations`,
                    this.reservation
                );
            } catch (error) {
                console.log(error);
            }

            try {
                await axios.delete(
                    `http://booking-api.test/api/reservations/${this.reservation.id}`
                );
            } catch (error) {
                console.log(error);
            }

            const newLog = {
                text: "Бронирование удалено.",
                type: "Отмена",
                ...this.reservation,
            };

            await axios.post(`http://booking-api.test/api/logs`, newLog);
            await this.fetchTables();
        },
        async completeReservation() {
            try {
                await axios.post(
                    `http://booking-api.test/api/completed_reservations`,
                    this.reservation
                );
            } catch (error) {
                console.log(error);
            }

            try {
                await axios.delete(
                    `http://booking-api.test/api/reservations/${this.reservation.id}`
                );
            } catch (error) {
                console.log(error);
            }

            const newLog = {
                text: "Бронирование завершено.",
                type: "Завершено",
                ...this.reservation,
            };
            await axios.post(`http://booking-api.test/api/logs`, newLog);
            await this.fetchTables();
        },
        async addTable(type, password) {
            this.checkPass(password);
            const response = await axios.get(
                "http://booking-api.test/api/tables"
            );

            if (this.place === "place_1" && this.passCheck) {
                const newTable = {
                    ...this.table,
                    place_id: 1,
                    i: (this.tables.length + 1).toString(),
                    bbq: type,
                };
                await axios.post(
                    "http://booking-api.test/api/tables",
                    newTable
                );
            }
            if (this.place === "place_2" && this.passCheck) {
                const newTable = {
                    ...this.table,
                    place_id: 2,
                    i: (this.tables.length + 1).toString(),
                    bbq: type,
                };
                await axios.post(
                    "http://booking-api.test/api/tables",
                    newTable
                );
            }
            if (this.place === "place_3" && this.passCheck) {
                const newTable = {
                    ...this.table,
                    place_id: 3,
                    i: (this.tables.length + 1).toString(),
                    bbq: type,
                };
                await axios.post(
                    "http://booking-api.test/api/tables",
                    newTable
                );
            }

            this.loading = true;
            await this.fetchTables();
            this.loading = false;
        },
        async deleteOneTable(password) {
            this.checkPass(password);

            if (this.place === "place_1" && this.passCheck) {
                const table = await axios.get(
                    `http://booking-api.test/api/tables/${this.table.id}`
                );
                await axios.delete(
                    `http://booking-api.test/api/tables/${this.table.id}`
                );
            }
            if (this.place === "place_2" && this.passCheck) {
                await axios.delete(
                    `http://booking-api.test/api/tables/${this.table}`
                );
            }
            if (this.place === "place_3" && this.passCheck) {
                await axios.delete(
                    `http://booking-api.test/api/tables/${this.table}`
                );
            }
            this.loading = true;
            await this.fetchTables();
            this.loading = false;
        },
        async addRestriction() {
            console.log("Restriction: ", this.restriction);
        },
    },
};
</script>

<style lang="scss">
.vue-draggable-handle {
    position: absolute;
    width: 20px;
    top: 0;
    right: 0;
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
    top: 0;
    right: 0;
    padding: 0;
    background-origin: content-box;
    background-color: white;
    box-sizing: border-box;
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
    cursor: pointer;
}
.button_action {
    padding: 2px 5px 2px 5px;
    color: white;
    background-color: #4099de;
    font-weight: 600;
    font-size: 16px;
    border-radius: 8px;
    display: inline-block;
    min-width: 70px;
    border: 1px solid transparent;
    transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
}
.size {
    width: 200px;
}
.button_action:hover {
    box-shadow: 0px 3px 1px rgba(0, 0, 0, 0.1), 0px 1px 2px rgba(0, 0, 0, 0.08),
        0px 2px 2px rgba(0, 0, 0, 0.12);
}
.button_action:focus {
    box-shadow: 0px 3px 1px rgba(0, 0, 0, 0.1), 0px 1px 2px rgba(0, 0, 0, 0.08),
        0px 2px 2px rgba(0, 0, 0, 0.12);
}
.place_input {
    font-weight: 600;
    color: #3c4655;
    background-color: white;
    border-width: 1px;
    border: none;
    /* border-color: #bacad6; */
}
// .card_md {
//     width: 15rem;
//     height: 15rem;
// }
.card {
    width: 70px;
    height: 70px;
    // width: 18vw;
    // height: 18vw;
    /* width: 100%;
    height: 0;
    padding-top: 100%;
    background-color: white;
    position: relative; */
    @media (min-width: 576px) {
        width: 74px;
        height: 74px;
    }
    @media (min-width: 767px) {
        width: 136px;
        height: 136px;
    }
    @media (min-width: 992px) {
        min-width: 182px;
        min-height: 182px;
    }
    @media (min-width: 1200px) {
        min-width: 257px;
        min-height: 257px;
    }
}

// .card_content {
//     width: 100%;
//     height: 100%;
//     position: absolute;
//     top: 0;
//     left: 0;
// }
.card_content_info {
    @media (min-width: 576px) {
        padding: 15px 5px 15px 5px;
    }
    @media (min-width: 767px) {
        padding: 20px 5px 20px 5px;
    }
    @media (min-width: 992px) {
        padding: 20px 5px 20px 5px;
    }
    @media (min-width: 1200px) {
        padding: 30px 10px 15px 10px;
    }
}
.day_full {
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
    font-weight: bold;

    @media (min-width: 375px) {
        display: none;
    }
    // @media (min-width: 576px) {
    //     display: block;
    //     font-size: 10px;
    //     font-weight: 600;
    // }
    @media (min-width: 767px) {
        display: block;
        font-size: 15px;
    }
    @media (min-width: 992px) {
        font-size: 20px;
    }
    @media (min-width: 1440px) {
        font-size: 28px;
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
.place_title {
    width: 150px;
    color: #3c4655;
}
.card_time {
    color: #3c4655;
}
.first_column {
    @media (min-width: 375px) and (max-width: 576px) {
        margin: 0 0 10px 0;
    }
}
.bbq_table path {
    fill: #fff;
    stroke: #fff;
}
</style>
