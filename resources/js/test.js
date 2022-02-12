// операторы сравнения

let x = 10
let y = 5
let res = x > y
console.log('x == 10', x == 10)

let a = 'a'
let z = 'z'

console.log('a > z', a > z)

let str1 = 'abc'
let str2 = 'abb'
console.log('str1 > str2', str1 > str2)

console.log("'1' == 1", '1' == 1)
console.log("'1' === 1", '1' === 1)

let variable0 = '0'
let variable1 = 0

console.log(Boolean(variable0), Boolean(variable1))
console.log(variable0 == variable1)

console.log('null > 0', null > 0)
console.log('null == 0', null == 0) // этот оператор сравнения не приводит null к 0, по этому false
console.log('null >= 0', null >= 0)

console.log('undefined > 0', undefined > 0)
console.log('undefined == 0', undefined == 0)
console.log('undefined >= 0', undefined >= 0)

let answer = prompt('какой сейчас год?')
if (answer == 2022) {
    alert('правильно')
} else if (answer < 2022) {
    alert('Вы что, из прошлого?')
} else {
    alert('вы что, из будущего?')
}

let age = 2
let access = age > 18 ? 'access granted' : 'acess denied'
console.log('access', access)

let haveLicence = true
let number1 = 123
let string1 = ''

res = number1 || string1 || haveLicence

// При использовании опратора сравнения (||) 
// Он присваевает первое значение, которое выполняет условие
// (в данном случае res = 123)
// Если ни одно условие не выполняется,
// то будет присвоено значение последней переменной

if (res) {
    console.log('yes')
} else {
    console.log('no')
}
console.log('res = ', res)

res = string1 && number1 && haveLicence

// Тут будет присвоено первое значение, которое
// не выполняет условие (так как дальше можно и не 
// проверять), в данном случае пустая строка

if (res) {
    console.log('yes')
} else {
    console.log('no')
}
console.log('res = ', res)

// циклы
 let i = 0
 while (i < 10) {
     console.log(i++)
 }

 let j = 0
 for (let j = 0; j < 5; j++) {
     if (j == 2) {
         // break // выход из цикла
        continue //перейти на следующую итерацию не останавливая цикл
     }
     console.log('j = ', j)
 }
 console.log('j = ', j)
//  тут используется глобальная переменная,
//  а та, которая обьявлена
//  внутри for доступна только внутри цикла,
//  там можно второй раз обьявить ее через let
//  (тем не менее в цикле можно использовать
//  и глобальную  переменную, (без let)
//  тогда она станет доступна вне цикла)