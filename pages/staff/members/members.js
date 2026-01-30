document.getElementById('dateDisplay').textContent = new Date().toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });

let currentActive = null;
let gymMembers = [
    { id: 1, name: 'John Doe', initials: 'JD', type: 'membership', plan: 'Premium', time: '08:05 AM', status: 'in' },
    { id: 2, name: 'Alice Smith', initials: 'AS', type: 'daily', plan: 'Day Pass', time: '08:15 AM', status: 'in' },
    { id: 3, name: 'Michael Jordan', initials: 'MJ', type: 'membership', plan: 'Standard', time: '08:30 AM', status: 'in' },
    { id: 4, name: 'Sarah Connor', initials: 'SC', type: 'membership', plan: 'Standard', time: '08:45 AM', status: 'in' },
    { id: 5, name: 'Tony Stark', initials: 'TS', type: 'daily', plan: 'Day Pass', time: '09:00 AM', status: 'in' },
    { id: 6, name: 'Bruce Wayne', initials: 'BW', type: 'membership', plan: 'Premium', time: '09:10 AM', status: 'in' },
    { id: 7, name: 'Clark Kent', initials: 'CK', type: 'membership', plan: 'Standard', time: '09:20 AM', status: 'in' },
    { id: 8, name: 'Diana Prince', initials: 'DP', type: 'membership', plan: 'Standard', time: '09:30 AM', status: 'in' },
    { id: 9, name: 'Peter Parker', initials: 'PP', type: 'daily', plan: 'Day Pass', time: '09:45 AM', status: 'in' },
    { id: 10, name: 'Natasha Romanoff', initials: 'NR', type: 'membership', plan: 'Premium', time: '10:00 AM', status: 'in' },
    { id: 11, name: 'Steve Rogers', initials: 'SR', type: 'membership', plan: 'Standard', time: '10:15 AM', status: 'in' }
];

function activateCell(position) {
    const grid = document.getElementById('membersGrid');
    const cells = document.querySelectorAll('.grid-cell');

    // If this cell is already active, DO NOT toggle it off when clicking inside
    // Only the minimize button should close it
    if (currentActive === position) {
        return;
    }

    currentActive = position;
    grid.setAttribute('data-active', position);

    const diagonal = {
        'top-left': 'bottom-right',
        'top-right': 'bottom-left',
        'bottom-left': 'top-right',
        'bottom-right': 'top-left'
    };

    cells.forEach(cell => {
        const pos = cell.getAttribute('data-pos');
        cell.classList.remove('active', 'shrunk');

        if (pos === position) {
            cell.classList.add('active');
        } else {
            cell.classList.add('shrunk');
        }
    });
}

function minimizeCell() {
    const grid = document.getElementById('membersGrid');
    const cells = document.querySelectorAll('.grid-cell');

    grid.setAttribute('data-active', 'none');
    cells.forEach(cell => cell.classList.remove('active', 'shrunk'));
    currentActive = null;
}

// Exit Confirmation Logic
let memberToExit = null;

function openExitConfirmation(id) {
    memberToExit = id;
    document.getElementById('exitModal').classList.add('active');
}

function closeExitConfirmation() {
    document.getElementById('exitModal').classList.remove('active');
    memberToExit = null;
}

function confirmExit() {
    if (memberToExit) {
        gymMembers = gymMembers.filter(m => m.id !== memberToExit);
        renderWhosIn();
        closeExitConfirmation();
    }
}

// Filter Logic
function filterWhosIn() {
    renderWhosIn();
}

