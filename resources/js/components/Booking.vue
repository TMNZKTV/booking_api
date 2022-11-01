<template>
    <div>
        <div class="px-4 py-3 mb-5 general_panel" >
            <div class="row">
                <div class="xs col-12 col-sm-4 col-md-6 mb-2">
                    <!-- Календарь -->
                    <div class="row">
                        <div class="col-auto">
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
                                v-model="date"
                                format="YYYY-MM-DD"
                                valueType="format"
                                :style="{ width: '150px' }"
                            ></date-picker>

                            <div class="row mt-md-2 mt-xl-4">
                                <div class="col-12">
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
                <div class="xs col-12 col-sm-8 col-md-6 info_panel">
                    <!-- 1 ряд -->
                    <div class="row row-cols-2 g-1 mb-1">
                        <!-- Изменить расположение -->
                        <div class="col-auto">
                            <div class="btn btn-primary p-2 button_action">
                                <input
                                    type="radio"
                                    value="changeLayout"
                                    v-model="actionType"
                                    class="btn-check"
                                    data-bs-toggle="modal"
                                    data-bs-target="#passwordCheck"
                                    id="changeLayout"
                                />
                                <label for="changeLayout"
                                    >Изменить порядок</label
                                >
                            </div>
                        </div>
                        <!-- Добавить посетителя -->
                        <div class="col-auto">
                            <div class="btn btn-success p-2 button_action">
                                <input
                                    type="radio"
                                    value="addGuest"
                                    v-model="actionType"
                                    class="btn-check"
                                    id="forAddGuest"
                                />
                                <label for="forAddGuest"
                                    >Добавить гостя</label
                                >
                            </div>
                        </div>
                        <!-- Ожидание -->
                        <div class="col-auto">
                            <div class="btn btn-warning p-2 button_action">
                                <input
                                    type="radio"
                                    value="waitingList"
                                    v-model="actionType"
                                    data-bs-toggle="modal"
                                    data-bs-target="#waitingList"
                                    class="btn-check"
                                    id="waitingListButton"
                                    @click="fetchWaitingList(); chooseWaitingTable();"
                                />
                                <label for="waitingListButton"
                                >Ожидание</label
                                >
                            </div>
                        </div>
                    </div>

                    <!-- 2 ряд -->
                    <div class="row row-cols-2 g-1 mb-1">
                        <!-- Добавить стол -->
                        <div class="col-auto">
                            <div class="btn btn-info p-2 button_action">
                                <input
                                    type="radio"
                                    value="addTable"
                                    v-model="actionType"
                                    data-bs-toggle="modal"
                                    data-bs-target="#AddOneTable"
                                    class="btn-check"
                                    id="addTable"
                                />
                                <label for="addTable"
                                    >Добавить стол</label
                                >
                            </div>
                        </div>
                        <!-- Удалить стол -->
                        <div class="col-auto">
                            <div class="btn btn-danger p-2 button_action">
                                <input
                                    type="radio"
                                    value="removeTable"
                                    v-model="actionType"
                                    class="btn-check"
                                    id="removeTable"
                                />
                                <label for="removeTable"
                                    >Удалить стол</label
                                >
                            </div>
                        </div>
                    </div>

                    <!-- 3 ряд с иконками -->
                    <div class="col-md-12 col-xl-8 mt-3 border border-4 info_panel_icons">
                        <div class="row row-cols-2 g-2 p-2">
                            <!-- Стол BBQ -->
                            <div class="col-auto col-md-4 col-lg-4 col-xl-5">
                                <img
                                    src="/images/bbq.svg"
                                    alt="bbq"
                                    class="info_panel_icons_icon"
                                />
                                <span>Стол BBQ</span>
                            </div>
                            <!-- Предоплата -->
                            <div class="col-auto col-lg-4 col-xl-5">
                                <img
                                    src="/images/ruble.svg"
                                    alt="Ruble"
                                    class="info_panel_icons_icon"
                                />
                                <span>Есть предоплата</span>
                            </div>
                            <div class="w-100"></div>
                            <!-- День рождения -->
                            <div class="col-auto col-md-4 col-lg-4 col-xl-5">
                                <img
                                    src="images/birthday.svg"
                                    alt="birthday"
                                    class="info_panel_icons_icon"
                                />
                                <span>День рождения</span>
                            </div>
                            <!-- Романтический ужин -->
                            <div class="col-auto col-lg-5 col-xl-5">
                                <img
                                    src="images/heart.svg"
                                    alt="romantic dinner"
                                    class="info_panel_icons_icon"
                                />
                                <span>Романтический ужин</span>
                            </div>
                            <div class="w-100"></div>
                            <!-- Семейный ужин -->
                            <div class="col-auto col-md-4 col-lg-4 col-xl-5">
                                <img
                                    src="images/family.svg"
                                    alt="family dinner"
                                    class="info_panel_icons_icon"
                                />
                                <span>Семейный ужин</span>
                            </div>
                            <!-- Конфликтный гость -->
                            <div class="col-auto col-lg-5 col-xl-5">
                                <img
                                    src="images/conflict.svg"
                                    alt="conflict guest"
                                    class="info_panel_icons_icon"
                                />
                                <span>Конфликтный гость</span>
                            </div>
                            <div class="w-100"></div>
                            <!-- Бар -->
                            <div class="col-auto col-lg-4 col-xl-5">
                                <img
                                    src="images/bar.svg"
                                    alt="bar sign"
                                    class="info_panel_icons_icon"
                                />
                                <span>Бар</span>
                            </div>
                            <!-- Сейчас занят -->
                            <div class="col-auto col-lg-4 col-xl-5">
                                <img
                                    src="images/booked.svg"
                                    alt="booked sign"
                                    class="info_panel_icons_icon"
                                />
                                <span>Сейчас занят</span>
                            </div>
                            <div class="w-100"></div>
                            <!-- Ограниченное время -->
                            <div class="col-auto col-lg-4 col-xl-5">
                                <img
                                    src="images/finish.svg"
                                    alt="fixed visit time"
                                    class="info_panel_icons_icon"
                                />
                                <span>Ограниченный визит</span>
                            </div>
                            <div class="w-100"></div>
                            <!-- Утреннее время -->
                            <div class="col-auto col-lg-4 col-xl-4">
                                <img
                                    src="images/morning.svg"
                                    alt="morning time"
                                    class="info_panel_icons_icon"
                                />
                                <span>9-12 часов</span>
                            </div>
                            <!-- Дневное время -->
                            <div class="col-auto col-lg-4 col-xl-4">
                                <img
                                    src="images/day.svg"
                                    alt="day time"
                                    class="info_panel_icons_icon"
                                />
                                <span>12-18 часов</span>
                            </div>
                            <!-- Вечернее время -->
                            <div class="col-auto col-lg-4 col-xl-4">
                                <img
                                    src="images/evening.svg"
                                    alt="evening time"
                                    class="info_panel_icons_icon"
                                />
                                <span>18-23 часов</span>
                            </div>
                            <div class="w-100"></div>
                            <!-- Гость пришел -->
                            <div class="col-auto col-lg-4 col-xl-4">
                                <img
                                    src="images/arrived.svg"
                                    alt="guest arrived"
                                    class="info_panel_icons_icon"
                                />
                                <span>Гость пришел</span>
                            </div>
                            <!-- Гость опаздывает -->
                            <div class="col-auto col-lg-4 col-xl-4">
                                <img
                                    src="images/late.svg"
                                    alt="guest late"
                                    class="info_panel_icons_icon"
                                />
                                <span>Гость опаздывает</span>
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
                :margin="[10, 10]"
                :use-css-transforms="true"
                :responsive="false"
                :cols="{ lg: 12, md: 12, sm: 10, xs: 6, xxs: 4 }"
            >
                <grid-item
                    class="py-1 grid_item"
                    v-for="item in tables"
                    :x="item.x"
                    :y="item.y"
                    :w="item.w"
                    :h="item.h"
                    :i="item.i"
                    :key="item.i"
                    drag-allow-from=".vue-draggable-handle"
                    drag-ignore-from=".no-drag"
                    :style="{backgroundColor: item.booked ? '#cc3300' : '#3E2C41'}"
                >
                    <div>
                        <!-- Забронировать сейчас -->
                        <div class="me-auto">
                            <div
                                @click="chooseTable(item); bookNow(item)"
                            >
                                <img
                                    v-if="!item.booked"
                                    src="images/unbooked.svg"
                                    alt="unlocked"
                                    class="grid_item_locked"
                                />
                                <img
                                    v-if="item.booked"
                                    src="images/booked.svg"
                                    alt="locked"
                                    class="grid_item_locked"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="text">
                        <!-- Изменить расположение столов -->
                        <div v-if="passCheck === true">
                            <button
                                class="vue-draggable-handle"
                                type="button"
                                @click="updateLayout(item)"
                            >
                                =
                            </button>
                        </div>
                        <!-- Добавить гостя -->
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
                        <!-- Убрать стол -->
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
                        <!-- Номер и иконки стола -->
                        <div class="no-drag text-center table_info">
                            <!-- Вывод инфо об ограничении по времени -->
                            <div v-for="(item, idx) in item.restrictions" :key="idx"
                                 class="pointer restriction_time"
                                 data-bs-toggle="modal"
                                 data-bs-target="#UpdateRestriction"
                                 @click="updateRestrictionInfo(item)"
                            >
                                <!-- Иконка замка -->
                                <img
                                    src="
                                        images/lockSign.svg')

                                    "
                                    alt="restriction"
                                    class="restriction_time_lock"
                                />
                                <span class="restriction_time_info">{{item.from}}-{{item.to}}</span>
                            </div>
                            <div>
                                <!-- Номер стола / Бар -->
                                <span class="table_info_bar">
                                    {{ Number(item.i) === 0 ? null : item.i === 'Бар' ? item.i : Number(item.i) }}
                                </span>
                                <!-- Иконка BBQ -->
                                <img
                                    class="table_info_icon_table"
                                    v-if="item.bbq && !item.booked"
                                    src="images/bbqSign.svg"
                                    alt="bbq"
                                />
                                <img
                                    class="table_info_icon_table"
                                    v-if="item.bbq && item.booked"
                                    src="images/bbqSignBlack.svg"
                                    alt="bbq"
                                />
                                <!-- Иконка Бара -->
                                <img
                                    class="table_info_icon_table"
                                    v-if="item.i === 'Бар' && !item.booked"
                                    src="images/barSign.svg'"
                                    alt="bar"
                                />
                                <img
                                    class="table_info_icon_table"
                                    v-if="item.i === 'Бар' && item.booked"
                                    src="images/barSignBlack.svg'"
                                    alt="bar"
                                />
                                <br />
                            </div>
                        </div>
                    </div>
                    <!-- Вывод информации о бронированияя -->
                    <ul
                        class="m-0 p-0 list-unstyled reservation_list"
                    >
                        <li
                            v-for="(item, idx) in item.reservations"
                            :key="idx"
                            v-if="datePicker(item.date) === datePicker(date)"
                            class="m-0 pointer reservation_item"
                            :class="[ item.arrived ? 'arrived' : null, item.late ? 'late' : null]"
                            :style="{backgroundColor: item.from !== null ? colorByTime(item.from) : ''}"
                            data-bs-toggle="modal"
                            data-bs-target="#updateGuestInfo"
                            @click="updateGuestInfo(item)"
                        >
                            <div class="align-items-center reservation_item_info">
                                <!-- Иконка предоплаты -->
                                <img
                                    v-if="item.prepayment"
                                    src="images/ruble.svg"
                                    alt="Ruble"
                                />
                                <!-- Тип визита -->
                                <img
                                    v-if="item.visit_type === 'День рождения'"
                                    src="images/birthday.svg"
                                    alt="Birthday cake"
                                />
                                <img
                                    v-if="
                                        item.visit_type === 'Романтический ужин'
                                    "
                                    src="images/heart.svg"
                                    alt="Heart"
                                />
                                <img
                                    v-if="item.visit_type === 'Семейный ужин'"
                                    src=" images/family.svg"
                                    alt="Family"
                                />
                                <!-- Конфликтный гость -->
                                <img
                                    v-if="item.conflict"
                                    src="images/conflict.svg"
                                    alt="Warning!"
                                />
                                <!-- Ограничение по времени -->
                                <img
                                    v-if="item.to"
                                    src="images/finish.svg"
                                    alt="fixed visit time"
                                />
                                <span class="align-middle">
                                    <b
                                        >{{item.from}}{{item.to === null ? "." : null }}
                                        {{item.to === null ? null : "-"}}
                                        {{item.to !== '' ? item.to : null}}{{item.to === null ? null : '.'}}
                                        {{ item.name }} [{{item.amount }}]
                                    </b>
                                </span>
                            </div>
                        </li>
                    </ul>
                </grid-item>
            </grid-layout>
        </div>
        <div v-if="error">
            <h2 class="text-center my-5">
                Что-то пошло не так!
            </h2>
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
                            @click="() => clearReservationInfo()"
                        ></button>
                    </div>
                    <form @submit.prevent="addGuest">
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
                                        type="tel"
                                        class="form-control"
                                        id="guestPhoneAdd"
                                        placeholder="+7(xxx)xxx-xx-xx"
                                        v-phone
                                        required
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
                                        reservation.amount = Number($event.target.value)
                                    "
                                    >
                                        <option v-for="guest in guests" :value="guest">{{guest}}</option>
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
                            <div class="row mb-3">
                                <!-- Предоплата -->
                                <div class="col-6">
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
                                        required
                                    />
                                </div>
                                <!-- Стол -->
                                <div class="col-6">
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
                            <div class="row mb-3">
                                <!-- Дата -->
                                <div class="col-6">
                                    <p class="mb-2">Дата</p>
                                    <date-picker
                                        v-model="date"
                                        value-type="format"
                                        format="YYYY-MM-DD"
                                    >
                                    </date-picker>
                                </div>
                                <!-- Время -->
                                <div class="col-6">
                                    <p class="mb-2">Начало</p>
                                    <date-picker
                                        v-model="from"
                                        format="HH:mm"
                                        type="time"
                                        value-type="format"
                                        :hour-options="hours"
                                        :minute-step="5"
                                        placeholder="Ч:м"
                                    ></date-picker>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                        <div class="form-check form-switch col-auto mb-3">
                                            <label class="form-check-label" for="guestArrivedToggle">Гость пришел</label>
                                            <input
                                                v-model="reservation.arrived"
                                                id="guestArrivedToggle"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                        </div>
                                        <div class="form-check form-switch col-auto">
                                            <label class="form-check-label" for="guestLateToggle">Гость опаздывает</label>
                                            <input
                                                v-model="reservation.late"
                                                id="guestLateToggle"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                        </div>
                                </div>
                                <div class="col-6">
                                    <p class="mb-2">Конец</p>
                                    <date-picker
                                        v-model="to"
                                        :minute-step="30"
                                        :hour-options="hours"
                                        format="HH:mm"
                                        value-type="format"
                                        type="time"
                                        placeholder="Ч:м"
                                    ></date-picker>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                                @click="()=> clearReservationInfo()"
                            >
                                Закрыть
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Добавить гостя
                            </button>
                        </div>
                    </form>
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
                        <form>
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
                                        type="tel"
                                        class="form-control"
                                        id="guestPhoneUpdate"
                                        placeholder="+7(xxx)xxx-xx-xx"
                                        v-phone
                                        required
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
                                            reservation.amount = Number($event.target.value)
                                        "
                                        class="form-control w-50"
                                    >
                                        <option v-for="guest in guests" :value="guest">{{guest}}</option>
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
                                        required
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
                            <div class="row mb-3">
                                <!-- Дата -->
                                <div class="col-6">
                                    <p class="mb-1">Дата</p>
                                    <date-picker
                                        v-model="reservation.date"
                                        format="YYYY-MM-DD"
                                        valueType="format"
                                    >
                                    </date-picker>
                                </div>
                                <!-- Время -->
                                <div class="col-6">
                                    <p class="mb-1">Начало</p>
                                    <date-picker
                                        v-model="reservation.from"
                                        :minute-step="5"
                                        :hour-options="hours"
                                        format="HH:mm"
                                        value-type="format"
                                        type="time"
                                        placeholder="Ч:м"
                                    ></date-picker>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Гость пришел / Опоздал / Конец визита-->
                                <div class="col-6">
                                    <div class="form-check form-switch col-auto mb-3">
                                        <label class="form-check-label" for="guestArrivedToggleUpdate">Гость пришел</label>
                                        <input
                                            v-model="reservation.arrived"
                                            id="guestArrivedToggleUpdate"
                                            type="checkbox"
                                            class="form-check-input"
                                        />
                                    </div>
                                    <div class="form-check form-switch col-auto">
                                        <label class="form-check-label" for="guestLateToggleUpdate">Гость опаздывает</label>
                                        <input
                                            v-model="reservation.late"
                                            id="guestLateToggleUpdate"
                                            type="checkbox"
                                            class="form-check-input"
                                        />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1">Конец</p>
                                    <date-picker
                                        v-model="reservation.to"
                                        :minute-step="30"
                                        :hour-options="hours"
                                        format="HH:mm"
                                        value-type="format"
                                        type="time"
                                        placeholder="Ч:м"
                                    ></date-picker>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <div class="me-auto">
                                <button
                                    type="button"
                                    class="btn btn-secondary btn-danger"
                                    data-bs-dismiss="modal"
                                    data-bs-target="#reasonFailedModal"
                                    data-bs-toggle="modal"
                                >
                                    Удалить
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary btn-success"
                                    data-bs-dismiss="modal"
                                    data-bs-target="#feedbackModal"
                                    data-bs-toggle="modal"
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
        <!-- Модалка Как все прошло? -->
        <div class="modal fade" id="feedbackModal" aria-hidden="true" aria-labelledby="feedbackModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalTitle">Как все прошло?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="feedback" class="form-label"
                            >Комментарии</label
                            >
                            <textarea
                                v-model="feedback"
                                type="text"
                                class="form-control"
                                id="feedback"
                                placeholder="..."
                                :style="{resize: 'none', height: '100px'}"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" data-bs-dismiss="modal" @click="() => completeReservation()">Завершить бронирование</button>
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
        <!-- Модалка для указания причины отмены бронирования -->
        <div class="modal fade" id="reasonFailedModal" aria-hidden="true" aria-labelledby="reasonFailedModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reasonFailedModalTitle">Почему отменяется бронь?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="reasonFailed" class="form-label"
                            >Опишите ситуацию</label
                            >
                            <textarea
                                v-model="reason_failed"
                                type="text"
                                class="form-control"
                                id="reasonFailed"
                                placeholder="..."
                                :style="{resize: 'none', height: '100px'}"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal" @click="() => deleteReservation()">Удалить бронирование</button>
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
        <!-- Модалка для отображения гостей в ожидании -->
        <div
            class="modal fade"
            id="waitingList"
            aria-hidden="true"
            aria-labelledby="waitingList"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
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
                            @click="emptyWaitingList"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <!-- Лоадер -->
                        <div class="text-center" v-if="loadingWaitingList">
                            <div
                                class="spinner-grow mt-5 text-success"
                                style="width: 2rem; height: 2rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <!-- Список гостей в листе ожидания -->
                        <ul
                            v-if="waitingList"
                            class="m-0 p-0 list-unstyled waiting_list"
                        >
                            <li
                                v-for="item in waitingList.reservations"
                                :key="item.id"
                                v-if="new Date(item.date).getDate() === new Date(date).getDate()"
                                class="p-1 m-0 cursor border-bottom-2 waiting_guest"
                                :style="{backgroundColor: colorByTime(getExactTime(item.created_at))}"
                                data-bs-toggle="modal"
                                data-bs-target="#updateGuestInfo"
                                @click="updateGuestInfo(item)"
                            >
                                <div>
                                    {{ item.created_at ? getExactTime(new Date(item.created_at)) : null }}. {{ item.name }} [{{ item.amount }}] |
                                    {{ item.phone }}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-danger me-auto"
                            data-bs-toggle="modal"
                            data-bs-target="#clearWaitingListModal"
                        >
                            Очистить список
                        </button>
                        <button
                            class="btn btn-primary"
                            data-bs-target="#AddGuest"
                            data-bs-toggle="modal"
                            data-bs-dismiss="modal"
                        >
                            Добавить в очередь
                        </button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" @click="emptyWaitingList">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Модалка для очищения листа ожидания -->
        <div
            class="modal fade"
            id="clearWaitingListModal"
            tabindex="-1"
            aria-labelledby="clearWaitingListModal"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clearWaitingListModalTitle">
                            Уверены, что хотите очистить лист ожидания?
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="clearWaitingList">
                            <label for="clearWaitingListReason">Причина</label>
                            <input type="text" id="clearWaitingListReason"  class="form-control" v-model="reason_failed"/>
                            <label for="clearWaitingList">Введите пароль</label>
                            <input
                                v-if="showPassword"
                                class="form-control"
                                v-model="password"
                                type="text"
                                id="clearWaitingList"
                                required
                            />
                            <input
                                v-else-if="!showPassword"
                                class="form-control"
                                v-model="password"
                                type="password"
                                id="clearWaitingListHidden"
                                required
                            />
                            <div>
                                <div
                                    class="btn btn-primary btn-sm mt-2"
                                    @click="toggleShow()"
                                >
                                <span class="icon is-small is-right">
                                    Показать пароль
                                </span>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    data-bs-dismiss="modal"
                                >
                                    Очистить лист ожидания
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-bs-dismiss="modal"
                                >
                                    Закрыть
                                </button>
                            </div>
                        </form>
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
                            id="AddTablePasswordCheck1"
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
                            class="btn btn-danger"
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
                                data-bs-dismiss="modal"
                                @click="checkPass(password)"
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
                        <!--Стол и Дата -->
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label class="form-label" for="selectTables"
                                >№ стола</label
                                >
                                <select
                                    id="selectTables"
                                    class="form-control form-select w-75"
                                    v-model="restriction.table_id"
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
                            <div class="col-6">
                                Дата
                                <date-picker
                                    v-model="restriction.date"
                                    format="YYYY-MM-DD"
                                    type="date"
                                    valueType="format"
                                >
                                </date-picker>
                            </div>
                        </div>
                            <!-- Время -->
                            <div class="row">
                                <div class="col-6">
                                    <span>От</span>
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
                                <div class="col-6">
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
                            @click="() => clearRestrictionInfo()"
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
        <!-- Модалка для обновления ограничения по времени -->
        <div
        class="modal fade"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        id="UpdateRestriction"
        tabindex="-1"
        aria-labelledby="UpdateRestrictionModal"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UpdateRestrictionModal">
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
                    <!--Стол и Дата -->
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label" for="selectTables"
                            >№ стола</label
                            >
                            <select
                                id="selectTables"
                                class="form-control form-select w-75"
                                v-model="restriction.table_id"
                                @change="
                                    restriction.table_id = $event.target.value
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
                        <div class="col-6">
                            Дата
                            <date-picker
                                v-model="restriction.date"
                                format="YYYY-MM-DD"
                                type="date"
                                valueType="format"
                            >
                            </date-picker>
                        </div>
                    </div>
                    <!-- Время -->
                    <div class="row">
                        <div class="col-6">
                            <span>От</span>
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
                        <div class="col-6">
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
                        class="btn btn-danger me-auto"
                        @click="() => deleteRestriction()"
                        data-bs-dismiss="modal"
                    >
                        Удалить
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="() => updateRestriction()"
                        data-bs-dismiss="modal"
                    >
                        Обновить
                    </button>
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        @click="() => clearRestrictionInfo()"
                    >
                        Закрыть
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
import 'vue2-datepicker/locale/ru';
import '../../styles/datepicker.scss';

