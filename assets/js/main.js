function clearMessageParameter() {
    const urlParams = new URLSearchParams(window.location.search);

    // Kiểm tra nếu tham số 'message' tồn tại
    if (urlParams.has('message') && urlParams.has('type')) {
        // Xóa tham số 'message'
        urlParams.delete('message');
        urlParams.delete('type');
        // Tạo URL mới không có tham số 'message'
        const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + urlParams.toString();
        // Thay thế URL hiện tại mà không thêm vào lịch sử
        window.history.replaceState(null, '', newUrl);
    }
}

// Gọi hàm khi tải trang
window.onload = function () {
    clearMessageParameter();
};