function renderWhosIn() {
    const list = document.getElementById('whosInList');
    const count = document.getElementById('activeCount');
    const searchTerm = document.getElementById('whosInSearch') ? document.getElementById('whosInSearch').value.toLowerCase() : '';

    // Filter out members who have 'left' and match search
    const activeMembers = gymMembers.filter(m => {
        return m.status !== 'left' && m.name.toLowerCase().includes(searchTerm);
    });

    // Update Count (Always icon + number)
    count.innerHTML = `<i class="fas fa-user"></i> <span>${activeMembers.length}</span>`;

    if (activeMembers.length === 0) {
        list.innerHTML = '<div class="empty-state"><i class="fas fa-user-clock"></i><p>No members found</p></div>';
        return;
    }

    // Columns: Avatar | Name | Type | Time | Action
    list.innerHTML = activeMembers.map(m => `
                <div class="member-item">
                    <div class="avatar">${m.initials}</div>
                    
                    <div class="col-info">
                        <span class="main-text">${m.name}</span>
                    </div>

                    <div class="col-info">
                        <span class="main-text" style="font-size:12px;">${m.type === 'daily' ? 'Day Pass' : 'Membership'}</span>
                    </div>

                    <div class="col-info">
                        <span class="main-text" style="font-size:12px;">${m.time}</span>
                    </div>

                    <button class="action-btn-left" onclick="event.stopPropagation(); openExitConfirmation(${m.id})">
                        <i class="fas fa-sign-out-alt"></i> Left
                    </button>
                </div>
            `).join('');

    // Removed textContent update since innerHTML was used above
}

// Scan Result State
let scannedMember = null;

function resetScanResult() {
    const panel = document.getElementById('scanResultPanel');
    const actions = document.getElementById('scanActions');
    panel.className = 'result-panel waiting';
    panel.innerHTML = `
                <i class="fas fa-qrcode"></i>
                <p>Waiting for scan...</p>
                <p style="font-size:10px; margin-top:8px; opacity:0.6;">Point camera at member's QR code</p>
            `;

    if (actions) {
        actions.innerHTML = `
                <button class="allow-entry-btn" id="allowEntryBtn" disabled>
                    <i class="fas fa-door-open"></i> ALLOW ENTRY
                </button>
               `;
    }
    scannedMember = null;
}

function simulateScanSuccess() {
    const panel = document.getElementById('scanResultPanel');
    const actions = document.getElementById('scanActions');

    // Simulate finding a valid member
    scannedMember = {
        id: Date.now(),
        name: 'Maria Santos',
        initials: 'MS',
        plan: 'Monthly Premium',
        status: 'active',
        time: 'Just now'
    };

    panel.className = 'result-panel success';
    // Layout Textures
    panel.innerHTML = `
                <div class="scan-card">
                    <div class="sc-status active">ACTIVE</div>
                    <div class="sc-image">
                       <img src="../../assets/images/member_sample.png" alt="Member" />
                    </div>
                    <div class="sc-details">
                        <div class="sc-box">
                            <span class="label">Name</span>
                            <span class="val">${scannedMember.name}</span>
                        </div>
                        <div class="sc-box">
                            <span class="label">Member Type</span>
                            <span class="val">Member</span>
                        </div>
                    </div>
                </div>
            `;

    // Actions
    actions.innerHTML = `
                <button class="allow-entry-btn success" onclick="event.stopPropagation(); allowEntry();">
                    <i class="fas fa-check"></i> Allow Entry
                </button>
                <button class="allow-entry-btn secondary" onclick="event.stopPropagation(); resetScanResult();">
                    <i class="fas fa-redo"></i> Rescan
                </button>
            `;
}

