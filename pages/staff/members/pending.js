// =========================================
// PENDING APPLICATIONS - LOGIC
// =========================================

// Mock Data (Initial Fallback)
const defaultApplications = [
    {
        id: 1,
        fullName: "John Michael Doe",
        email: "john.doe@example.com",
        plan: "student",
        planName: "Student Monthly",
        amount: 600,
        paymentMethod: "gcash",
        refNumber: "9876543210",
        date: "2026-01-28",
        status: "pending",
        instructor: true,
        instructorMonths: 1,
        months: 1,
        requirements: {
            id: true,
            payment: true
        }
    },
    {
        id: 2,
        fullName: "Jane Smith",
        email: "jane.smith@example.com",
        plan: "regular",
        planName: "Regular Monthly",
        amount: 800,
        paymentMethod: "cash",
        refNumber: "N/A",
        date: "2026-01-29",
        status: "pending",
        instructor: false,
        instructorMonths: 0,
        months: 1,
        requirements: {
            id: false,
            payment: true
        }
    },
    {
        id: 3,
        fullName: "Robert Johnson",
        email: "robert.j@example.com",
        plan: "senior",
        planName: "Senior Monthly",
        amount: 650,
        paymentMethod: "bank",
        refNumber: "TRX-456789",
        date: "2026-01-30",
        status: "pending",
        instructor: false,
        instructorMonths: 0,
        months: 1,
        requirements: {
            id: true,
            payment: true
        }
    },
    {
        id: 4,
        fullName: "Maria Garcia",
        contact: "0915-222-3333",
        email: "maria.garcia@email.com",
        planType: "membership",
        planCategory: "senior",
        planName: "Monthly (Senior)",
        amount: 1300,
        months: 2,
        instructor: false,
        instructorSessions: 0,
        instructorMonths: 0,
        appliedDate: "2026-01-29T16:30:00",
        status: "accepted",
        processedDate: "2026-01-30T09:15:00",
        rejectionReason: null,
        paymentMethod: "cash"
    },
    {
        id: 5,
        fullName: "James Wilson",
        contact: "0908-111-2222",
        email: "james.wilson@email.com",
        planType: "membership",
        planCategory: "student",
        planName: "Monthly (Student)",
        amount: 600,
        months: 1,
        instructor: false,
        instructorSessions: 0,
        instructorMonths: 0,
        appliedDate: "2026-01-29T11:45:00",
        status: "rejected",
        processedDate: "2026-01-29T14:20:00",
        rejectionReason: "Incomplete Information",
        paymentMethod: null
    }
];

// Load from LocalStorage or use Default
let applications = JSON.parse(localStorage.getItem('pendingApplications')) || defaultApplications;

// Save helper
function saveApplications() {
    localStorage.setItem('pendingApplications', JSON.stringify(applications));
}

// State
let currentTab = 'pending';
let currentApplication = null;
let searchQuery = '';

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    updateTabCounts();
    renderApplications();
});

// Tab Switching
function switchTab(tab) {
    currentTab = tab;

    // Update active state
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.tab === tab) {
            btn.classList.add('active');
        }
    });

    renderApplications();
}

// Update Tab Counts
function updateTabCounts() {
    const pending = applications.filter(app => app.status === 'pending').length;
    const accepted = applications.filter(app => app.status === 'accepted').length;
    const rejected = applications.filter(app => app.status === 'rejected').length;

    document.getElementById('pendingCount').textContent = pending;
    document.getElementById('acceptedCount').textContent = accepted;
    document.getElementById('rejectedCount').textContent = rejected;

    // Dev Tool: Reset Data
    const controls = document.querySelector('.pending-controls');
    if (!document.getElementById('resetBtn')) {
        const btn = document.createElement('button');
        btn.id = 'resetBtn';
        btn.innerHTML = '<i class="fas fa-undo"></i> Reset Data';
        btn.style.cssText = 'background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 8px 16px; border-radius: 8px; cursor: pointer; margin-left: auto;';
        btn.onclick = () => {
            if (confirm('Reset all application data?')) {
                localStorage.removeItem('pendingApplications');
                localStorage.removeItem('activeVisits');
                location.reload();
            }
        };
        controls.appendChild(btn);
    }
}

