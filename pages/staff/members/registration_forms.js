// ===== MODERN STEP-BASED REGISTRATION SYSTEM =====

// State Management
let currentStep = 1;
let selectedPlanType = null;
let selectedPlanName = '';
let selectedPlanPrice = 0;
let membershipDuration = 1;
let instructorSessions = 1;
let selectedPaymentMethod = 'gcash';

// ===== NAVIGATION FUNCTIONS =====

function showRegistrationForm() {
    hideAllRegStates();
    document.getElementById('regStepFlow').classList.add('active');
    goToStep(1);
}

function navigateBackToCards() {
    hideAllRegStates();
    document.getElementById('regCardSelection').classList.add('active');
    resetRegistrationFlow();
}

function resetToCards() {
    navigateBackToCards();
}

function hideAllRegStates() {
    document.querySelectorAll('.reg-state').forEach(state => {
        state.classList.remove('active');
    });
}

function resetRegistrationFlow() {
    currentStep = 1;
    selectedPlanType = null;
    selectedPlanName = '';
    selectedPlanPrice = 0;
    membershipDuration = 1;
    instructorSessions = 1;
    selectedPaymentMethod = 'gcash';

    // Clear all inputs
    document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"]').forEach(input => {
        input.value = '';
    });

    // Reset checkboxes
    const instructorCheckbox = document.getElementById('instructorCheckbox');
    if (instructorCheckbox) instructorCheckbox.checked = false;

    // Hide sections
    const durationSection = document.getElementById('durationSection');
    const instructorSection = document.getElementById('instructorSection');
    const instructorQuantity = document.getElementById('instructorQuantity');
    if (durationSection) durationSection.style.display = 'none';
    if (instructorSection) instructorSection.style.display = 'none';
    if (instructorQuantity) instructorQuantity.style.display = 'none';

    // Reset photo
    const photoInput = document.getElementById('memberPhotoModern');
    const preview = document.getElementById('photoPreviewGlass');
    const removeBtn = document.getElementById('removePhotoModern');
    if (photoInput) photoInput.value = '';
    if (preview) {
        preview.innerHTML = '<i class="fas fa-camera"></i><span>Upload Photo</span>';
        preview.classList.remove('has-photo');
    }
    if (removeBtn) removeBtn.style.display = 'none';

    // Clear active states
    document.querySelectorAll('.plan-card-modern').forEach(card => {
        card.classList.remove('active');
    });
}

// ===== STEP NAVIGATION =====

function goToStep(stepNumber) {
    // Validate current step before proceeding
    if (stepNumber > currentStep && !validateCurrentStep()) {
        return;
    }

    // Hide all steps
    document.querySelectorAll('.step-content').forEach(step => {
        step.classList.remove('active');
    });

    // Show target step
    document.getElementById('step' + stepNumber).classList.add('active');

    // Update step indicators
    document.querySelectorAll('.step-item').forEach((item, index) => {
        item.classList.remove('active', 'completed');
        if (index + 1 < stepNumber) {
            item.classList.add('completed');
        } else if (index + 1 === stepNumber) {
            item.classList.add('active');
        }
    });

    currentStep = stepNumber;

    // Prepare step content
    if (stepNumber === 2) {
        prepareStep2();
    } else if (stepNumber === 3) {
        prepareStep3();
    }
}

function validateCurrentStep() {
    if (currentStep === 1) {
        if (!selectedPlanType) {
            showNotification('Please select a plan', 'warning');
            return false;
        }
        return true;
    }

    if (currentStep === 2) {
        return validateStep2();
    }

    return true;
}

// ===== STEP 1: PLAN SELECTION =====