function simulateScanExpired() {
    const panel = document.getElementById('scanResultPanel');
    const actions = document.getElementById('scanActions');

    scannedMember = null; // No entry allowed

    panel.className = 'result-panel expired';
    panel.innerHTML = `
                <div class="scan-card inactive">
                    <div class="sc-status inactive">INACTIVE</div>
                    <div class="sc-image">
                       <img src="../../assets/images/member_sample.png" alt="Member" style="filter: grayscale(1);" />
                    </div>
                    <div class="sc-details">
                        <div class="sc-box">
                            <span class="label">Name</span>
                            <span class="val">Maria Santos</span>
                        </div>
                        <div class="sc-box">
                            <span class="label">Status</span>
                            <span class="val expired-text">Expired</span>
                        </div>
                    </div>
                </div>
            `;

    // Actions: Renew and Rescan
    // Actions: Renew and Rescan separated
    actions.innerHTML = `
                <button class="allow-entry-btn warning" onclick="event.stopPropagation(); alert('Redirecting to Renewal UI...');">
                    <i class="fas fa-sync"></i> Renew
                </button>
                <button class="allow-entry-btn secondary" onclick="event.stopPropagation(); resetScanResult();">
                    <i class="fas fa-redo"></i> Rescan
                </button>
            `;
}



function simulateScanFail() {
    const panel = document.getElementById('scanResultPanel');
    const btn = document.getElementById('allowEntryBtn');

    scannedMember = null;

    panel.className = 'result-panel error';
    panel.innerHTML = `
                <div class="result-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="error-title">Member Not Found</div>
                    <div class="error-msg">This QR code is not registered in the system.<br>Please verify and try again.</div>
                </div>
            `;
    btn.disabled = true;

    // Auto-reset after 3 seconds
    setTimeout(resetScanResult, 3000);
}

function allowEntry() {
    if (!scannedMember) return;

    gymMembers.unshift(scannedMember);
    renderWhosIn();
    resetScanResult();

    // Switch to Who's In to show the new entry
    activateCell('top-left');
}

let selectedPlan = null;
function selectPlan(el, price) {
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedPlan = price;
}

function confirmActivation() {
    if (!selectedPlan) { alert('Please select a plan first'); return; }
    alert('Membership activated for ₱' + selectedPlan.toLocaleString());
    selectedPlan = null;
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
}

// ===== NEW MEMBER STATE MANAGEMENT =====
function setNmState(stateId) {
    document.querySelectorAll('.nm-state').forEach(s => s.classList.remove('active'));
    document.getElementById(stateId).classList.add('active');
}

function showNewMemberChoice() {
    setNmState('nmStateChoice');
    // Clear forms
    document.getElementById('dailyPassName').value = '';
    document.getElementById('memberName').value = '';
    document.getElementById('memberEmail').value = '';
    document.getElementById('memberPhone').value = '';
    selectedMemberPlan = null;
    document.querySelectorAll('#nmStateMembershipForm .plan-card').forEach(c => c.classList.remove('selected'));
}

function showDailyPassForm() {
    setNmState('nmStateDailyForm');
}

function showMembershipForm() {
    setNmState('nmStateMembershipForm');
}

function applyDailyPass() {
    const name = document.getElementById('dailyPassName').value.trim();
    if (!name) {
        alert('Please enter customer name');
        return;
    }

    // Generate initials
    const parts = name.split(' ');
    const initials = parts.length >= 2
        ? parts[0][0].toUpperCase() + parts[parts.length - 1][0].toUpperCase()
        : name.substring(0, 2).toUpperCase();

    // Add to gym members
    const newMember = {
        id: Date.now(),
        name: name,
        initials: initials,
        type: 'daily',
        plan: 'Day Pass',
        time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
        status: 'in'
    };
    gymMembers.unshift(newMember);
    renderWhosIn();

    // Update Success Display
    document.getElementById('dailySuccessName').textContent = name;

    // Show Success state (No QR)
    setNmState('nmStateDailySuccess');
}

let selectedMemberPlan = null;
function selectMemberPlan(el, planName, price) {
    // Remove selected class from all plan cards in the form
    const container = el.closest('.plan-grid');
    if (container) {
        container.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    }

    // Add selected class to clicked element
    el.classList.add('selected');
    selectedMemberPlan = { name: planName, price: price };

    // Clear potential error
    const planError = document.getElementById('plan-error');
    if (planError) planError.remove();
}

