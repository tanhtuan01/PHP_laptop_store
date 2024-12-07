function inputOnlyNumber(event) {
    const key = event.key;

    // Cho phép phím Backspace, Delete, ArrowUp, ArrowDown
    if (key === 'Backspace' || key === 'Delete' || key === 'ArrowUp' || key === 'ArrowDown') {
        return; // Không làm gì, cho phép các phím này
    }

    // Kiểm tra nếu phím không phải là một số (0-9)
    if (!/^[0-9]$/.test(key)) {
        event.preventDefault();  // Ngừng hành động mặc định, ngăn không cho nhập ký tự không hợp lệ
    }
}



function inputDotAndNumber(event) {
    const key = event.key;  // Lấy giá trị phím được nhấn

    // Cho phép xóa khi nhấn phím Backspace hoặc Delete
    if (key === 'Backspace' || key === 'Delete') {
        return;  // Không làm gì, cho phép xóa
    }

    // Nếu phím không phải là một số (0-9) hoặc dấu '.'
    if (!/^[0-9.]$/.test(key)) {
        event.preventDefault();  // Ngừng hành động mặc định
    }

    // Nếu phím là dấu '.', kiểm tra nếu đã có dấu '.' trong giá trị rồi thì không cho nhập thêm
    if (key === '.' && event.target.value.includes('.')) {
        event.preventDefault();  // Ngừng hành động nếu đã có dấu '.' trong chuỗi
    }
}
