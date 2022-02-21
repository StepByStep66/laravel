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
                        <a :href="`/category/${category.id}`">
                            {{ category.name }}
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <button @click="addCategory" class="btn btn-primary">Добавить категорию</button>
        {{ fullName }}
        <br>
        <input v-model="inputText" @input="listenInput" class="form-control">
        <br>
        <input v-model="name" class="form-control">
        <br>
        <input v-model="text" class="form-control">
        <br>
        {{ reversedText }}
        <br>
        {{ reverseText() }}
        <br>
        <select v-model="selected" @change="selectChanged" class="form-control mb-5">
            <option :value="null" selected disabled>-- Please, select --</option>
            <option v-for="(option, idx) in options" :value="option" :key="idx">
                {{ option }}
            </option>
        </select>
        <br>
        <button :disabled="!selected" class="btn mt-5" :class="{'btn-success' : selected}">Добавление класса кнопки</button>
        <button :disabled="!selected" class="btn mt-5" :class="buttonClass">Смена класса кнопки</button>
        <br>
        <button @click='getData' class="btn btn-primary">Получить данные</button>
        <table class="table table-bordered">
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                </tr>
                <tr v-if="!users.length">
                    <td class="text-center" colspan="3">
                        <em>
                            Данных нет
                        </em>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                users: [],
                selected: null,
                inputText: '',
                name: 'Stepan',
                lastName: 'Sarasek',
                counter: 0,
                showPicture: true,
                options: [1, 2, 3],
                text: '',
                categories: [
                    {
                        id: 12,
                        name: 'Видеокарты'
                    },
                    {
                        id: 13,
                        name: 'Процессоры'
                    }
                ]
            }
        },
        watch: {
            selected: function (newValue, oldValue) {
                console.log(`новое значение: ${newValue}, старое значение: ${oldValue}`)
            }
        },
        computed: {
            buttonClass () {
                return this.selected ? 'btn-success' : 'btn-primary'
            },
            fullName () {
                return this.name + ' ' + this.lastName
            },
            reversedText () {
                return this.text.split('').reverse().join('')
            },
        },
        methods: {
            getData () {
                const params = {
                    id: 20
                }
                axios.post('/api/test', params)
                    .then(Response => {
                        this.users = Response.data
                    })
            },
            selectChanged () {
                console.log('Значение селекта изменилось')
                console.log(this.selected)
            },
            reverseText () {
                return this.text.split('').reverse().join('')
            },
            listenInput () {
                console.log(this.inputText)
            },
            addCategory () {
                this.categories.push({
                    id: 14,
                    name: 'Чипы'
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
