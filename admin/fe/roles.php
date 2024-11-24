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
    .add-role form {
        margin-bottom: 40px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .add-role label {
        font-size: 16px;
        margin-right: 10px;
        color: #555;
    }

    /* Flexbox để sắp xếp Tên Quyền và Slug cùng một hàng */
    .add-role .form-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .add-role .form-group>div {
        flex: 1;
        margin-right: 15px;
    }

    /* Input và Select */
    .add-role input,
    .add-role select {
        padding: 10px;
        margin-bottom: 0;
        width: 100%;
        max-width: 400px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        color: #333;
    }

    .add-role button {
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        width: 200px;
        margin-top: 15px;
    }

    .add-role button:hover {
        background-color: #0056b3;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 15px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 16px;
    }

    th {
        background-color: #f4f4f4;
        font-weight: 600;
        color: #333;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #e9e9e9;
    }

    /* Buttons */
    .btn {
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>

<div class="container">
    <h2 class="heading">Quản Lý Quyền Người Dùng</h2>

    <!-- Form Thêm Quyền -->
    <div class="add-role">
        <h3>Thêm Quyền Mới</h3>
        <form id="add-role-form" method="POST">
            <div class="form-group">
                <div>
                    <label for="roleName">Tên Quyền:</label>
                    <input type="text" id="roleName" name="roleName" required>
                </div>

                <div>
                    <label for="role">Quyền</label>
                    <select id="role" name="role" required>
                        <option value="ADMIN">ADMIN</option>
                        <option value="USER">USER</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label for="roleDescription">Mô tả Quyền:</label>
                    <textarea rows="3" style="width: 100%;padding: 5px;border-radius: 5px; resize: none" type="text"
                        id="roleDescription" name="roleDescription" required></textarea>
                </div>

            </div>




            <button type="submit" class="btn btn-primary">Thêm Quyền</button>
        </form>
    </div>

    <!-- Danh Sách Quyền Người Dùng -->
    <div class="role-list">
        <h3>Danh Sách Quyền Người Dùng</h3>
        <table id="role-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên Quyền</th>
                    <th>Mô tả Quyền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dữ liệu quyền sẽ được thêm vào đây -->
            </tbody>
        </table>
    </div>
</div>