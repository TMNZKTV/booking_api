<template>
    <div>
        <div class="ml-auto my-3">
            <span>Вы выбрали ресторан на </span>
            <select v-model="place" name="places" @change="choosePlace($event)">
                <option value="" selected>...</option>
                <option value="place_1">Марата</option>
                <option value="place_2">Байкальской</option>
                <option value="place_3">Горной</option>
            </select>
        </div>

        <h1 v-if="place === ''" class="text-center my-5">Пожалуйста, выберите ресторан</h1>

        <ul v-else class="list-group">
            <li v-for="log in logs" class="list-group-item">{{ log }}</li>
        </ul>




    </div>
</template>

<script>
export default {
    name: "History.vue",
    data() {
        return {
            logs: [],
            place: ''
        }
    },
    methods: {
        choosePlace($event) {
            this.place = $event.target.value;
            this.fetchLogs();
        },
        fetchLogs() {
            this.logs.push(1);
        }
    }
}
</script>

<style scoped>

</style>
