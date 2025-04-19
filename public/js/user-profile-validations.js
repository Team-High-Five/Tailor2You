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

    // Validate first name
    const firstName = document.getElementById('first_name').value.trim();
    if (firstName === '') {
        document.getElementById('first_name_err').textContent = 'Please enter the shop name';
        isValid = false;
    } else {
        document.getElementById('first_name_err').textContent = '';
    }

    // Validate last name
    const lastName = document.getElementById('last_name').value.trim();
    if (lastName === '') {
        document.getElementById('last_name_err').textContent = 'Please enter the owner\'s name';
        isValid = false;
    } else {
        document.getElementById('last_name_err').textContent = '';
    }

    // Validate phone number
    const phoneNumber = document.getElementById('phone_number').value.trim();
    if (phoneNumber === '') {
        document.getElementById('phone_number_err').textContent = 'Please enter the phone number';
        isValid = false;
    } else {
        document.getElementById('phone_number_err').textContent = '';
    }

    // Validate NIC
    const nic = document.getElementById('nic').value.trim();
    if (nic === '') {
        document.getElementById('nic_err').textContent = 'Please enter the NIC';
        isValid = false;
    } else {
        document.getElementById('nic_err').textContent = '';
    }

    // Validate birth date
    const birthDate = document.getElementById('birth_date').value.trim();
    if (birthDate === '') {
        document.getElementById('birth_date_err').textContent = 'Please enter the birth date';
        isValid = false;
    } else {
        document.getElementById('birth_date_err').textContent = '';
    }

    // Validate home town
    const homeTown = document.getElementById('home_town').value.trim();
    if (homeTown === '') {
        document.getElementById('home_town_err').textContent = 'Please enter the home town';
        isValid = false;
    } else {
        document.getElementById('home_town_err').textContent = '';
    }

    // Validate address
    const address = document.getElementById('address').value.trim();
    if (address === '') {
        document.getElementById('address_err').textContent = 'Please enter the address';
        isValid = false;
    } else {
        document.getElementById('address_err').textContent = '';
    }

    // Validate bio
    const bio = document.getElementById('bio').value.trim();
    if (bio === '') {
        document.getElementById('bio_err').textContent = 'Please enter the bio';
        isValid = false;
    } else {
        document.getElementById('bio_err').textContent = '';
    }

    return isValid;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}