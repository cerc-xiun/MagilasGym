// Replacement for displayRegistrationReceipt() in registration_forms.js
// This will use the unified receipt generator instead

function displayRegistrationReceipt() {
    // Determine context based on plan type
    const isDayPass = (selectedPlanType === 'day-pass');

    // Get Name & ID based on context
    let memberName, memberId;

    if (isDayPass) {
        // Day Pass Logic
        memberName = document.getElementById('dayPassCustomerName')?.value || 'Guest';
        memberId = 'Day Pass Holder';
    } else {
        // Membership Logic
        memberName = document.getElementById('memberNameModern')?.value || 'New Member';
        // Generate pseudo ID
        memberId = 'MG-' + String(Math.floor(Math.random() * 9000) + 1000);
    }

    // Build transaction items array
    const transactionItems = [];
    let total = 0;

    // Add plan item
    if (selectedPlanType && selectedPlanPrice) {
        // Calculate price
        let price = selectedPlanPrice;
        if (!isDayPass) {
            price = selectedPlanPrice * membershipDuration;
        }
        total += price;

        // Format label
        let durationLabel = '';
        if (isDayPass) {
            durationLabel = '(Single Access)';
        } else {
            durationLabel = `(${membershipDuration} month${membershipDuration > 1 ? 's' : ''})`;
        }

        transactionItems.push({
            label: `${selectedPlanName} ${durationLabel}`,
            value: price
        });
    }

    // Add instructor item if selected
    const instructorCheckbox = document.getElementById('instructorCheated');
    if (instructorCheckbox && instructorCheckbox.checked) {
        const price = 1250 * instructorSessions;
        total += price;

        transactionItems.push({
            label: `Instructor Sessions (${instructorSessions} month${instructorSessions > 1 ? 's' : ''})`,
            value: price
        });
    }

    // Hide step flow
    document.getElementById('regStepFlow').style.display = 'none';

    // Use unified receipt generator
    showUnifiedReceipt({
        memberName: memberName,
        memberId: memberId,
        transactionItems: transactionItems,
        paymentMethod: selectedPaymentMethod,
        totalAmount: total,
        onDone: showCheckinPrompt,
        generateQR: !isDayPass  // Hide QR for day pass
    });
}
