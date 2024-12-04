document.getElementById('profileForm').addEventListener('input', function (e) {
    validateField(e.target);
});

document.getElementById('profileForm').addEventListener('submit', function (e) {
    if (!validateForm()) {
        e.preventDefault();
    }
});

function validateField(field) {
    const fieldName = field.name;
    const value = field.value.trim();
    let errorMessage = '';

    switch (fieldName) {
        case 'first_name':
            if (value === '') {
                errorMessage = 'Shop name is required';
            }
            break;
        case 'last_name':
            if (value === '') {
                errorMessage = 'Owner\'s name is required';
            }
            break;
        case 'email':
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(value)) {
                errorMessage = 'Invalid email address';
            }
            break;
        case 'phone_number':
            const phonePattern = /^\d{10}$/;
            if (!phonePattern.test(value)) {
                errorMessage = 'Invalid phone number';
            }
            break;
        case 'nic':
            const nicPattern = /^(\d{9}[vVxX]|\d{12})$/;
            if (!nicPattern.test(value)) {
                errorMessage = 'Invalid NIC number';
            }
            break;
        case 'birth_date':
            const today = new Date();
            const minDate = new Date('1900-01-01');
            const maxDate = new Date(today.getFullYear() - 12, today.getMonth(), today.getDate());
            const birthDate = new Date(value);
            if (birthDate < minDate || birthDate > maxDate) {
                errorMessage = `Birth date must be between ${minDate.toISOString().split('T')[0]} and ${maxDate.toISOString().split('T')[0]}`;
            }
            break;
        case 'home_town':
            if (value === '') {
                errorMessage = 'Home town is required';
            }
            break;
        case 'address':
            if (value === '') {
                errorMessage = 'Address is required';
            }
            break;
        case 'bio':
            if (value === '') {
                errorMessage = 'Bio is required';
            }
            break;
    }

    document.getElementById(fieldName + '_err').textContent = errorMessage;
}

function validateForm() {
    let isValid = true;
    document.querySelectorAll('#profileForm .form-group input, #profileForm .form-group textarea').forEach(function (field) {
        validateField(field);
        if (document.getElementById(field.name + '_err').textContent !== '') {
            isValid = false;
        }
    });
    return isValid;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}