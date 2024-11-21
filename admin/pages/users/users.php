<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>USERS</title>
</head>
<body>
    <?php
        require 'config.php';
        $query = "SELECT * FROM users";
        $result = mysqli_query($connect, $query);
    ?>
    <div class="container mt-5">
        <a href="/BetaCinema_Clone/admin/pages/users/add_users.php" class="btn btn-success text-center mt-5">THÊM MỚI USER</a>
        <table class="table table-info table-bordered border-info table-striped mt-3">
            <thead>
                <tr class="text-center">
                    <th scope="col">ID</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mật khẩu</th>
                    <th scope="col">Ngày sinh</th>
                    <th scope="col">Giới tính</th>
                    <th scope="col">SĐT</th>
                    <th scope="col">Role</th>
                    <th scope="col">Function</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='text-center'>";
                    echo "<td>" . htmlspecialchars($row['UserID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Pass_word']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Dob']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Sex']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Role']) . "</td>";
                    echo "<td>
                            <a href='/BetaCinema_Clone/admin/pages/users/edit_users.php?id=" . htmlspecialchars($row['UserID']) . "' class='btn btn-warning btn-sm'>SỬA</a>
                            <a href='/BetaCinema_Clone/admin/pages/users/delete_users.php?id=" . htmlspecialchars($row['UserID']) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xoá user này không?');\">XOÁ</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<style>
    thead th {
        white-space: nowrap; 
        overflow: hidden;  
        text-overflow: ellipsis; 
        max-width: 100px; 
    }

    tbody td {
        white-space: nowrap; 
        overflow: hidden;  
        text-overflow: ellipsis; 
        max-width: 150px; 
    }
</style>
</html>