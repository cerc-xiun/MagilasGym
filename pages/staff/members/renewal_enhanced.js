
// =======================================================
// RENEWAL & ADDITIONS ENHANCED LOGIC
// =======================================================

// Safe notification helper (fallback if main one doesn't exist)
function safeNotify(message, type) {
    if (typeof showNotification === 'function') {
        showNotification(message, type);
    } else {
        alert(message);
    }
}

// --- State Management ---
let renewalState = {
    member: null,
    activeTab: 'renewal',
    isChangingPlan: false,
    selectedNewPlan: null,
    renewalDuration: 1,
    renewInstructor: false,
    instructorDuration: 1,
    paymentMethod: 'cash'
};

// Mock Plans Data
const RENEWAL_PLANS = {
    'regular': { name: 'Regular Monthly', price: 800 },
    'student': { name: 'Student Monthly', price: 600 },
    'senior': { name: 'Senior Citizen', price: 640 }
};

const INSTRUCTOR_PRICE = 1250;

// --- Mock Data with Instructor Info ---
const renewalEnhancedDB = [
    { id: 'MG-001', name: 'John Doe', plan: 'Regular Monthly', planKey: 'regular', expiry: '2026-02-25', status: 'Active', instructorMonths: 3 },
    { id: 'MG-002', name: 'Jane Smith', plan: 'Student Monthly', planKey: 'student', expiry: '2026-01-15', status: 'Expired', instructorMonths: 0 },
    { id: 'MG-003', name: 'Robert Johnson', plan: 'Senior Citizen', planKey: 'senior', expiry: '2026-03-10', status: 'Active', instructorMonths: 0 }
];

// 1. Search Logic
function handleRenewalSearchEnter(e) {
    if (e.key === 'Enter') searchMemberForRenewal();
}

function searchMemberForRenewal() {
    console.log('Search function called'); // Debug log
    const query = document.getElementById('renewalSearchInput').value.trim().toLowerCase();
    console.log('Query:', query); // Debug log
    const card = document.getElementById('memberCardResult');

    if (card) card.style.display = 'none';

    if (!query) {
        safeNotify('Please enter a name or ID', 'error');
        return;
    }

    const found = renewalEnhancedDB.find(m =>
        m.name.toLowerCase().includes(query) || m.id.toLowerCase() === query.toLowerCase()
    );

    console.log('Found member:', found); // Debug log

    if (found) {
        displayMemberSearchResult(found);
        safeNotify('Member found!', 'success');
    } else {
        safeNotify('Member not found', 'error');
    }
}

function displayMemberSearchResult(member) {
    const card = document.getElementById('memberCardResult');
    if (!card) return;

    document.getElementById('memberCardName').textContent = member.name;
    document.getElementById('memberCardId').textContent = member.id;
    document.getElementById('memberCardPlan').textContent = member.plan;
    document.getElementById('memberCardStatus').textContent = member.status;
    document.getElementById('memberCardExpiry').textContent = formatDate(member.expiry);

    const instrEl = document.getElementById('memberCardInstructor');
    if (member.instructorMonths > 0) {
        instrEl.textContent = `${member.instructorMonths} months remaining`;
        instrEl.className = 'detail-value gold';
    } else {
        instrEl.textContent = 'None';
        instrEl.className = 'detail-value';
    }

    renewalState.member = member;
    renewalState.selectedNewPlan = member.planKey;

    card.classList.add('active');
    card.style.display = 'block';
}

function proceedToRenewalOptions() {
    if (!renewalState.member) return;

    document.getElementById('renewalStep1').style.display = 'none';
    document.getElementById('renewalStep2').style.display = 'block';

    document.getElementById('renewDashboardName').textContent = renewalState.member.name;
    document.getElementById('renewDashboardPlan').textContent = renewalState.member.plan;
    document.getElementById('renewDashboardStatus').textContent = renewalState.member.status;
    document.getElementById('renewDashboardExpiry').textContent = formatDate(renewalState.member.expiry);

    renewalState.activeTab = 'renewal';
    renewalState.renewalDuration = 1;
    renewalState.renewInstructor = false;
    renewalState.isChangingPlan = false;

    switchRenewalTab('renewal');
    calculateRenewalTotal();
}

