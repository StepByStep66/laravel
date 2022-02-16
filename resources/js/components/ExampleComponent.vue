<template>
    <div>
        Example Component
        <br>
        {{ name }}
        <br>
        <button v-on:click="counterPlus" class="btn btn-info">Click: {{counter}}</button>
        <br>
        <span v-if="counter < 10">Значение counter меньше 10</span>
        <span v-else-if="counter < 15">Значение counter меньше 15</span>
        <span v-else>Значение counter больше или равно 15</span>
        <br>
        <span v-show="counter < 10">Значение counter меньше 10</span>
        <br>
        <button @click="showPicture = !showPicture" class="btn btn-success">Переключатель</button>
        <br>
        <img v-if="showPicture" style="width: 200px;" src="http://s1.iconbird.com/ico/0612/shine7/w128h1281339405365bulb3.png">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Категория</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(category, index) in categories" :key="category.id">
                    <td>
                        {{ index + 1 }}
                    </td>
                    <td>
                        {{ category.name }}
                    </td>
                </tr>
            </tbody>
        </table>
        <button @click="addCategory" class="btn btn-primary">Добавить категорию</button>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                name: 'Stepan',
                counter: 0,
                showPicture: true,
                categories: [
                    {
                        id: 1,
                        name: 'Видеокарты'
                    },
                    {
                        id: 2,
                        name: 'Процессоры'
                    }
                ]
            }
        },
        methods: {
            addCategory () {
                this.categories.push({
                    id: 4,
                    name: 'Оперативная память'
                })
            },
            counterPlus () {
                this.counter +=1
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>

</style>
