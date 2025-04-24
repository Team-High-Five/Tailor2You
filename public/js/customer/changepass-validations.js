document.getElementById('changePasswordForm').addEventListener('blur', function (e) {
    if (e.target.tagName === 'INPUT') {
        validateChangePasswordField(e.target);
    }
}, true);

document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
    if (!validateChangePasswordForm()) {
        e.preventDefault();
    }
});

function validateChangePasswordForm() {
    let isValid = true;
    document.querySelectorAll('#changePasswordForm .form-group input').forEach(function (field) {
        validateChangePasswordField(field);
        if (document.getElementById(field.name + '_err') && document.getElementById(field.name + '_err').textContent !== '') {
            isValid = false;
        }
    });
    return isValid;
}

function validateChangePasswordField(field) {
    const fieldName = field.name;
    const value = field.value.trim();
    let errorMessage = '';

    switch (fieldName) {
        case 'current_password':
            if (value === '') {
                errorMessage = 'Current password is required';
            }
            break;
        case 'new_password':
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
            if (!passwordPattern.test(value)) {
                errorMessage = 'New password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character';
            }
            break;
        case 'confirm_password':
            const newPassword = document.querySelector('input[name="new_password"]').value;
            if (value !== newPassword) {
                errorMessage = 'Passwords do not match';
            }
            break;
    }

    const errorElement = document.getElementById(fieldName + '_err');
    if (errorElement) {
        errorElement.textContent = errorMessage;
    }
}