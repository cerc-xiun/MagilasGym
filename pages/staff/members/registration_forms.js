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
    const cardSelection = document.getElementById('regCardSelection');
    if (cardSelection) {
        cardSelection.classList.add('active');
        cardSelection.style.display = 'flex';
    }
    resetRegistrationFlow();
}

function resetToCards() {
    navigateBackToCards();
}

function hideAllRegStates() {
    document.querySelectorAll('.reg-state').forEach(state => {
        state.classList.remove('active');
        state.style.display = 'none'; // Robust fix
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
// Photo Upload Fix
function previewPhotoModern(input) {
    const box = document.getElementById('photoPreviewGlass');
    const removeBtn = document.getElementById('removePhotoModern');

    if (!input.files || !input.files[0]) return;

    const reader = new FileReader();

    reader.onload = function (e) {
        // Do NOT overwrite innerHTML (keeps input alive)

        // Hide placeholder elements (icon and span)
        const icon = box.querySelector('.fa-camera');
        const span = box.querySelector('span');
        if (icon) icon.style.display = 'none';
        if (span) span.style.display = 'none';

        // Show/Create Image
        let img = box.querySelector('img');
        if (!img) {
            img = document.createElement('img');
            box.appendChild(img);
        }
        img.src = e.target.result;
        img.style.display = 'block';

        box.classList.add('has-photo');
        if (removeBtn) removeBtn.style.display = 'flex';
    };

    reader.readAsDataURL(input.files[0]);
}

function removePhotoModern() {
    const photoInput = document.getElementById('memberPhotoModern');
    const box = document.getElementById('photoPreviewGlass');
    const removeBtn = document.getElementById('removePhotoModern');

    if (photoInput) photoInput.value = '';

    if (box) {
        box.classList.remove('has-photo');

        // Remove or hide image
        const img = box.querySelector('img');
        if (img) img.style.display = 'none';

        // Show placeholder
        const icon = box.querySelector('.fa-camera');
        const span = box.querySelector('span');
        if (icon) icon.style.display = 'block';
        if (span) span.style.display = 'block';
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
    // Show loading indicator
    showNotification('Processing registration...', 'info');

    setTimeout(() => {
        displayRegistrationReceipt();
        showNotification('Registration successful!', 'success');
    }, 1500);
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
    // Deprecated - now using receipt modal
    displayRegistrationReceipt();
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

// ===== RENEWAL SYSTEM LOGIC =====

// Mock Database for Renewal Demo
const renewalMockDB = [
    { id: '1001', name: 'John Doe', plan: 'Regular Monthly', status: 'Active', expiry: '2026-02-25', planPrice: 800 },
    { id: '1002', name: 'Sarah Connor', plan: 'Student Monthly', status: 'Expired', expiry: '2026-01-10', planPrice: 600 },
    { id: '1003', name: 'Mike Ross', plan: 'Senior Monthly', status: 'Active', expiry: '2026-03-01', planPrice: 650 }
];

let currentRenewMember = null;
let renewalDuration = 1;
let renewalType = 'extend'; // 'extend' or 'instructor'
let renewalPayment = 'gcash';

function showRenewalForm() {
    hideAllRegStates();
    const renewalFlow = document.getElementById('regRenewalFlow');
    if (renewalFlow) {
        renewalFlow.classList.add('active');
        renewalFlow.style.display = 'block';
    }

    // Reset state
    document.getElementById('renewalStep1').style.display = 'block';
    document.getElementById('renewalStep2').style.display = 'none';
    document.getElementById('renewalSearchInput').value = '';
    document.getElementById('renewalSearchInput').focus();
}

function handleRenewalSearchEnter(e) {
    if (e.key === 'Enter') searchMemberForRenewal();
}

function searchMemberForRenewal() {
    const query = document.getElementById('renewalSearchInput').value.trim().toLowerCase();

    if (!query) {
        showNotification('Please enter a name or ID', 'error');
        return;
    }

    // Simulate Search
    const found = renewalMockDB.find(m =>
        m.name.toLowerCase().includes(query) || m.id === query
    );

    if (found) {
        loadRenewalDashboard(found);
    } else {
        showNotification('Member not found', 'error');
    }
}

function loadRenewalDashboard(member) {
    currentRenewMember = member;
    renewalDuration = 1;
    renewalType = 'extend';

    // Populate Profile
    document.getElementById('renewMemberName').textContent = member.name;
    document.getElementById('renewMemberPlan').textContent = member.plan;

    const statusBadge = document.getElementById('renewMemberStatus');
    statusBadge.textContent = member.status;
    statusBadge.className = `status-badge ${member.status.toLowerCase()}`;

    document.getElementById('renewMemberExpiry').textContent = formatDate(member.expiry);

    // Switch Views
    document.getElementById('renewalStep1').style.display = 'none';
    document.getElementById('renewalStep2').style.display = 'block';

    // Reset to Extend Option
    selectRenewalOption('extend');
    updateRenewalCalculations();
}

function selectRenewalOption(type) {
    renewalType = type;

    // Visual Toggle
    document.querySelectorAll('.renewal-option-card').forEach(c => c.classList.remove('active'));

    if (type === 'extend') {
        document.getElementById('optExtend').classList.add('active');
        document.getElementById('formExtend').style.display = 'block';
        // Hide instructor specific forms if any
    } else {
        document.getElementById('optInstructor').classList.add('active');
        document.getElementById('formExtend').style.display = 'none';
        // specific instructor logic
        showNotification('Instructor Add-on coming in next update', 'info');
        // Revert for demo
        setTimeout(() => selectRenewalOption('extend'), 1000);
        return;
    }

    updateRenewalCalculations();
}

function adjustRenewalDuration(delta) {
    if (renewalDuration + delta >= 1 && renewalDuration + delta <= 12) {
        renewalDuration += delta;
        document.getElementById('renewDurationVal').textContent = renewalDuration;
        updateRenewalCalculations();
    }
}

function updateRenewalCalculations() {
    if (!currentRenewMember) return;

    // Calculate Price
    const total = currentRenewMember.planPrice * renewalDuration;
    document.getElementById('renewTotalAmount').textContent = `₱${total.toLocaleString()}`;

    // Calculate New Expiry
    const currentExpiry = new Date(currentRenewMember.expiry);
    const today = new Date();

    // If expired, start from today. If active, add to current expiry.
    let baseDate = currentExpiry < today ? today : currentExpiry;

    const newExpiry = new Date(baseDate);
    newExpiry.setMonth(newExpiry.getMonth() + renewalDuration);

    document.getElementById('renewNewExpiry').textContent = newExpiry.toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });
}

function selectRenewalPayment(method) {
    renewalPayment = method;
    document.querySelectorAll('.payment-option-glass').forEach(opt => {
        if (opt.dataset.rpay === method) opt.classList.add('active');
        else opt.classList.remove('active');
    });
}

function processRenewalComplete() {
    // Show loading
    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    setTimeout(() => {
        btn.innerHTML = originalText;
        displayRegistrationReceipt();
    }, 1500);
}

function displayRegistrationReceipt() {
    // Get member name
    const memberName = document.getElementById('memberNameModern')?.value || 'New Member';

    // Generate member ID (simulate)
    const memberId = 'MG-' + String(Math.floor(Math.random() * 9000) + 1000);

    // Populate member info
    document.getElementById('regReceiptMemberName').textContent = memberName;
    document.getElementById('regReceiptMemberId').textContent = memberId;

    // Build transaction items
    const itemsContainer = document.getElementById('regReceiptItems');
    itemsContainer.innerHTML = '';

    let total = 0;

    // Add plan item
    if (selectedPlanType && selectedPlanPrice) {
        const price = selectedPlanPrice * membershipDuration;
        total += price;

        const itemRow = document.createElement('div');
        itemRow.className = 'receipt-row';
        itemRow.innerHTML = `
            <span class="label">${selectedPlanName} (${membershipDuration} month${membershipDuration > 1 ? 's' : ''})</span>
            <span class="value">₱${price.toLocaleString()}</span>
        `;
        itemsContainer.appendChild(itemRow);
    }

    // Add instructor item if selected
    const instructorCheckbox = document.getElementById('instructorCheckbox');
    if (instructorCheckbox && instructorCheckbox.checked) {
        const price = 1250 * instructorSessions;
        total += price;

        const itemRow = document.createElement('div');
        itemRow.className = 'receipt-row';
        itemRow.innerHTML = `
            <span class="label">Instructor Sessions (${instructorSessions} month${instructorSessions > 1 ? 's' : ''})</span>
            <span class="value">₱${price.toLocaleString()}</span>
        `;
        itemsContainer.appendChild(itemRow);
    }

    // Payment method
    const paymentMethods = {
        'cash': 'Cash',
        'gcash': 'GCash',
        'card': 'Credit/Debit Card',
        'bank': 'Bank Transfer'
    };
    document.getElementById('regReceiptPaymentMethod').textContent = paymentMethods[selectedPaymentMethod] || 'Cash';

    // Date & time
    const now = new Date();
    const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    const timeStr = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    document.getElementById('regReceiptDateTime').textContent = `${dateStr} ${timeStr}`;

    // Total
    document.getElementById('regReceiptTotal').textContent = '₱' + total.toLocaleString();

    // QR Code Section - Only for Memberships (not Day Pass)
    const qrSection = document.querySelector('#registrationReceiptModal .receipt-section[style*="text-align: center"]');
    const qrContainer = document.getElementById('regReceiptQRCode');

    if (selectedPlanType === 'day-pass') {
        // Hide QR code for day pass
        if (qrSection) qrSection.style.display = 'none';
    } else {
        // Show pseudo QR code for memberships
        if (qrSection) qrSection.style.display = 'block';
        if (qrContainer) {
            // Create pseudo QR code (visual placeholder)
            qrContainer.innerHTML = `
                <div style="width: 150px; height: 150px; background: #000; padding: 10px; border: 3px solid #b8960c; border-radius: 8px; position: relative;">
                    <div style="background: white; width: 100%; height: 100%; display: grid; grid-template-columns: repeat(10, 1fr); grid-template-rows: repeat(10, 1fr); gap: 1px;">
                        ${Array(100).fill(0).map(() =>
                `<div style="background: ${Math.random() > 0.5 ? '#000' : '#fff'};"></div>`
            ).join('')}
                    </div>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 4px; border: 2px solid #b8960c; border-radius: 4px;">
                        <div style="font-size: 10px; font-weight: bold; color: #b8960c;">${memberId}</div>
                    </div>
                </div>
            `;
        }
    }

    // Show modal
    document.getElementById('registrationReceiptModal').classList.add('active');

    // Hide step flow
    document.getElementById('regStepFlow').style.display = 'none';
}

function printRegistrationReceipt() {
    window.print();
}

function closeRegistrationReceiptAndReset() {
    // Hide receipt
    document.getElementById('registrationReceiptModal').classList.remove('active');

    // Reset to cards
    navigateBackToCards();
}

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}


// ===== INSTRUCTOR TOGGLE (Simplified) =====
function toggleInstructor() {
    const checkbox = document.getElementById('instructorCheckbox');
    const quantity = document.getElementById('instructorQuantity');

    if (!checkbox || !quantity) return;

    // Show/hide quantity based on checkbox state
    if (checkbox.checked) {
        quantity.style.display = 'block';
    } else {
        quantity.style.display = 'none';
    }
}