function selectPlanModern(planType, price) {
    selectedPlanType = planType;
    selectedPlanPrice = price;

    // Update active state
    document.querySelectorAll('.plan-card-modern').forEach(card => {
        card.classList.remove('active');
    });

    const selectedCard = document.querySelector(`[data-plan="${planType}"]`);
    if (selectedCard) {
        selectedCard.classList.add('active');
        selectedPlanName = selectedCard.querySelector('h4').textContent;
    }

    // Show/Hide duration and instructor sections
    const durationSection = document.getElementById('durationSection');
    const instructorSection = document.getElementById('instructorSection');

    if (planType === 'day-pass') {
        if (durationSection) durationSection.style.display = 'none';
        if (instructorSection) instructorSection.style.display = 'none';
    } else {
        if (durationSection) durationSection.style.display = 'block';
        if (instructorSection) instructorSection.style.display = 'block';
        updateExpirationDate();
    }
}

// Duration Stepper
function incrementDuration() {
    if (membershipDuration < 24) {
        membershipDuration++;
        updateDurationDisplay();
        updateExpirationDate();
    }
}

function decrementDuration() {
    if (membershipDuration > 1) {
        membershipDuration--;
        updateDurationDisplay();
        updateExpirationDate();
    }
}

function updateDurationDisplay() {
    const valueElem = document.getElementById('durationValue');
    const pluralElem = document.getElementById('monthPlural');

    if (valueElem) valueElem.textContent = membershipDuration;
    if (pluralElem) pluralElem.textContent = membershipDuration > 1 ? 's' : '';
}

function updateExpirationDate() {
    const expirationElem = document.getElementById('expirationDate');
    if (!expirationElem) return;

    const expirationDate = new Date();
    expirationDate.setMonth(expirationDate.getMonth() + membershipDuration);

    const formatted = expirationDate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });

    expirationElem.textContent = formatted;
}

// Instructor Toggle
// Instructor Toggle Fixed
function toggleInstructor() {
    const checkbox = document.getElementById('instructorCheckbox');
    const quantitySection = document.getElementById('instructorQuantity');

    if (!checkbox) return;

    // Explicitly toggle visual state if triggered by parent div click
    // Note: click on label/input handles itself, so this check prevents double-toggle
    if (event.target.type !== 'checkbox') {
        checkbox.checked = !checkbox.checked;
    }

    if (quantitySection) {
        quantitySection.style.display = checkbox.checked ? 'block' : 'none';
        if (checkbox.checked) {
            quantitySection.classList.add('active'); // Trigger animation
        }
    }

    updateOrderSummary(); // Update price immediately
}

function incrementInstructor() {
    if (instructorSessions < 12) {
        instructorSessions++;
        updateInstructorDisplay();
    }
}

function decrementInstructor() {
    if (instructorSessions > 1) {
        instructorSessions--;
        updateInstructorDisplay();
    }
}

function updateInstructorDisplay() {
    const qtyElem = document.getElementById('instructorQty');
    if (qtyElem) qtyElem.textContent = instructorSessions;
}

// ===== STEP 2: CUSTOMER INFORMATION =====

function prepareStep2() {
    const dayPassForm = document.getElementById('dayPassInfoForm');
    const membershipForm = document.getElementById('membershipInfoForm');

    if (selectedPlanType === 'day-pass') {
        if (dayPassForm) dayPassForm.style.display = 'block';
        if (membershipForm) membershipForm.style.display = 'none';
    } else {
        if (dayPassForm) dayPassForm.style.display = 'none';
        if (membershipForm) membershipForm.style.display = 'block';
    }
}

