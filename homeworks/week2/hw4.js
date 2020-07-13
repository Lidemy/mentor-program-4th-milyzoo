function printFactor(n) {
    for (var i = 1; i <= n; i++) {
        if (i <= n && n % i === 0) {
            console.log(i)
        }
    }
}

printFactor(10);
