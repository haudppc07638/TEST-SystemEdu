
document.addEventListener('DOMContentLoaded', function () {
    // Tạo một đối tượng để lưu trữ các chuyên ngành theo khoa
    var facultyMajors = JSON.parse(document.getElementById('faculty-majors-data').textContent);

    function toggleRecipientFields() {
        var recipientType = document.getElementById('recipient_type').value;
        var studentsFields = document.getElementById('students-fields');
        var teachersFields = document.getElementById('teachers-fields');
        var typeSelect = document.getElementById('type');
        studentsFields.style.display = recipientType === 'students' ? 'block' : 'none';
        teachersFields.style.display = recipientType === 'teachers' ? 'block' : 'none';

        if (recipientType === 'students') {
            document.getElementById('faculties').value = '';
            document.getElementById('majors-checkboxes').innerHTML = '';
        }

        if (recipientType === 'students') {
            studentsFields.style.display = 'block';
            teachersFields.style.display = 'none';

            // Cho phép chọn cả hai hình thức gửi
            typeSelect.querySelector('option[value="system"]').disabled = false;
            typeSelect.querySelector('option[value="email"]').disabled = false;
        } else if (recipientType === 'teachers') {
            studentsFields.style.display = 'none';
            teachersFields.style.display = 'block';

            // Chỉ cho phép chọn email
            typeSelect.querySelector('option[value="system"]').disabled = true;
            if (typeSelect.value === 'system') {
                typeSelect.value = 'email'; // Nếu chọn hệ thống, tự động chuyển về email
            }
            typeSelect.querySelector('option[value="email"]').disabled = false;
        }

    }

    function updateMajors() {
        var departmentId = document.getElementById('faculties').value;
        var majorsCheckboxes = document.getElementById('majors-checkboxes');

        majorsCheckboxes.innerHTML = ''; // Clear previous checkboxes

        if (departmentId && facultyMajors[departmentId]) {
            facultyMajors[departmentId].forEach(major => {
                var checkbox = document.createElement('div');
                checkbox.classList.add('form-check');
                checkbox.innerHTML = `
                    <div class="checkbox-wrapper-28">
                        <input type="checkbox" class="promoted-input-checkbox" id="major_${major.id}" name="majors[]"   value="${major.id}"/>
                        <svg><use xlink:href="#checkmark-28" /></svg>
                        <label for="major_${major.id}">
                            ${major.name} 
                        </label>
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                            <symbol id="checkmark-28" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-miterlimit="10" fill="none"  d="M22.9 3.7l-15.2 16.6-6. 6-7.1">
                                </path>
                            </symbol>
                        </svg>
                    </div>
                `;
                majorsCheckboxes.appendChild(checkbox);
            });
        }
    }

    // Attach event listeners
    document.getElementById('recipient_type').addEventListener('change', toggleRecipientFields);
    document.getElementById('faculties').addEventListener('change', updateMajors);
});