function validateStep2() {
    if (selectedPlanType === 'day-pass') {
        const nameInput = document.getElementById('dayPassCustomerName');
        if (!nameInput || !nameInput.value.trim()) {
            showNotification('Please enter customer name', 'error');
            return false;
        }
        return true;
    } else {
        const nameInput = document.getElementById('memberNameModern');
        const emailInput = document.getElementById('memberEmailModern');
        const phoneInput = document.getElementById('memberPhoneModern');
        const photoInput = document.getElementById('memberPhotoModern');

        if (!nameInput || !nameInput.value.trim()) {
            showNotification('Please enter member name', 'error');
            return false;
        }

        if (!emailInput || !emailInput.value.trim() || !isValidEmail(emailInput.value)) {
            showNotification('Please enter a valid email address', 'error');
            return false;
        }

        if (!phoneInput || !phoneInput.value.trim()) {
            showNotification('Please enter phone number', 'error');
            return false;
        }

        // FIX: Check if "has-photo" class exists on preview wrapper OR file input has files
        // This handles cases where file is selected but input.files might be cleared/reset weirdly
        const preview = document.getElementById('photoPreviewGlass');
        const hasPhotoClass = preview && preview.classList.contains('has-photo');
        const hasFile = photoInput && photoInput.files && photoInput.files.length > 0;

        if (!hasPhotoClass && !hasFile) {
            showNotification('Please upload a photo', 'error');
            // Visual feedback
            if (preview) {
                preview.style.borderColor = 'var(--danger)';
                setTimeout(() => preview.style.borderColor = '', 2000);
            }
            return false;
        }

        return true;
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Photo Upload
function previewPhotoModern(input) {
    const preview = document.getElementById('photoPreviewGlass');
    const removeBtn = document.getElementById('removePhotoModern');

    if (!input.files || !input.files[0]) return;

    const reader = new FileReader();

    reader.onload = function (e) {
        preview.innerHTML = `<img src="${e.target.result}" alt="Photo Preview">`;
        preview.classList.add('has-photo');
        if (removeBtn) removeBtn.style.display = 'flex';
    };

    reader.readAsDataURL(input.files[0]);
}

function removePhotoModern() {
    const photoInput = document.getElementById('memberPhotoModern');
    const preview = document.getElementById('photoPreviewGlass');
    const removeBtn = document.getElementById('removePhotoModern');

    if (photoInput) photoInput.value = '';
    if (preview) {
        preview.innerHTML = '<i class="fas fa-camera"></i><span>Upload Photo</span>';
        preview.classList.remove('has-photo');
    }
    if (removeBtn) removeBtn.style.display = 'none';
}

// ===== STEP 3: PAYMENT & CONFIRMATION =====

function prepareStep3() {
    updateOrderSummary();
}

function updateOrderSummary() {
    const summaryPlan = document.getElementById('summaryPlan');
    const summaryDuration = document.getElementById('summaryDuration');
    const summaryDurationRow = document.getElementById('summaryDurationRow');
    const summaryInstructor = document.getElementById('summaryInstructor');
    const summaryInstructorRow = document.getElementById('summaryInstructorRow');
    const summaryTotal = document.getElementById('summaryTotal');

    // Plan
    if (summaryPlan) summaryPlan.textContent = selectedPlanName;

    // Duration (only for membership)
    if (selectedPlanType !== 'day-pass') {
        if (summaryDuration) summaryDuration.textContent = `${membershipDuration} Month${membershipDuration > 1 ? 's' : ''}`;
        if (summaryDurationRow) summaryDurationRow.style.display = 'flex';
    } else {
        if (summaryDurationRow) summaryDurationRow.style.display = 'none';
    }

    // Instructor
    const instructorCheckbox = document.getElementById('instructorCheckbox');
    if (instructorCheckbox && instructorCheckbox.checked) {
        if (summaryInstructor) summaryInstructor.textContent = `${instructorSessions} Session${instructorSessions > 1 ? 's' : ''} (₱${(1250 * instructorSessions).toLocaleString()})`;
        if (summaryInstructorRow) summaryInstructorRow.style.display = 'flex';
    } else {
        if (summaryInstructorRow) summaryInstructorRow.style.display = 'none';
    }

    // Calculate total
    let total = selectedPlanPrice;
    if (selectedPlanType !== 'day-pass') {
        total = selectedPlanPrice * membershipDuration;
    }
    if (instructorCheckbox && instructorCheckbox.checked) {
        total += 1250 * instructorSessions;
    }

    if (summaryTotal) summaryTotal.textContent = `₱${total.toLocaleString()}`;
}

function selectPaymentModern(method) {
    selectedPaymentMethod = method;

    document.querySelectorAll('.payment-option-glass').forEach(option => {
        option.classList.remove('active');
    });

    const selectedOption = document.querySelector(`[data-payment="${method}"]`);
    if (selectedOption) {
        selectedOption.classList.add('active');
    }
}

// ===== COMPLETE REGISTRATION =====

function completeRegistration() {
    hideAllRegStates();

    if (selectedPlanType === 'day-pass') {
        showDayPassSuccess();
    } else {
        showMembershipSuccess();
    }
}

function showDayPassSuccess() {
    const successNameDay = document.getElementById('successNameDay');
    const successPaymentDay = document.getElementById('successPaymentDay');
    const successValidityDay = document.getElementById('successValidityDay');

    const customerName = document.getElementById('dayPassCustomerName').value;

    if (successNameDay) successNameDay.textContent = customerName;
    if (successPaymentDay) successPaymentDay.textContent = formatPaymentMethod(selectedPaymentMethod);
    if (successValidityDay) successValidityDay.textContent = calculateDayPassValidity();

    document.getElementById('regSuccessDayPass').classList.add('active');
}

function showMembershipSuccess() {
    const successNameMember = document.getElementById('successNameMember');
    const successPlan = document.getElementById('successPlan');
    const successDuration = document.getElementById('successDuration');
    const successExpiration = document.getElementById('successExpiration');
    const successPaymentMember = document.getElementById('successPaymentMember');
    const successInstructor = document.getElementById('successInstructor');
    const instructorRow = document.getElementById('instructorRow');
    const successAmount = document.getElementById('successAmount');

    const memberName = document.getElementById('memberNameModern').value;

    // Calculate expiration
    const expirationDate = new Date();
    expirationDate.setMonth(expirationDate.getMonth() + membershipDuration);
    const expiration = expirationDate.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Calculate total
    let total = selectedPlanPrice * membershipDuration;
    const instructorCheckbox = document.getElementById('instructorCheckbox');
    if (instructorCheckbox && instructorCheckbox.checked) {
        total += 1250 * instructorSessions;
    }

    if (successNameMember) successNameMember.textContent = memberName;
    if (successPlan) successPlan.textContent = selectedPlanName;
    if (successDuration) successDuration.textContent = `${membershipDuration} Month${membershipDuration > 1 ? 's' : ''}`;
    if (successExpiration) successExpiration.textContent = expiration;
    if (successPaymentMember) successPaymentMember.textContent = formatPaymentMethod(selectedPaymentMethod);
    if (successAmount) successAmount.textContent = `₱${total.toLocaleString()}`;

    if (instructorCheckbox && instructorCheckbox.checked) {
        if (successInstructor) successInstructor.textContent = `${instructorSessions} Session${instructorSessions > 1 ? 's' : ''} (₱${(1250 * instructorSessions).toLocaleString()})`;
        if (instructorRow) instructorRow.style.display = 'flex';
    } else {
        if (instructorRow) instructorRow.style.display = 'none';
    }

    document.getElementById('regSuccessMembership').classList.add('active');
}

// ===== UTILITY FUNCTIONS =====

function formatPaymentMethod(method) {
    const methodMap = {
        'gcash': 'GCash',
        'cash': 'Cash',
        'bank': 'Bank Transfer'
    };
    return methodMap[method] || method;
}

function calculateDayPassValidity() {
    const now = new Date();
    const validDate = new Date(now);

    // If current time is after noon (12pm), set validity to tomorrow's midnight
    if (now.getHours() >= 12) {
        validDate.setDate(validDate.getDate() + 1);
    }

    validDate.setHours(0, 0, 0, 0); // Set to midnight (12am)

    return validDate.toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification-toast ${type}`;
    notification.textContent = message;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        background: ${type === 'error' ? 'rgba(220, 38, 38, 0.9)' : type === 'warning' ? 'rgba(217, 119, 6, 0.9)' : 'rgba(59, 130, 246, 0.9)'};
        color: white;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(10px);
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    console.log('Modern Registration System Initialized');
});