function showError(inputIds, type, msg) {
    if (type === 'plan') {
        // Plan error logic (custom)
        const grid = document.querySelector('.plan-grid');
        if (grid && !document.getElementById('plan-error')) {
            const err = document.createElement('div');
            err.id = 'plan-error';
            err.className = 'error-message';
            err.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${msg}`;
            grid.parentNode.appendChild(err);
        }
        return;
    }

    const input = document.getElementById(inputIds);
    if (!input) return;

    input.classList.add('input-error');

    // specialized parent check due to input-wrapper
    const wrapper = input.closest('.nm-form-group');
    if (wrapper && !wrapper.querySelector('.error-message')) {
        const err = document.createElement('div');
        err.className = 'error-message';
        err.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${msg}`;
        wrapper.appendChild(err);
    }

    // Add listener to clear on input
    input.addEventListener('input', function () {
        this.classList.remove('input-error');
        const eMsg = wrapper.querySelector('.error-message');
        if (eMsg) eMsg.remove();
    }, { once: true });
}

function activateMembership() {
    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(e => e.remove());
    document.querySelectorAll('.input-error').forEach(e => e.classList.remove('input-error'));

    const nameInput = document.getElementById('memberName');
    const emailInput = document.getElementById('memberEmail');
    const phoneInput = document.getElementById('memberPhone');

    const name = nameInput.value.trim();
    const email = emailInput.value.trim();
    const phone = phoneInput.value.trim();

    let hasError = false;

    if (!name) { showError('memberName', 'input', 'Full name is required'); hasError = true; }
    if (!email) { showError('memberEmail', 'input', 'Email address is required'); hasError = true; }
    if (!phone) { showError('memberPhone', 'input', 'Phone number is required'); hasError = true; }
    if (!selectedMemberPlan) { showError(null, 'plan', 'Please select a membership plan'); hasError = true; }

    if (hasError) return;

    // Generate initials
    const parts = name.split(' ');
    const initials = parts.length >= 2
        ? parts[0][0].toUpperCase() + parts[parts.length - 1][0].toUpperCase()
        : name.substring(0, 2).toUpperCase();

    // Add to gym members
    const newMember = {
        id: Date.now(),
        name: name,
        initials: initials,
        type: 'membership',
        plan: selectedMemberPlan.name,
        time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
        status: 'in'
    };
    gymMembers.unshift(newMember);
    renderWhosIn();

    // Update QR display
    document.getElementById('memberQRName').textContent = name;
    document.getElementById('memberQRPlan').textContent = selectedMemberPlan.name + ' - ₱' + selectedMemberPlan.price.toLocaleString();

    // Show QR state
    setNmState('nmStateMembershipQR');
}

function finishRegistration() {
    showNewMemberChoice();
}

document.getElementById('menuBtn').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('open');
});

renderWhosIn();

