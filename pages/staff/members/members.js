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
