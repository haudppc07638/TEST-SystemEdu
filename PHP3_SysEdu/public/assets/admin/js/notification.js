document.addEventListener('DOMContentLoaded', function () {
    // Kiểm tra và lấy dữ liệu các chuyên ngành theo khoa
    var facultyMajors = document.getElementById('faculty-majors-data');
    if (facultyMajors) {
        facultyMajors = JSON.parse(facultyMajors.textContent);
    }

    // Hàm hiển thị các trường thông tin tùy thuộc vào loại người nhận
    function toggleRecipientFields() {
        var recipientType = document.getElementById('recipient_type').value;
        var studentsFields = document.getElementById('students-fields');
        var teachersFields = document.getElementById('teachers-fields');
        var typeSelect = document.getElementById('type');
        
        // Hiển thị hoặc ẩn các trường tùy theo loại người nhận
        studentsFields.style.display = recipientType === 'students' ? 'block' : 'none';
        teachersFields.style.display = recipientType === 'teachers' ? 'block' : 'none';

        // Reset các trường nếu là sinh viên
        if (recipientType === 'students') {
            document.getElementById('faculties').value = '';
            document.getElementById('majors-checkboxes').innerHTML = '';
        }

        // Cho phép chọn cả hai hình thức gửi
        if (recipientType === 'students') {
            typeSelect.querySelector('option[value="system"]').disabled = false;
            typeSelect.querySelector('option[value="email"]').disabled = false;
        }
    }

    // Hàm cập nhật các chuyên ngành theo khoa
    function updateMajors() {
        var departmentId = document.getElementById('faculties').value;
        var majorsCheckboxes = document.getElementById('majors-checkboxes');

        majorsCheckboxes.innerHTML = ''; // Xóa các checkbox cũ

        if (departmentId && facultyMajors[departmentId]) {
            facultyMajors[departmentId].forEach(major => {
                var checkbox = document.createElement('div');
                checkbox.classList.add('form-check');
                checkbox.innerHTML = `
                    <div class="checkbox-wrapper-28">
                        <input type="checkbox" class="promoted-input-checkbox" id="major_${major.id}" name="majors[]" value="${major.id}" />
                        <svg><use xlink:href="#checkmark-28" /></svg>
                        <label for="major_${major.id}">
                            ${major.name} 
                        </label>
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                            <symbol id="checkmark-28" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-miterlimit="10" fill="none"  d="M22.9 3.7l-15.2 16.6-6.6-7.1" />
                            </symbol>
                        </svg>
                    </div>
                `;
                majorsCheckboxes.appendChild(checkbox);
            });
        }
    }

    // Đảm bảo rằng các phần tử tồn tại trước khi gán sự kiện
    var recipientTypeElement = document.getElementById('recipient_type');
    var facultiesElement = document.getElementById('faculties');

    if (recipientTypeElement) {
        recipientTypeElement.addEventListener('change', toggleRecipientFields);
    }

    if (facultiesElement) {
        facultiesElement.addEventListener('change', updateMajors);
    }

    // Gọi hàm để cập nhật các trường ngay khi load trang nếu có giá trị mặc định
    toggleRecipientFields();
    updateMajors();
});
