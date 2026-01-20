// Demo Data
let members = [
    { name: 'John Doe', initials: 'JD', time: '10 mins ago', plan: 'Monthly' },
    { name: 'Jane Smith', initials: 'JS', time: '45 mins ago', plan: 'Monthly' },
    { name: 'Mike Johnson', initials: 'MJ', time: '1 hour ago', plan: 'Day Pass' },
    { name: 'Sarah Connor', initials: 'SC', time: '2 hours ago', plan: 'Monthly' }
];

let activities = [
    { type: 'gold', icon: 'fa-crown', title: 'Membership Activated', desc: 'Sarah Connor - Monthly Plan', time: 'Just now' },
    { type: 'green', icon: 'fa-sign-in-alt', title: 'Member Check-in', desc: 'John Doe scanned QR', time: '10 mins ago' },
    { type: 'orange', icon: 'fa-exclamation-circle', title: 'Issue Reported', desc: 'Treadmill #2 belt slipping', time: '1 hour ago' },
    { type: 'red', icon: 'fa-ban', title: 'Payment Failed', desc: 'Guest entry declined', time: '2 hours ago' }
];

let equipment = [
    { id: 1, name: 'Treadmill #1' }, { id: 2, name: 'Treadmill #2' }, { id: 3, name: 'Treadmill #3' },
    { id: 4, name: 'Bench Press' }, { id: 5, name: 'Incline Bench' }, { id: 6, name: 'Cable Machine' },
    { id: 7, name: 'Leg Press' }, { id: 8, name: 'Rowing Machine' }, { id: 9, name: 'Squat Rack' }
];

let issues = [
    { id: 1, equip: 'Treadmill #2', priority: 'medium', desc: 'Belt slipping during high-speed runs.', time: '1 hour ago' },
    { id: 2, equip: 'Cable Machine', priority: 'high', desc: 'Frayed cable - safety concern!', time: '3 hours ago' }
];

let expenses = [
    { id: 1, cat: 'Product Restock', amount: 850, desc: 'Protein bars & drinks' },
    { id: 2, cat: 'Miscellaneous', amount: 350, desc: 'Cleaning supplies' }
];

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('dateDisplay').textContent = new Date().toLocaleDateString('en-US', {
        weekday: 'long', month: 'short', day: 'numeric', year: 'numeric'
    });
    renderAll();
});

function renderAll() {
    renderMembers();
    renderActivities();
    renderMaintenance();
    renderExpenses();
    renderEquipment();
    updateStats();
}

function renderMembers() {
    const el = document.getElementById('membersPanel');
    el.innerHTML = members.length ? members.map(m => `
        <div class="member-row">
            <div class="member-initials">${m.initials}</div>
            <div class="member-details">
                <h5>${m.name}</h5>
                <small>${m.plan} • ${m.time}</small>
            </div>
            <span class="member-badge">Active</span>
        </div>
    `).join('') : '<div class="empty-state"><i class="fas fa-users"></i><p>No one in the gym</p></div>';
    document.getElementById('activeLabel').textContent = `${members.length} Active`;
}

function renderActivities() {
    document.getElementById('activityPanel').innerHTML = activities.map(a => `
        <div class="activity-row">
            <div class="activity-dot ${a.type}"><i class="fas ${a.icon}"></i></div>
            <div class="activity-text">
                <h5>${a.title}</h5>
                <p>${a.desc}</p>
            </div>
            <span class="activity-time">${a.time}</span>
        </div>
    `).join('');
}

function renderMaintenance() {
    const el = document.getElementById('maintenancePanel');
    el.innerHTML = issues.length ? issues.map(i => `
        <div class="maintenance-row ${i.priority === 'high' ? 'urgent' : ''}">
            <div class="maintenance-top">
                <h5>${i.equip}</h5>
                <button onclick="resolveIssue(${i.id})" title="Resolve"><i class="fas fa-check"></i></button>
            </div>
            <p class="maintenance-desc">${i.desc}</p>
            <span class="maintenance-time"><i class="fas fa-clock"></i> ${i.time}</span>
        </div>
    `).join('') : '<div class="empty-state"><i class="fas fa-check-circle"></i><p>All equipment operational</p></div>';
}

function renderExpenses() {
    const el = document.getElementById('expensePanel');
    el.innerHTML = expenses.length ? expenses.map(e => `
        <div class="expense-row">
            <div class="expense-label">
                <h5>${e.cat}</h5>
                <small>${e.desc}</small>
            </div>
            <span class="expense-value">₱${e.amount.toLocaleString()}</span>
        </div>
    `).join('') : '<div class="empty-state"><i class="fas fa-receipt"></i><p>No expenses today</p></div>';
}

function renderEquipment() {
    document.getElementById('equipList').innerHTML = equipment.map(eq => `
        <span class="equipment-chip">
            <i class="fas fa-dumbbell"></i> ${eq.name}
            <button onclick="removeEquip(${eq.id})"><i class="fas fa-times"></i></button>
        </span>
    `).join('');

    document.getElementById('reportEquip').innerHTML = '<option value="">Select equipment</option>' +
        equipment.map(eq => `<option value="${eq.name}">${eq.name}</option>`).join('');
}

function updateStats() {
    document.getElementById('inGymCount').textContent = members.length;
    document.getElementById('issuesCount').textContent = issues.length;
    document.getElementById('issuesBadge').textContent = issues.length;
    const total = expenses.reduce((s, e) => s + e.amount, 0);
    document.getElementById('expenseVal').textContent = '₱' + total.toLocaleString();
}

// Modals
function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
    document.body.style.overflow = '';
}

document.querySelectorAll('.modal-backdrop').forEach(modal => {
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(modal.id); });
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.modal-backdrop.show').forEach(m => closeModal(m.id));
});

// Forms
document.getElementById('addEquipForm').addEventListener('submit', e => {
    e.preventDefault();
    const name = document.getElementById('newEquipName').value.trim();
    if (name) {
        equipment.push({ id: Date.now(), name });
        renderEquipment();
        document.getElementById('newEquipName').value = '';
    }
});

document.getElementById('reportForm').addEventListener('submit', e => {
    e.preventDefault();
    const equip = document.getElementById('reportEquip').value;
    const priority = document.getElementById('reportPriority').value;
    const desc = document.getElementById('reportDesc').value.trim();
    if (equip && desc) {
        issues.unshift({ id: Date.now(), equip, priority, desc, time: 'Just now' });
        renderMaintenance();
        updateStats();
        closeModal('reportModal');
        e.target.reset();
    }
});

document.getElementById('expenseForm').addEventListener('submit', e => {
    e.preventDefault();
    const cat = document.getElementById('expenseCat').value;
    const amount = parseFloat(document.getElementById('expenseAmt').value);
    const desc = document.getElementById('expenseDesc').value.trim() || cat;
    if (cat && amount > 0) {
        expenses.unshift({ id: Date.now(), cat, amount, desc });
        renderExpenses();
        updateStats();
        closeModal('expenseModal');
        e.target.reset();
    }
});

function removeEquip(id) {
    equipment = equipment.filter(eq => eq.id !== id);
    renderEquipment();
}

function resolveIssue(id) {
    issues = issues.filter(i => i.id !== id);
    renderMaintenance();
    updateStats();
}

// Mobile
document.getElementById('menuBtn').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('open');
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', (e) => {
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    if (window.innerWidth <= 1024 &&
        sidebar.classList.contains('open') &&
        !sidebar.contains(e.target) &&
        !menuBtn.contains(e.target)) {
        sidebar.classList.remove('open');
    }
});