// ===== PHOTO UPLOAD =====
function previewPhoto(input) {
    const box = document.getElementById('photoUploadBox');
    const removeBtn = document.getElementById('removePhotoBtn');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // Create or update valid img preview
            let img = box.querySelector('.photo-preview');
            if (!img) {
                img = document.createElement('img');
                img.className = 'photo-preview';
                box.appendChild(img);
            }
            img.src = e.target.result;

            box.classList.add('has-photo');
            // Hide icon and text by setting display to none on i and span direct children
            const icon = box.querySelector('i');
            const span = box.querySelector('span');
            if (icon) icon.style.display = 'none';
            if (span) span.style.display = 'none';

            // Show remove button
            if (removeBtn) {
                removeBtn.style.display = 'flex';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removePhoto(e) {
    e.stopPropagation();
    const input = document.getElementById('memberPhoto');
    const box = document.getElementById('photoUploadBox');
    const removeBtn = document.getElementById('removePhotoBtn');

    // Reset input
    input.value = '';

    // Reset box
    box.classList.remove('has-photo');
    const img = box.querySelector('.photo-preview');
    if (img) img.remove();

    // Show icon and text
    const icon = box.querySelector('i');
    const span = box.querySelector('span');
    if (icon) icon.style.display = '';
    if (span) span.style.display = '';

    // Hide remove button
    if (removeBtn) {
        removeBtn.style.display = 'none';
    }
}

// ===== PENDING MEMBERSHIPS =====
let pendingMembers = [
    {
        id: 101,
        name: 'Carlos Martinez',
        email: 'carlos@email.com',
        phone: '0917-123-4567',
        photo: null,
        appliedAt: '2 hours ago'
    },
    {
        id: 102,
        name: 'Ana Reyes',
        email: 'ana.reyes@email.com',
        phone: '0918-987-6543',
        photo: null,
        appliedAt: '5 hours ago'
    }
];

function openPendingModal() {
    document.getElementById('pendingModal').classList.add('active');
    renderPendingList();
}

function closePendingModal() {
    document.getElementById('pendingModal').classList.remove('active');
}

function renderPendingList() {
    const container = document.getElementById('pendingList');
    const badge = document.getElementById('pendingCount');

    badge.textContent = pendingMembers.length;
    if (pendingMembers.length === 0) {
        badge.style.display = 'none';
    } else {
        badge.style.display = 'inline';
    }

    if (pendingMembers.length === 0) {
        container.innerHTML = `
                    <div class="pending-empty">
                        <i class="fas fa-check-circle"></i>
                        <p>No pending applications</p>
                    </div>
                `;
        return;
    }

    container.innerHTML = pendingMembers.map(m => `
                <div class="pending-card" id="pending-${m.id}">
                    <div class="pending-card-header">
                        <div class="pending-card-photo">
                            ${m.photo ? `<img src="${m.photo}" alt="${m.name}">` : `<i class="fas fa-user"></i>`}
                        </div>
                        <div class="pending-card-info">
                            <h4>${m.name}</h4>
                            <p><i class="fas fa-envelope"></i> ${m.email}</p>
                            <p><i class="fas fa-phone"></i> ${m.phone}</p>
                            <p style="color: var(--text-dim);"><i class="fas fa-clock"></i> Applied ${m.appliedAt}</p>
                        </div>
                    </div>
                    <div class="pending-card-actions">
                        <button class="pending-btn approve" onclick="approvePending(${m.id})"><i class="fas fa-check"></i> Approve</button>
                        <button class="pending-btn reject" onclick="rejectPending(${m.id})"><i class="fas fa-times"></i> Reject</button>
                    </div>
                </div>
            `).join('');
}

function approvePending(id) {
    const member = pendingMembers.find(m => m.id === id);
    if (member && confirm(`Approve ${member.name}'s membership application?`)) {
        // Generate initials
        const parts = member.name.split(' ');
        const initials = parts.length >= 2
            ? parts[0][0].toUpperCase() + parts[parts.length - 1][0].toUpperCase()
            : member.name.substring(0, 2).toUpperCase();

        // Add to gym as active member
        gymMembers.unshift({
            id: Date.now(),
            name: member.name,
            initials: initials,
            type: 'membership',
            plan: 'Monthly',
            time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
            status: 'in'
        });
        renderWhosIn();

        // Remove from pending
        pendingMembers = pendingMembers.filter(m => m.id !== id);
        renderPendingList();

        alert(`${member.name} has been approved and activated!`);
    }
}

function rejectPending(id) {
    const member = pendingMembers.find(m => m.id === id);
    if (member && confirm(`Reject ${member.name}'s application?`)) {
        pendingMembers = pendingMembers.filter(m => m.id !== id);
        renderPendingList();
    }
}

// Close modal on backdrop click
document.getElementById('pendingModal').addEventListener('click', function (e) {
    if (e.target === this) closePendingModal();
});

// Date Display
function updateDate() {
    const now = new Date();
    const isDesktop = window.matchMedia("(min-width: 768px)").matches;

    const options = isDesktop
        ? { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' }
        : { weekday: 'short', month: 'short', day: 'numeric' };

    const dateStr = now.toLocaleDateString('en-US', options);
    document.getElementById('dateDisplay').textContent = dateStr;
}
window.addEventListener('resize', updateDate);
updateDate();
setInterval(updateDate, 60000);

renderPendingList();
// ===== MEMBER DIRECTORY FUNCTIONS =====

// Directory mock data (includes Who's In members + expired members)
const directoryMembers = [
    { id: "MG-001", name: "John Doe", status: "active", plan: "Regular Monthly", expiryDate: "Feb 25, 2026", instructor: "3 months remaining", qrCode: "QR-JD-001", image: null },
    { id: "MG-002", name: "Alice Smith", status: "expired", plan: "Day Pass", expiryDate: "Jan 10, 2026", instructor: "None", qrCode: null, image: null },
    { id: "MG-003", name: "Michael Jordan", status: "active", plan: "Standard", expiryDate: "Mar 01, 2026", instructor: "1 month remaining", qrCode: "QR-MJ-001", image: null },
    { id: "MG-004", name: "Sarah Connor", status: "active", plan: "Standard", expiryDate: "Feb 20, 2026", instructor: "None", qrCode: "QR-SC-001", image: null },
    { id: "MG-005", name: "Tony Stark", status: "expired", plan: "Premium", expiryDate: "Dec 31, 2025", instructor: "None", qrCode: null, image: null },
    { id: "MG-006", name: "Bruce Wayne", status: "active", plan: "Premium", expiryDate: "Apr 15, 2026", instructor: "6 months remaining", qrCode: "QR-BW-001", image: null },
    { id: "MG-007", name: "Clark Kent", status: "active", plan: "Standard", expiryDate: "Feb 28, 2026", instructor: "None", qrCode: "QR-CK-001", image: null },
    { id: "MG-008", name: "Diana Prince", status: "expired", plan: "Standard", expiryDate: "Jan 05, 2026", instructor: "None", qrCode: null, image: null },
    { id: "MG-009", name: "Peter Parker", status: "active", plan: "Day Pass", expiryDate: "Today", instructor: "None", qrCode: "QR-PP-001", image: null },
    { id: "MG-010", name: "Natasha Romanoff", status: "active", plan: "Premium", expiryDate: "Mar 10, 2026", instructor: "None", qrCode: "QR-NR-001", image: null },
    { id: "MG-011", name: "Steve Rogers", status: "active", plan: "Standard", expiryDate: "Feb 25, 2026", instructor: "None", qrCode: "QR-SR-001", image: null }
];

let currentDirectoryMember = null;

// Search for a member in the directory
function searchDirectoryMember() {
    const input = document.getElementById('dirSearchInput');
    const searchName = input.value.trim();

    if (!searchName) {
        return;
    }

    // Search for member (case-insensitive)
    const found = directoryMembers.find(m =>
        m.name.toLowerCase() === searchName.toLowerCase() ||
        m.name.toLowerCase().includes(searchName.toLowerCase()) ||
        (m.id && m.id.toLowerCase() === searchName.toLowerCase())
    );

    if (found) {
        showDirectoryResult(found);
    } else {
        showDirectoryNotFound(searchName);
    }
}

// Display found member result
function showDirectoryResult(member) {
    currentDirectoryMember = member;

    // Hide search and not found states
    document.getElementById('dirSearchState').style.display = 'none';
    document.getElementById('dirNotFoundState').style.display = 'none';

    // Show result state
    document.getElementById('dirResultState').style.display = 'flex';

    // Populate member details
    document.getElementById('dirMemberName').textContent = member.name;

    const idEl = document.getElementById('dirMemberId');
    if (idEl) idEl.textContent = member.id || 'N/A';

    document.getElementById('dirMemberPlan').textContent = member.plan || 'Standard';
    document.getElementById('dirMemberExpiry').textContent = member.expiryDate;

    // Instructor Stats
    const instrEl = document.getElementById('dirInstructorStats');
    if (instrEl) instrEl.textContent = member.instructor || 'None';

    // Set status badge
    const statusBadge = document.getElementById('dirMemberStatus');
    // Remove old classes first
    statusBadge.className = 'dir-status-text';
    statusBadge.textContent = member.status === 'active' ? 'Active' : 'Expired';
    if (member.status === 'active') statusBadge.classList.add('active');
    else statusBadge.classList.add('expired');


    // Update expiry label based on plan
    const expiryLabel = document.getElementById('dirExpiryLabel');
    if (expiryLabel) {
        if (member.plan === 'Day Pass') {
            expiryLabel.textContent = 'VALID UNTIL';
        } else {
            expiryLabel.textContent = member.status === 'expired' ? 'EXPIRED' : 'EXPIRES';
        }
    }

    // Set action button text (Show QR or Renew)
    const actionBtn = document.getElementById('dirActionBtn');
    if (actionBtn) {
        if (member.status === 'active') {
            actionBtn.innerHTML = '<i class="fas fa-qrcode"></i> Show QR';
            // Use primary class but with yellow style overrides handled in CSS
            actionBtn.className = 'dir-btn continue-btn';
            // Note: continue-btn class gives the yellow style, even if text says "Show QR"
        } else {
            actionBtn.innerHTML = '<i class="fas fa-sync"></i> Renew';
            actionBtn.className = 'dir-btn continue-btn renew-mode';
            actionBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            actionBtn.style.color = '#fff';
        }
    }

    // Set member photo (placeholder for now)
    const photo = document.getElementById('dirMemberPhoto');
    if (member.image) {
        photo.innerHTML = `<img src="${member.image}" alt="${member.name}">`;
    } else {
        photo.innerHTML = `<i class="fas fa-user"></i>`;
    }
}

// Display not found state
function showDirectoryNotFound(searchName) {
    // Hide search and result states
    document.getElementById('dirSearchState').style.display = 'none';
    document.getElementById('dirResultState').style.display = 'none';

    // Show not found state
    document.getElementById('dirNotFoundState').style.display = 'flex';
    document.getElementById('dirSearchedName').textContent = searchName;
}

// Close result/not found and return to search
function closeDirectoryResult() {
    // Hide all states except search
    document.getElementById('dirResultState').style.display = 'none';
    document.getElementById('dirNotFoundState').style.display = 'none';

    // Show search state
    document.getElementById('dirSearchState').style.display = 'flex';

    // Clear search input
    document.getElementById('dirSearchInput').value = '';
    document.getElementById('dirSearchInput').focus();

    currentDirectoryMember = null;
}

// Handle action button click (Show QR or Renew)
function handleDirectoryAction() {
    if (!currentDirectoryMember) return;

    if (currentDirectoryMember.status === 'active') {
        // Show QR Code
        showDirQRCode(currentDirectoryMember);
    } else {
        // Redirect to renewal (switch to New Member panel with membership form)
        closeDirectoryResult();
        activateCell('bottom-left');
        showMembershipForm();

        // Optionally pre-fill the form with member's name
        document.getElementById('memberName').value = currentDirectoryMember.name;
    }
}

// Check In from Directory
// Check In from Directory (Opens Dedicated Modal)
window.directoryCheckIn = function () {
    if (!currentDirectoryMember) {
        alert('No member selected!');
        return;
    }

    // Populate Modal
    const nameEl = document.getElementById('dirCheckInName');
    if (nameEl) nameEl.textContent = currentDirectoryMember.name;

    // Show Modal (Force Flex)
    const modal = document.getElementById('dirCheckInModal');
    if (modal) {
        modal.classList.add('active');
        modal.style.display = 'flex';
    } else {
        console.error('Directory check-in modal missing!');
    }
};

// Confirm Check-In
window.confirmDirectoryCheckIn = function () {
    // Hide Modal
    const modal = document.getElementById('dirCheckInModal');
    if (modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
    }

    // Add to Active Visits
    addDirectoryMemberToActiveVisits(currentDirectoryMember);

    // Close Directory Result
    closeDirectoryResult();
};

// Cancel Check-In
window.cancelDirectoryCheckIn = function () {
    const modal = document.getElementById('dirCheckInModal');
    if (modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
    }
};

// Logic to Add Member to "Who's In" List (Directory Specific)
function addDirectoryMemberToActiveVisits(member) {
    if (!member) return;

    // Get "Who's In" container
    const whosInList = document.querySelector('#whosInList');
    if (!whosInList) return;

    // Remove empty state if present
    const emptyState = whosInList.querySelector('.empty-state');
    if (emptyState) emptyState.style.display = 'none';

    // Create visitor item
    const visitorItem = document.createElement('div');
    visitorItem.className = 'member-item';

    // Generate initials
    const initials = member.name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
        .substring(0, 2);

    // Determine Type Label
    const typeLabel = (member.plan === 'Day Pass') ? 'Day Pass' : 'Membership';

    // Get current time
    const now = new Date();
    const timeIn = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });

    visitorItem.innerHTML = `
        <div class="avatar">${initials}</div>
        
        <div class="col-info">
            <span class="main-text">${member.name}</span>
        </div>

        <div class="col-info">
            <span class="main-text" style="font-size:12px;">${typeLabel}</span>
        </div>

        <div class="col-info">
            <span class="main-text" style="font-size:12px;">${timeIn}</span>
        </div>

        <button class="action-btn-left" onclick="event.stopPropagation();">
            <i class="fas fa-sign-out-alt"></i> Left
        </button>
    `;

    // Add to list (at top)
    whosInList.insertBefore(visitorItem, whosInList.firstChild);

    // Update count in Preview
    const previewCount = document.getElementById('previewMemberCount');
    if (previewCount) {
        let count = parseInt(previewCount.textContent || '0');
        previewCount.textContent = count + 1;
    }

    // Update count in Header
    const activeCountSpan = document.querySelector('#activeCount span:first-child');
    if (activeCountSpan) {
        let count = parseInt(activeCountSpan.textContent || '0');
        activeCountSpan.textContent = count + 1;
    }
}

// Show QR Code Modal
function showDirQRCode(member) {
    const modal = document.getElementById('dirQRModal');
    const qrCanvas = document.getElementById('dirQRCodeCanvas');
    const memberName = document.getElementById('dirQRMemberName');

    memberName.textContent = member.name;

    // Generate QR code Simulation
    qrCanvas.innerHTML = `
        <div style="
            width: 200px; 
            height: 200px; 
            background: #fff; 
            padding: 10px; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: center;
        ">
            <div style="
                width: 160px; 
                height: 160px; 
                background-image: repeating-linear-gradient(45deg, #000 25%, transparent 25%, transparent 75%, #000 75%, #000), repeating-linear-gradient(45deg, #000 25%, #fff 25%, #fff 75%, #000 75%, #000);
                background-position: 0 0, 10px 10px;
                background-size: 20px 20px;
                border: 4px solid #000;
                image-rendering: pixelated;
            "></div>
            <div style="margin-top: 8px; font-family: monospace; font-size: 12px; color: #000; font-weight: bold;">
                ${member.id || 'NO-ID'}
            </div>
        </div>
    `;

    modal.classList.add('active');
}

// Close QR Modal
function closeDirQRModal() {
    document.getElementById('dirQRModal').classList.remove('active');
}

// Add Enter key support for search
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('dirSearchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                searchDirectoryMember();
            }
        });
    }
});
