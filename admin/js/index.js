document.addEventListener('DOMContentLoaded', () => {
    // Lấy tất cả các liên kết trong navbar
    const links = document.querySelectorAll('.navbar .nav-link');
    // Lấy tất cả các phần tử nội dung
    const contents = document.querySelectorAll('.content');

    // Kiểm tra trạng thái lưu trong localStorage
    const activeContentId = localStorage.getItem('activeContentId') || 'content-default'; // Mặc định là 'content-default'

    // Hiển thị nội dung tương ứng với trạng thái lưu
    contents.forEach(content => content.style.display = 'none'); // Ẩn tất cả nội dung
    const targetContent = document.getElementById(activeContentId);
    if (targetContent) {
        targetContent.style.display = 'block';
    }

    // Thêm sự kiện click cho từng liên kết
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = 'content-' + link.textContent.trim().toLowerCase().replace(' ', '-'); // Tạo ID mục tiêu

            // Ẩn tất cả nội dung
            contents.forEach(content => content.style.display = 'none');

            // Hiển thị nội dung tương ứng
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.style.display = 'block';
                // Lưu trạng thái vào localStorage
                localStorage.setItem('activeContentId', targetId);
            }
        });
    });
});
