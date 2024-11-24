<style>
/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px;
    font-family: 'Arial', sans-serif;
}

/* Heading */
.heading {
    text-align: center;
    margin-bottom: 40px;
    font-size: 28px;
    font-weight: 600;
    color: #333;
}

/* Form */
.add-user form {
    margin-bottom: 40px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.add-user label {
    font-size: 16px;
    margin-bottom: 8px;
    color: #555;
    display: block;
}

.add-user input,
.add-user select {
    padding: 10px;
    margin-bottom: 15px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    color: #333;
}

.add-user button {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    max-width: 200px;
    margin-top: 15px;
    margin-left: auto;
    margin-right: auto;
    display: block;
}

.add-user button:hover {
    background-color: #0056b3;
}

.add-user h3 {
    text-align: center;
}
</style>

<div class="container">

    <!-- Form Thêm Người Dùng -->
    <div class="add-user">
        <h3>Thêm Người Dùng Mới</h3>
        <form id="add-user-form" method="POST">
            <div>
                <label for="username">Tên người dùng:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone">
            </div>

            <div>
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address">
            </div>

            <div>
                <label for="role">Vai trò:</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="editor">Editor</option>
                    <option value="viewer">Viewer</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Người Dùng</button>
        </form>
    </div>
</div>