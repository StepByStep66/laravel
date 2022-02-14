const answer = prompt('сколько будет 2 + 2?') //prompt возвращает строку
switch (answer) {
    case '4': {
        console.log('right!')
        break
    }
    case '3': {
        console.log('more!')
        break
    }
    case '5': {
        console.log('less!')
        break
    }
    default: {
        console.log('not right')
        break
    }
}

//функции

function sayHello () {
    str = 'Hello World!'
    console.log('Внутри функции', str)
}

let str = 'Hello'

sayHello()

console.log('после функции', str)

function sum(a, b = 0) { //b задано по умолчанию, если не передается. так объявленные ф-ции доступны из любой части файла
    console.log(a + b)
}

let a = 10
let b = 15

sum(1)

function fullName (firstName, lastName) {
    return firstName + ' ' + lastName
}
let myName = fullName('Stepan', 'Sarasek')
console.log('name = ', myName)

let sayHelloWorld = function () { //так объявленные ф-ции доступны только ПОСЛЕ их объявления
    console.log('Hello, World!')
}

console.log('sayHelloWorld', sayHelloWorld)
sayHelloWorld()

function callBackExample (access, accept, decline) {
    if (access) {
        accept()
    } else {
        decline()
    }
}

const accept = function () {
    alert('Доступ предоставлен')
}
const decline = function () {
    alert('Доступ запрещен')
}
callBackExample(false, accept, decline)

let arrowFunc = (a, b, c) => a + b + c

console.log(arrowFunc(1, 2, 3))

arrowFunc = function (a, b, c) {
    return a + b + c
}

console.log(arrowFunc(4, 5, 6))

let newArrowFunc = (a, b) => {
    console.log('Запустили стрелочную функцию newArrowFunc')
    return a + b
}
console.log(newArrowFunc(4, 6))

//Объекты

let user = {
    name: 'Stepan',
    age: 36
}
console.log(user)

console.log('user.name', user.name)
user.age = 37
console.log(user)

delete user.age
console.log(user)

user.age = 37
console.log(user)

for (key in user) {
    //console.log(key)
    console.log(user[key])
}

console.log('name' in user)
console.log('car' in user)
