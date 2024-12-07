function inputOnlyNumber(event) {
    const key = event.key;

    if (key === 'Backspace' || key === 'Delete' || key === 'ArrowUp' || key === 'ArrowDown') {
        return;
    }

    if (!/^[0-9]$/.test(key)) {
        event.preventDefault();
    }
}



function inputDotAndNumber(event) {
    const key = event.key;

    if (key === 'Backspace' || key === 'Delete') {
        return;
    }

    if (!/^[0-9.]$/.test(key)) {
        event.preventDefault();
    }

    if (key === '.' && event.target.value.includes('.')) {
        event.preventDefault();
    }
}
