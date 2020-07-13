function join(arr, concatStr) {
    var result = '';
    var lastWord = arr.length - 1;
    for (var i = 0; i < lastWord; i++) {
        result += arr[i] + concatStr
    }
    return result + arr[lastWord]
}

function repeat(str, times) {
    var answer = '';
    for (var i = 1; i <= times; i++) {
        answer += str
    }
    return answer
}

console.log(join(['a'], '!'));
console.log(repeat('a', 5));