export default {
    name: "Booking",
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
            actionType: "addGuest",
            date: this.datePicker(new Date()),
            from: this.addLeadingZero(new Date().getHours()) + ":" + this.addLeadingZero(new Date().getMinutes()),
            to: "",
            layout: [],
            selected: "Ожидание",
            waitingList: null,
            logs: [],
            colors: ["#FFFF8F", "#19DF01", "#EE4B2B"],
            loading: true,
            loadingWaitingList: false,
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
                table_id: null
            },
            hours: Array.from({ length: 23 }).map((_, i) => i + 11),
            guests: Array.from({ length: 20 }).map((_, i) => i + 1),
            reservation: {
                name: "",
                phone: '',
                conflict: false,
                visit_type: "Обычный визит",
                amount: 1,
                note: "",
                prepayment: 0,
                date: "",
                from: "",
                to: "",
                arrived: false,
                late: false,
                table_id: null,
                place_id: null,
                responsible_email: "",
                responsible_name: "",
            },
            reason_failed: '',
            feedback: ''
        };
    },
    async mounted() {
        this.loading = false;

        axios
            .get("/api/user")
            .then((response) => {
                this.reservation.responsible_name = response.data.name;
                this.reservation.responsible_email = response.data.email;
            })
            .catch((err) => {
                console.log(err);
            });
    },
    computed: {
        reserveFrom () {
            return this.addLeadingZero(new Date().getHours() + ":" + new Date().getMinutes());
        },
        tables() {
            // Все столы, кроме Ожидания
            if (this.place === "place_1") {
                return this.layout.filter(
                    (table) => table.id !== 100 && table.place_id === 1
                );
            }
            if (this.place === "place_2") {
                return this.layout.filter(
                    (table) => table.id !== 102 && table.place_id === 2
                );
            }
            if (this.place === "place_3") {
                return this.layout.filter(
                    (table) => table.id !== 104 && table.place_id === 3
                );
            }
        },
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
    },
    methods: {
        datePicker(value) {
            const date = new Date(value)

            let Y = date.getFullYear();
            let M = this.addLeadingZero(date.getMonth() + 1);
            let D = this.addLeadingZero(date.getDate());

            return `${Y}-${M}-${D}`;
        },
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
            if (newValue >= 12 && newValue < 18) {
                return "#19DF01";
            }
            if (newValue >= 18) {
                return "#FFFB00";
            }
            return null;
        },
        choosePlace(event) {
            this.place = event.target.value;
            this.fetchTables();
        },
        chooseTable(item) {
            this.reservation.table_id = item.id;
            this.restriction.table_id = item.id;
            this.table.id = item.id;
        },
        chooseWaitingTable() {
            if (this.place === 'place_1') {
                this.reservation.table_id = 100;
            }
            if (this.place === 'place_2') {
                this.reservation.table_id = 102;
            }
            if (this.place === 'place_3') {
                this.reservation.table_id = 104;
            }
        },
        clearReservationInfo() {
            this.reservation.id = null;
            this.reservation.name = "";
            this.reservation.phone = "";
            this.reservation.conflict = false;
            this.reservation.visit_type = "Обычный визит";
            this.reservation.amount = 1;
            this.reservation.note = "";
            this.reservation.prepayment = 0;
            this.reservation.table_id = null;
            this.reservation.place_id = null;
            this.reservation.date = "";
            this.reservation.from = "";
            this.reservation.arrived = 0;
            this.reservation.late = 0;
            this.reservation.to = "";

            this.reason_failed = '';
            this.feedback = '';

            this.date = this.datePicker(new Date());
            this.from = this.addLeadingZero(new Date().getHours()) + ":" + this.addLeadingZero(new Date().getMinutes());
            this.to = '';
            // Не очищаю имя и почту ответственного, чтобы использовать на всех 3-х точках
        },
        clearRestrictionInfo() {
            this.restriction.date = new Date();
            this.restriction.from = '';
            this.restriction.to = '';
            this.restriction.table_id = null;
        },
        emptyWaitingList () {
            this.waitingList = null;
        },
        updateGuestInfo(item) {
            this.reservation = {
                id: item.id,
                name: item.name,
                phone: item.phone,
                conflict: item.conflict,
                visit_type: item.visit_type,
                prepayment: item.prepayment === '' ? 0 : item.prepayment,
                amount: item.amount,
                note: item.note,
                table_id: item.table_id,
                place_id: item.place_id,
                date: item.date !== '' ? this.datePicker(item.date) : this.date,
                from: item.from,
                to: item.to,
                arrived: item.arrived,
                late: item.late,
                responsible_email: this.reservation.responsible_email,
                responsible_name: this.reservation.responsible_name,
            };
        },
        checkPass(value) {
            this.password = value;

            if (this.password === process.env.MIX_MASTERKEY && this.actionType === 'changeLayout') {
                this.passCheck = true;
                this.timer = setTimeout(() => {
                    this.passCheck = false;
                }, 600000);
            }
            if (this.password === process.env.MIX_MASTERKEY) {
                this.password = "";
                return true;
            }
            if (this.password !== process.env.MIX_MASTERKEY) {
                alert('Неправильный пароль')
            }
            this.password = "";
        },
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        updateRestrictionInfo(item) {
            this.restriction = {
                ...item,
            }
        },
        async fetchLogs() {
            this.layout = null;
            this.loading = true;
            try {
                const response = await axios.get(
                    "/api/logs"
                );
                this.logs = response.data;
                this.loading = false;
            } catch (error) {
                console.log(error)
            }
        },
        async fetchTables() {
            switch (this.place) {
                case "place_1":
                    try {
                        this.loading = true;
                        const response = await axios.get(
                            "/api/tables"
                        );
                        this.layout = response.data.data.filter((table) => {
                            if (table.place_id === 1) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.loading = false;
                        this.error = error;
                    }
                    break;
                case "place_2":
                    try {
                        this.loading = true;
                        const response = await axios.get(
                            "/api/tables"
                        );
                        this.layout = response.data.data.filter((table) => {
                            if (table.place_id === 2) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.loading = false;
                        this.error = error;
                    }
                    break;
                case "place_3":
                    try {
                        this.loading = true;
                        const response = await axios.get(
                            "/api/tables"
                        );
                        this.layout = response.data.data.filter((table) => {
                            if (table.place_id === 3) {
                                return table;
                            }
                        });
                        this.loading = false;
                    } catch (error) {
                        this.loading = false;
                        this.error = error;
                    }
                    break;
                default:
                    console.log("Default message");
            }
        },
        async bookNow(item) {
            item.booked = !item.booked
            if (this.place === "place_1") {
                try {
                    await axios.put(
                        `/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    this.error = error;
                }
            }
            if (this.place === "place_2") {
                try {
                    await axios.put(
                        `/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    this.error = error;
                }
            }
            if (this.place === "place_3") {
                try {
                    await axios.put(
                        `/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    console.log(error);
                }
            }
        },
        async updateLayout(item) {
            if (this.place === "place_1") {
                try {
                    await axios.put(
                        `/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    this.error = error;
                }
            }
            if (this.place === "place_2") {
                try {
                    await axios.put(
                        `/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    this.error = error;
                }
            }
            if (this.place === "place_3") {
                try {
                    await axios.put(
                        `/api/tables/${item.id}`,
                        item
                    );
                } catch (error) {
                    console.log(error);
                }
            }
        },
        async addGuest() {
            const myModalEl = document.getElementById('AddGuest');
            const modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();
            if (this.place === "place_1") {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    conflict: this.reservation.conflict,
                    visit_type: this.reservation.visit_type,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    prepayment: this.reservation.prepayment === '' ? 0 : this.reservation.prepayment,
                    table_id: this.reservation.table_id,
                    place_id: 1,
                    date: this.date,
                    from: this.from,
                    to: this.to,
                    arrived: this.reservation.arrived,
                    late: this.reservation.late,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };

                try {
                    await axios.post(
                        `/api/reservations`,
                        newReservation
                    );
                    const newLog = {
                        text: `Стол №${newReservation.table_id === 100 ? 'ОЖИДАНИЕ' : newReservation.table_id === 101 ? 'Бар' : newReservation.table_id } на Марата был забронирован.`,
                        type: "Бронирование",
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
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    conflict: this.reservation.conflict,
                    visit_type: this.reservation.visit_type,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    prepayment: this.reservation.prepayment === '' ? 0 : this.reservation.prepayment,
                    table_id: this.reservation.table_id,
                    place_id: 2,
                    date: this.date,
                    from: this.from,
                    to: this.to,
                    arrived: this.reservation.arrived,
                    late: this.reservation.late,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };
                await axios.post(
                    `/api/reservations`,
                    newReservation
                );
                const newLog = {
                    text: `Стол №${newReservation.table_id === 102 ? 'ОЖИДАНИЕ' : newReservation.table_id === 103 ? 'Бар' : newReservation.table_id} на Байкальской был забронирован.`,
                    type: "Бронирование",
                    ...newReservation,
                };
                await axios.post(`/api/logs`, newLog);
            }
            if (this.place === "place_3") {
                const newReservation = {
                    name: this.reservation.name,
                    phone: this.reservation.phone,
                    conflict: this.reservation.conflict,
                    visit_type: this.reservation.visit_type,
                    amount: this.reservation.amount,
                    note: this.reservation.note,
                    prepayment: this.reservation.prepayment === '' ? 0 : this.reservation.prepayment,
                    table_id: this.reservation.table_id,
                    place_id: 3,
                    date: this.date,
                    from: this.from,
                    to: this.to,
                    arrived: this.reservation.arrived,
                    late: this.reservation.late,
                    responsible_email: this.reservation.responsible_email,
                    responsible_name: this.reservation.responsible_name,
                };
                await axios.post(
                    `/api/reservations`,
                    newReservation
                );
                const newLog = {
                    text: `Стол №${newReservation.table_id === 104 ? 'ОЖИДАНИЕ' : newReservation.table_id === 105 ? 'Бар' : newReservation.table_id} на Горной был забронирован.`,
                    type: "Бронирование",
                    ...newReservation,
                };
                await axios.post(`/api/logs`, newLog);
            }
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async updateGuest() {
            if (this.place === "place_1") {
                const updatedGuest = {
                    ...this.reservation,
                    prepayment: this.reservation.prepayment === '' ? 0 : this.reservation.prepayment
                }
                await axios.put(
                    `/api/reservations/${this.reservation.id}`,
                    updatedGuest
                );
                const newLog = {
                    text: `Новые данные гостя.`,
                    type: "Обновление",
                    ...updatedGuest,
                };
                await axios.post(`/api/logs`, newLog);
            }
            if (this.place === "place_2") {
                const updatedGuest = {
                    ...this.reservation,
                    prepayment: this.reservation.prepayment === '' ? 0 : this.reservation.prepayment
                }
                await axios.put(
                    `/api/reservations/${this.reservation.id}`,
                    updatedGuest
                );
                const newLog = {
                    text: `Новые данные гостя.`,
                    type: "Обновление",
                    ...updatedGuest,
                };
                await axios.post(`/api/logs`, newLog);
            }
            if (this.place === "place_3") {
                const updatedGuest = {
                    ...this.reservation,
                    prepayment: this.reservation.prepayment === '' ? 0 : this.reservation.prepayment
                }
                await axios.put(
                    `/api/reservations/${this.reservation.id}`,
                    updatedGuest
                );
                const newLog = {
                    text: `Новые данные гостя.`,
                    type: "Обновление",
                    ...updatedGuest,
                };
                await axios.post(`/api/logs`, newLog);
            }
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async fetchWaitingList() {
            this.loadingWaitingList = true;
            const response = await axios.get(
                "/api/tables"
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
                    if (table.id === 102) {
                        return table;
                    }
                });
            }
            if (this.place === "place_3") {
                this.waitingList = response.data.data.find((table) => {
                    if (table.id === 104) {
                        return table;
                    }
                });
            }
            this.loadingWaitingList = false;
        },
        async clearWaitingList() {
            if(this.password === process.env.MIX_MASTERKEY) {
                const waitingGuests = this.waitingList.reservations.map(guest => guest)
                console.log('Ждуны: ', waitingGuests)
                const reason_failed = this.reason_failed
                async function processArray(array) {
                    for (const guest of array) {
                        const deletedReservation = {
                            reason_failed,
                            ...guest
                        }
                        console.log('Failed: ', deletedReservation)
                        await axios.post(
                            `/api/failed_reservations`,
                            deletedReservation
                        );
                        console.log('Удаляем: ', guest.id)
                        await axios.delete(
                            `/api/reservations/${guest.id}`
                        );

                        const newLog = {
                            text: "Бронирование удалено.",
                            type: "Отмена",
                            reason_failed,
                            ...guest
                        };

                        await axios.post(`/api/logs`, newLog);
                    }
                }
                await processArray(waitingGuests);
            }
            this.clearReservationInfo();
            this.reason_failed = '';
        },
        async deleteReservation() {
            const deletedReservation = {
                reason_failed: this.reason_failed,
                ...this.reservation
            }
            console.log(deletedReservation);
            try {
                await axios.post(
                    `/api/failed_reservations`,
                    deletedReservation
                );
            } catch (error) {
                console.log(error);
            }

            try {
                await axios.delete(
                    `/api/reservations/${this.reservation.id}`
                );
            } catch (error) {
                console.log(error);
            }

            const newLog = {
                text: "Бронирование удалено.",
                type: "Отмена",
                reason_failed: this.reason_failed,
                ...this.reservation
            };

            await axios.post(`/api/logs`, newLog);
            this.clearReservationInfo();
            this.reason_failed = '';
            await this.fetchTables();
        },
        async completeReservation() {
            const completedReservation = {
                feedback: this.feedback,
                ...this.reservation
            }
            try {
                await axios.post(
                    `/api/completed_reservations`,
                    completedReservation
                );
            } catch (error) {
                console.log(error);
            }

            try {
                await axios.delete(
                    `/api/reservations/${this.reservation.id}`
                );
            } catch (error) {
                console.log(error);
            }

            const newLog = {
                text: "Бронирование завершено.",
                type: "Завершено",
                feedback: this.feedback,
                ...this.reservation
            };
            await axios.post(`/api/logs`, newLog);
            this.clearReservationInfo();
            await this.fetchTables();
        },
        async addTable(type, password) {
            if (this.checkPass(password)) {
                if (this.place === "place_1") {
                    console.log('Adding a table')
                    const newTable = {
                        ...this.table,
                        place_id: 1,
                        i: (this.tables.length + 1).toString(),
                        bbq: type,
                        booked: false
                    };
                    await axios.post(
                        "/api/tables",
                        newTable
                    );
                }
                if (this.place === "place_2") {
                    const newTable = {
                        ...this.table,
                        place_id: 2,
                        i: (this.tables.length + 1).toString(),
                        bbq: type,
                        booked: false
                    };
                    await axios.post(
                        "/api/tables",
                        newTable
                    );
                }
                if (this.place === "place_3") {
                    const newTable = {
                        ...this.table,
                        place_id: 3,
                        i: (this.tables.length + 1).toString(),
                        bbq: type,
                        booked: false
                    };
                    await axios.post(
                        "/api/tables",
                        newTable
                    );
                }
            }
            this.loading = true;
            await this.fetchTables();
            this.loading = false;
        },
        async deleteOneTable(password) {
            if (this.checkPass(password)) {
                if (this.place === "place_1") {
                    await axios.delete(
                        `/api/tables/${this.table.id}`
                    );
                }
                if (this.place === "place_2") {
                    await axios.delete(
                        `/api/tables/${this.table.id}`
                    );
                }
                if (this.place === "place_3") {
                    await axios.delete(
                        `/api/tables/${this.table.id}`
                    );
                }
            }
            this.loading = true;
            await this.fetchTables();
            this.loading = false;
        },
        async addRestriction() {
            if (this.place === "place_1") {
                const restriction = {
                    ...this.restriction,
                    table_id: this.table.id,
                    place_id: 1
                };
                try {
                    await axios.post(
                        "/api/restrictions",
                        restriction
                    );
                } catch (error) {
                    alert("Error appeared while posting restriction");
                }
            }
            if (this.place === "place_2") {
                const restriction = {
                    ...this.restriction,
                    table_id: this.table.id,
                    place_id: 2
                };
                try {
                    await axios.post(
                        "/api/restrictions",
                        restriction
                    );
                } catch (error) {
                    alert("Error appeared while posting restriction");
                }
            }
            if (this.place === "place_3") {
                const restriction = {
                    ...this.restriction,
                    table_id: this.table.id,
                    place_id: 3
                };
                try {
                    await axios.post(
                        "/api/restrictions",
                        restriction
                    );
                } catch (error) {
                    alert("Error appeared while posting restriction");
                }
            }
            await this.fetchTables();
        },
        async updateRestriction() {
            if (this.place === "place_1") {
                const restriction = {
                    ...this.restriction
                };

                try {
                    await axios.put(
                        `/api/restrictions/${this.restriction.id}`,
                        restriction
                    );
                } catch (error) {
                    alert("Error appeared while posting restriction");
                }
            }
            if (this.place === "place_2") {
                const restriction = {
                    ...this.restriction,
                };
                try {
                    await axios.put(
                        `/api/restrictions/${this.restriction.id}`,
                        restriction
                    );
                } catch (error) {
                    alert("Error appeared while posting restriction");
                }
            }
            if (this.place === "place_3") {
                const restriction = {
                    ...this.restriction,
                };
                try {
                    await axios.put(
                        `/api/restrictions/${this.restriction.id}`,
                        restriction
                    );
                } catch (error) {
                    alert("Error appeared while posting restriction");
                }
            }
            await this.fetchTables();
        },
        async deleteRestriction() {
            try {
                await axios.delete(
                    `/api/restrictions/${this.restriction.id}`
                );
            } catch (error) {
                console.log(error);
            }
            await this.fetchTables();
        }
    },
};
</script>

<style lang="scss">
// Общий стиль для кнопок на столе
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

// Кнопки на столе
.book_table {
    border-radius: 0;
    position: absolute;
    width: 20px;
    top: 2px;
    padding: 0;
    background-origin: content-box;
    background-color: white;
    box-sizing: border-box;
    cursor: pointer;
}
.add_guest {
    border-radius: 0;
    position: absolute;
    width: 20px;
    top: 2px;
    right: 2px;
    padding: 0;
    background-origin: content-box;
    background-color: white;
    box-sizing: border-box;
    cursor: pointer;
}
.delete_table {
    border-radius: 0;
    position: absolute;
    width: 20px;
    top: 2px;
    right: 2px;
    padding: 0;
    background-origin: content-box;
    background-color: white;
    box-sizing: border-box;
    cursor: pointer;
}
.button_action {
    min-width: 70px;
    transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
    @media (min-width: 2560px) {
        font-size: 25px;
    }
}
.button_action:hover {
    box-shadow: 0 3px 1px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.08),
        0 2px 2px rgba(0, 0, 0, 0.12);
}
.button_action:focus {
    box-shadow: 0 3px 1px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.08),
        0 2px 2px rgba(0, 0, 0, 0.12);
}

// Главная панель, объединяющая Календарь и Инфо Панель
.general_panel {
    background-color: #eef1f4;
    & .date_picker_full {
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
        .place_input {
            height: 50px;
            font-weight: 600;
            color: #3c4655;
            background-color: white;
            border: 1px none;
            @media (min-width: 2560px) {
                font-size: 20px;
            }
        }
        p {
            font-weight: 500;
            @media (min-width: 2560px) {
                font-size: 25px;
            }
        }
    }
    & .date_full_mobile {
        @media (min-width: 375px) and (max-width: 767px) {
            display: block;
        }
        @media (min-width: 768px) {
            display: none;
        }
    }
    & .card {
        width: 70px;
        height: 70px;
        @media (min-width: 576px) {
            width: 74px;
            height: 74px;
        }
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
        & .card_content_info {
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
        & .card-body {
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

                @media (min-width: 375px) {
                    display: none;
                }
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

// Информационная панель с кнопками и иконками
.info_panel {
    @media (min-width: 1500px) {
        margin-top: 20px;
    }
    & .info_panel_icons {
        background-color: white;

        & .info_panel_icons_icon {
            width: 15px;
        }
    }
}

// Стиль стола (grid)
.grid_item {
    background-color: #3E2C41;
    touch-action: none;

    .grid_item_locked {
        width: 20px;
    }
}

// Инфо о столе (Номер, иконки)
.table_info {
    & .table_info_bar {
        color: #FFF0F5;
        font-weight: 600;
    }
    & .table_info_icon_table {
        width: 15px;
        padding-bottom: 3px;
    }
}

// Инфо об ограничении по времени
.restriction_time {
    & .restriction_time_lock {
        width: 15px;
        padding-bottom: 3px;
        margin-left: auto
    }
    & .restriction_time_info {
        color: white;
    }
}

// Лист бронирований и отображение гостей
.reservation_list {
    & .arrived {
        background-color: #03a9f4!important;
    }
    & .late {
        background-color: #EE4B2B!important;
    }
    & .reservation_item {
        padding: 2px;
        font-size: 10px;
        @media (min-width: 1500px) {
            font-size: 20px;
        }
        border-bottom: 1px solid black;
            & .reservation_item_info {
                display: flex;
                justify-content: flex-start;
                align-items: center;
                vertical-align: center;

                & img {
                    margin-right: 2px;
                    width: 10px;
                    @media (min-width: 1500px) {
                        width: 15px;
                    }
                }
            }
    }
}

// Лист ожидания и отображение гостей
.waiting_list {
    & .waiting_guest {
        font-size: 12px;
        border-bottom: 1px solid black;
    }
}
</style>
