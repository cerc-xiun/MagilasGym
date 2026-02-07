// Replacement for displayReceipt() in renewal_enhanced.js
// Uses the unified receipt generator for consistency

function displayReceipt() {
    // Populate member info
    const memberName = renewalState.member.name;
    const memberId = renewalState.member.id;

    // Build transaction items
    const transactionItems = [];
    let total = 0;

    // Add membership item
    const planKey = renewalState.isChangingPlan ? renewalState.selectedNewPlan : renewalState.member.planKey;
    if (planKey && RENEWAL_PLANS[planKey]) {
        const plan = RENEWAL_PLANS[planKey];
        const price = plan.price * renewalState.renewalDuration;
        total += price;

        transactionItems.push({
            label: `${plan.name} (${renewalState.renewalDuration} month${renewalState.renewalDuration > 1 ? 's' : ''})`,
            value: price
        });
    }

    // Add instructor item
    if (renewalState.renewInstructor) {
        const price = INSTRUCTOR_PRICE * renewalState.instructorDuration;
        total += price;

        transactionItems.push({
            label: `Instructor Sessions (${renewalState.instructorDuration} month${renewalState.instructorDuration > 1 ? 's' : ''})`,
            value: price
        });
    }

    // Define reset callback
    const onDoneCallback = () => {
        // Prepare data for check-in prompt
        const renewalMemberData = {
            name: renewalState.member.name,
            type: 'membership', // Renewals are always memberships
            planName: renewalState.member.plan,
            isDayPass: false
        };

        // Show prompt with callback for actual reset
        showCheckinPrompt(renewalMemberData, () => {
            // ACTUAL RESET LOGIC (Called after check-in/skip)

            // Reset to cards
            document.getElementById('regRenewalFlow').style.display = 'none';
            document.querySelector('.flip-cards-container').style.display = 'flex';

            // Reset search
            document.getElementById('renewalSearchInput').value = '';
            document.getElementById('memberCardResult').style.display = 'none';
            document.getElementById('renewalStep1').style.display = 'block';
            document.getElementById('renewalStep2').style.display = 'none';
        });
    };

    // Use unified receipt generator
    showUnifiedReceipt({
        memberName: memberName,
        memberId: memberId,
        transactionItems: transactionItems,
        paymentMethod: renewalState.paymentMethod,
        totalAmount: total,
        onDone: onDoneCallback,
        generateQR: true
    });
}
