// Show Receipt - Uses shared receipt generator for consistency
function showReceipt() {
    // Generate member ID
    const memberId = 'MG-' + String(Math.floor(Math.random() * 9000) + 1000);

    // Build transaction items array
    const transactionItems = [];

    // Membership item with duration label
    const isDayPass = currentApplication.months === 0;
    const durationLabel = isDayPass ? '(Single Access)' :
        `(${currentApplication.months} month${currentApplication.months > 1 ? 's' : ''})`;

    transactionItems.push({
        label: `${currentApplication.planName} ${durationLabel}`,
        value: currentApplication.amount
    });

    // Instructor sessions if applicable
    if (currentApplication.instructor && currentApplication.instructorMonths > 0) {
        transactionItems.push({
            label: `Instructor Sessions (${currentApplication.instructorMonths} month${currentApplication.instructorMonths > 1 ? 's' : ''})`,
            value: 'Included'
        });
    }

    // Store member ID for check-in later
    currentApplication.memberId = memberId;

    // Use unified receipt generator
    showUnifiedReceipt({
        memberName: currentApplication.fullName,
        memberId: memberId,
        transactionItems: transactionItems,
        paymentMethod: currentApplication.paymentMethod,
        totalAmount: currentApplication.amount,
        onDone: showCheckinPrompt,
        generateQR: true
    });
}