// 2. Tab Logic
function switchRenewalTab(tabName) {
    renewalState.activeTab = tabName;

    document.querySelectorAll('.renewal-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

    const tabs = document.querySelectorAll('.renewal-tab');
    if (tabName === 'renewal') tabs[0].classList.add('active');
    if (tabName === 'addon') tabs[1].classList.add('active');

    if (tabName === 'renewal') document.getElementById('tabRenewal').classList.add('active');
    if (tabName === 'addon') document.getElementById('tabAddon').classList.add('active');

    calculateRenewalTotal();
}

// 3. Plan Change Logic
function toggleChangePlanMode() {
    renewalState.isChangingPlan = !renewalState.isChangingPlan;
    const btn = document.getElementById('btnChangePlan');
    const modeExtend = document.getElementById('modeExtend');
    const modeChange = document.getElementById('modeChangePlan');

    if (renewalState.isChangingPlan) {
        btn.textContent = 'Cancel Change';
        modeExtend.style.display = 'none';
        modeChange.style.display = 'block';
        renderPlanOptions();
    } else {
        btn.textContent = 'Change Plan';
        modeExtend.style.display = 'block';
        modeChange.style.display = 'none';
        renewalState.selectedNewPlan = renewalState.member.planKey;
    }
    calculateRenewalTotal();
}

function renderPlanOptions() {
    const grid = document.getElementById('renewalPlanGrid');
    if (!grid) return;
    grid.innerHTML = '';

    Object.keys(RENEWAL_PLANS).forEach(key => {
        const plan = RENEWAL_PLANS[key];
        const isCurrent = key === renewalState.member.planKey;
        const isSelected = key === renewalState.selectedNewPlan;

        let classes = 'plan-option-compact';
        if (isCurrent) classes += ' current';
        if (isSelected) classes += ' selected';

        const div = document.createElement('div');
        div.className = classes;
        div.onclick = () => selectRenewalPlan(key);
        div.innerHTML = `
            <h5>${plan.name} ${isCurrent ? '(Current)' : ''}</h5>
            <div class="price">₱${plan.price}</div>
        `;
        grid.appendChild(div);
    });
}

function selectRenewalPlan(planKey) {
    renewalState.selectedNewPlan = planKey;
    renderPlanOptions();

    const note = document.getElementById('studentIdNote');
    if (note) {
        if (planKey === 'student' || planKey === 'senior') {
            note.style.display = 'block';
        } else {
            note.style.display = 'none';
        }
    }

    calculateRenewalTotal();
}

// 4. Duration Controls
function adjustRenewalDuration(delta) {
    renewalState.renewalDuration += delta;
    if (renewalState.renewalDuration < 1) renewalState.renewalDuration = 1;

    document.getElementById('renewDurationVal').textContent = renewalState.renewalDuration;

    const currentExpiry = new Date(renewalState.member.expiry);
    const newDate = new Date(currentExpiry.setMonth(currentExpiry.getMonth() + renewalState.renewalDuration));
    document.getElementById('renewNewExpiry').textContent = formatDate(newDate.toISOString().split('T')[0]);

    calculateRenewalTotal();
}

function adjustInstructorDuration(delta) {
    renewalState.instructorDuration += delta;
    if (renewalState.instructorDuration < 1) renewalState.instructorDuration = 1;

    document.getElementById('instructorDurationVal').textContent = renewalState.instructorDuration;
    calculateRenewalTotal();
}

// 5. Instructor Logic
function toggleRenewInstructor() {
    const checkbox = document.getElementById('renewInstructorCheck');
    renewalState.renewInstructor = checkbox.checked;

    const controls = document.getElementById('renewInstructorControls');
    if (controls) {
        controls.style.display = checkbox.checked ? 'block' : 'none';
    }

    calculateRenewalTotal();
}

// 6. Payment Logic
function selectRenewalPayment(method) {
    renewalState.paymentMethod = method;

    document.querySelectorAll('.payment-option-enhanced').forEach(opt => {
        opt.classList.remove('active');
        if (opt.dataset.rpay === method) opt.classList.add('active');
    });

    const bankInput = document.getElementById('bankRefInput');
    if (bankInput) {
        bankInput.style.display = (method === 'bank') ? 'block' : 'none';
    }
}

function calculateRenewalTotal() {
    let total = 0;

    const planKey = renewalState.isChangingPlan ? renewalState.selectedNewPlan : renewalState.member.planKey;

    if (planKey && RENEWAL_PLANS[planKey]) {
        total += RENEWAL_PLANS[planKey].price * renewalState.renewalDuration;
    }

    if (renewalState.renewInstructor) {
        total += INSTRUCTOR_PRICE * renewalState.instructorDuration;
    }

    const totalEl = document.getElementById('renewTotalAmount');
    if (totalEl) {
        totalEl.textContent = '₱' + total.toLocaleString();
    }
}

function proceedRenewalPayment() {
    showNotification('Processing Payment...', 'info');
    setTimeout(() => {
        showNotification('Renewal Successful!', 'success');
        navigateBackToCards();
    }, 1500);
}

// Helpers
function formatDate(dateStr) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateStr).toLocaleDateString('en-US', options);
}