// Render Applications
function renderApplications() {
    const container = document.getElementById('applicationsContainer');
    const filtered = applications.filter(app => {
        const matchesTab = app.status === currentTab;
        const matchesSearch = searchQuery === '' ||
            app.fullName.toLowerCase().includes(searchQuery.toLowerCase()) ||
            app.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
            app.planName.toLowerCase().includes(searchQuery.toLowerCase());
        return matchesTab && matchesSearch;
    });

    document.getElementById('resultCount').textContent = filtered.length;

    if (filtered.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Applications Found</h3>
                <p>${searchQuery ? 'Try adjusting your search query' : 'No ' + currentTab + ' applications at the moment'}</p>
            </div>
        `;
        return;
    }

    container.innerHTML = filtered.map(app => createApplicationCard(app)).join('');
}

// Create Application Card
function createApplicationCard(app) {
    const initials = app.fullName.split(' ').map(n => n[0]).join('').substring(0, 2);
    const formattedDate = formatDate(app.appliedDate);
    const processedInfo = app.processedDate ? `<br><small>Processed: ${formatDate(app.processedDate)}</small>` : '';

    return `
        <div class="application-card" onclick="showApplicationDetails(${app.id})">
            <div class="card-header">
                <div style="display: flex; align-items: center; flex: 1;">
                    <div class="card-avatar">${initials}</div>
                    <div class="card-info">
                        <div class="card-name">${app.fullName}</div>
                        <div class="card-email">${app.email}</div>
                    </div>
                </div>
            </div>
            <div class="card-details">
                <div class="card-detail-row">
                    <span class="label">Plan</span>
                    <span class="value card-plan">${app.planName}</span>
                </div>
                <div class="card-detail-row">
                    <span class="label">Amount</span>
                    <span class="value">₱${app.amount}</span>
                </div>
                <div class="card-detail-row">
                    <span class="label">Contact</span>
                    <span class="value">${app.contact}</span>
                </div>
                ${app.instructor ? `
                <div class="card-detail-row">
                    <span class="label">Sessions</span>
                    <span class="value">${app.instructorSessions} Sessions/Week</span>
                </div>
                ` : ''}
            </div>
            <div class="card-footer">
                <div class="card-date">
                    Applied: ${formattedDate}${processedInfo}
                </div>
                <div class="card-status ${app.status}">${app.status}</div>
            </div>
        </div>
    `;
}

// Filter Applications
function filterApplications() {
    searchQuery = document.getElementById('pendingSearch').value;
    renderApplications();
}

// Show Application Details
function showApplicationDetails(id) {
    currentApplication = applications.find(app => app.id === id);
    if (!currentApplication) return;

    const detailContent = document.getElementById('detailContent');
    const isPending = currentApplication.status === 'pending';
    const initials = currentApplication.fullName.split(' ').map(n => n[0]).join('').substring(0, 2);

    detailContent.innerHTML = `
        <div style="text-align: center; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 2px solid rgba(184, 150, 12, 0.2);">
            <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), #d4af37); display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: 700; color: #000; margin: 0 auto 16px; border: 4px solid rgba(184, 150, 12, 0.3); box-shadow: 0 8px 24px rgba(184, 150, 12, 0.3);">
                ${initials}
            </div>
            <h2 style="font-size: 28px; color: #fff; margin-bottom: 4px;">${currentApplication.fullName}</h2>
            <p style="color: rgba(255, 255, 255, 0.6); font-size: 16px;">${currentApplication.email}</p>
            <div style="display: inline-block; margin-top: 12px; padding: 6px 16px; background: rgba(184, 150, 12, 0.15); border: 1px solid rgba(184, 150, 12, 0.3); border-radius: 20px; color: var(--gold); font-weight: 700; font-size: 14px;">
                ${currentApplication.planName}
            </div>
        </div>
        
        <div class="detail-section">
            <h3>Contact Information</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="label">Contact Number</span>
                    <span class="value">${currentApplication.contact}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Email Address</span>
                    <span class="value">${currentApplication.email}</span>
                </div>
            </div>
        </div>
        
        <div class="detail-section">
            <h3>Plan Information</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="label">Plan Type</span>
                    <span class="value">${currentApplication.planName}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Amount</span>
                    <span class="value">₱${currentApplication.amount}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Membership Duration</span>
                    <span class="value">${currentApplication.months === 0 ? 'Day Pass' : currentApplication.months === 1 ? '1 Month' : currentApplication.months + ' Months'}</span>
                </div>
                ${currentApplication.instructor ? `
                <div class="detail-item">
                    <span class="label">Instructor Sessions</span>
                    <span class="value">${currentApplication.instructorSessions} Sessions per Week</span>
                </div>
                <div class="detail-item">
                    <span class="label">Instructor Duration</span>
                    <span class="value">${currentApplication.instructorMonths === 1 ? '1 Month' : currentApplication.instructorMonths + ' Months'}</span>
                </div>
                ` : ''}
            </div>
        </div>
        
        <div class="detail-section">
            <h3>Additional Information</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="label">Application Date</span>
                    <span class="value">${formatDate(currentApplication.appliedDate)}</span>
                </div>
                ${currentApplication.processedDate ? `
                <div class="detail-item">
                    <span class="label">Processed Date</span>
                    <span class="value">${formatDate(currentApplication.processedDate)}</span>
                </div>
                ` : ''}
                ${currentApplication.paymentMethod ? `
                <div class="detail-item">
                    <span class="label">Payment Method</span>
                    <span class="value">${currentApplication.paymentMethod.toUpperCase()}</span>
                </div>
                ` : ''}
                ${currentApplication.rejectionReason ? `
                <div class="detail-item">
                    <span class="label">Rejection Reason</span>
                    <span class="value">${currentApplication.rejectionReason}</span>
                </div>
                ` : ''}
            </div>
        </div>
        
        ${isPending ? `
        <div class="detail-actions">
            <button class="btn-success" onclick="showPaymentModal()">
                <i class="fas fa-check"></i> Accept Application
            </button>
            <button class="btn-danger" onclick="showRejectionModal()">
                <i class="fas fa-times"></i> Reject Application
            </button>
        </div>
        ` : ''}
    `;

    document.getElementById('detailModal').classList.add('active');
}

// Close Detail Modal
function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('active');
}

// Show Payment Modal
function showPaymentModal() {
    if (!currentApplication) return;

    document.getElementById('paymentApplicantName').textContent = currentApplication.fullName;
    document.getElementById('paymentPlanName').textContent = currentApplication.planName;
    document.getElementById('paymentAmount').textContent = currentApplication.amount;

    document.getElementById('detailModal').classList.remove('active');
    document.getElementById('paymentModal').classList.add('active');
}

// Close Payment Modal
function closePaymentModal() {
    document.getElementById('paymentModal').classList.remove('active');
}

// Confirm Payment
function confirmPayment() {
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    currentApplication.paymentMethod = paymentMethod;

    closePaymentModal();
    showReceipt();
}

// Show Receipt
// Show Receipt
// Show Receipt
function showReceipt() {
    // Generate member ID
    const memberId = 'MG-' + String(Math.floor(Math.random() * 9000) + 1000);

    // Build Transaction Label
    let transactionLabel = '';

    // Membership item with duration label
    const isDayPass = currentApplication.months === 0;
    const durationLabel = isDayPass ? '(Single Access)' :
        `(${currentApplication.months} month${currentApplication.months > 1 ? 's' : ''})`;

    transactionLabel = `${currentApplication.planName} ${durationLabel}`;

    // Instructor sessions if applicable
    if (currentApplication.instructor && currentApplication.instructorMonths > 0) {
        transactionLabel += ` + Instructor (${currentApplication.instructorMonths}mo)`;
    }

    // Store member ID for check-in later
    currentApplication.memberId = memberId;

    // Use NEW unified receipt generator
    generateUnifiedReceipt({
        memberName: currentApplication.fullName,
        memberId: memberId,
        transactionName: transactionLabel,
        amount: currentApplication.amount,
        paymentMethod: currentApplication.paymentMethod,
        onDone: showCheckinPrompt
    });
}

// Close Receipt Modal
function closeReceiptModal() {
    // Unified receipt handles its own closing
    // document.getElementById('receipt Modal').classList.remove('active');
}

// Show Check-in Prompt
function showCheckinPrompt() {
    // Populate name
    const memberNameEl = document.getElementById('checkinMemberName');
    if (memberNameEl && currentApplication) {
        memberNameEl.textContent = currentApplication.fullName;
    }

    // Show Check-in Modal
    const checkinModal = document.getElementById('checkinModal');
    if (checkinModal) {
        checkinModal.classList.add('active');
    } else {
        console.error('Check-in modal not found!');
    }
}

// Skip Check-in
function skipCheckin() {
    completeAcceptance(false);
}

// Proceed Check-in
function proceedCheckin() {
    // Add member to Who's In panel via localStorage communication
    const memberData = {
        name: currentApplication.fullName,
        memberId: currentApplication.memberId || 'MG-' + Math.floor(Math.random() * 9000 + 1000),
        // Add Plan and Type for robust display
        planName: currentApplication.planName || 'Standard',
        type: (currentApplication.planName && currentApplication.planName.toLowerCase().includes('day')) ? 'day-pass' : 'membership',
        checkInTime: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
        timestamp: Date.now()
    };

    // Get existing active visits from localStorage or initialize empty array
    let activeVisits = JSON.parse(localStorage.getItem('activeVisits') || '[]');

    // Add new member to active visits
    activeVisits.push(memberData);

    // Save back to localStorage
    localStorage.setItem('activeVisits', JSON.stringify(activeVisits));

    completeAcceptance(true);
}

// Complete Acceptance
function completeAcceptance(checkedIn) {
    currentApplication.status = 'accepted';
    currentApplication.processedDate = new Date().toISOString();

    // Save changes to localStorage
    saveApplications();

    document.getElementById('checkinModal').classList.remove('active');
    currentApplication = null;

    updateTabCounts();
    renderApplications();


}

// Show Rejection Modal
function showRejectionModal() {
    document.getElementById('rejectionApplicantName').textContent = currentApplication.fullName;
    document.getElementById('detailModal').classList.remove('active');
    document.getElementById('rejectionModal').classList.add('active');
}

// Close Rejection Modal
function closeRejectionModal() {
    document.getElementById('rejectionModal').classList.remove('active');
}

// Confirm Rejection
function confirmRejection() {
    const reason = document.querySelector('input[name="rejectionReason"]:checked').value;
    const message = document.getElementById('rejectionMessage').value;

    const reasonText = {
        'incomplete': 'Incomplete Information',
        'invalid': 'Invalid Contact Details',
        'duplicate': 'Duplicate Application',
        'other': message || 'Other reason'
    }[reason];

    currentApplication.status = 'rejected';
    currentApplication.processedDate = new Date().toISOString();
    currentApplication.rejectionReason = reasonText;

    // Save changes to localStorage
    saveApplications();

    document.getElementById('rejectionModal').classList.remove('active');
    currentApplication = null;

    updateTabCounts();
    renderApplications();

    alert('Application rejected. Notification email will be sent to the applicant.');
}

// Format Date
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('en-US', options);
}
