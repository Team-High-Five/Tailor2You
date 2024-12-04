document.getElementById('createPasswordForm').addEventListener('blur', function (e) {
    validatePasswordField(e.target);
}, true);

document.getElementById('createPasswordForm').addEventListener('submit', function (e) {
    if (!validatePasswordForm()) {
        e.preventDefault();
    }
});

function validatePasswordField(field) {
    const fieldName = field.name;
    const value = field.value.trim();
    let errorMessage = '';

    switch (fieldName) {
        case 'password':
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
            if (!passwordPattern.test(value)) {
                errorMessage = 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character';
            }
            break;
        case 'confirm_password':
            const password = document.querySelector('input[name="password"]').value;
            if (value !== password) {
                errorMessage = 'Passwords do not match';
            }
            break;
    }

    document.getElementById(fieldName + '_err').textContent = errorMessage;
}

function validatePasswordForm() {
    let isValid = true;
    document.querySelectorAll('#createPasswordForm .form-line input').forEach(function (field) {
        validatePasswordField(field);
        if (document.getElementById(field.name + '_err').textContent !== '') {
            isValid = false;
        }
    });
    return isValid;
}