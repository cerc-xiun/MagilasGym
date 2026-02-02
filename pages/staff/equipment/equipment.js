// ======================
// EQUIPMENT MAINTENANCE
// Comprehensive Management System
// ======================

// Status Types Configuration
const STATUS_TYPES = {
    excellent: {
        label: "Working Fine",
        icon: "fa-check-circle",
        class: "status-excellent"
    },
    maintenance: {
        label: "Needs Maintenance",
        icon: "fa-exclamation-triangle",
        class: "status-maintenance"
    },
    repair: {
        label: "Under Maintenance",
        icon: "fa-wrench",
        class: "status-repair"
    },
    critical: {
        label: "Critical/Broken",
        icon: "fa-times-circle",
        class: "status-critical"
    }
};

// Category Badge Configuration
const CATEGORY_CLASSES = {
    "Cardio": "category-cardio",
    "Strength": "category-strength",
    "Free Weights": "category-weights",
    "Machines": "category-machines"
};

// Global State
let equipment = [];
let currentFilter = 'all';
let searchTerm = '';
let activeDropdown = null;

// ======================
// INITIALIZATION
// ======================

document.addEventListener('DOMContentLoaded', () => {
    loadEquipment();
    renderEquipment();
    updateStatistics();
    initializeSearch();
    setTodayDate();
});

// Load equipment from localStorage or create mock data
function loadEquipment() {
    const stored = localStorage.getItem('maintenanceEquipment');
    if (stored) {
        equipment = JSON.parse(stored);
    } else {
        equipment = createMockData();
        saveEquipment();
    }
}

// Save equipment to localStorage
function saveEquipment() {
    localStorage.setItem('maintenanceEquipment', JSON.stringify(equipment));
}

// Create realistic mock data
function createMockData() {
    const today = new Date();
    const formatDate = (daysAgo) => {
        const date = new Date(today);
        date.setDate(date.getDate() - daysAgo);
        return date.toISOString().split('T')[0];
    };

    return [
        // Cardio Equipment
        {
            id: "TRDML-001",
            name: "Treadmill #1",
            category: "Cardio",
            status: "excellent",
            location: "Main Floor - Zone A",
            purchaseDate: "2024-01-15",
            lastMaintenance: formatDate(10),
            notes: "Regular usage, belt in good condition",
            maintenanceHistory: [
                {
                    date: formatDate(10),
                    type: "routine",
                    description: "Lubricated belt, tightened screws, cleaned motor",
                    performedBy: "Staff Member"
                },
                {
                    date: formatDate(25),
                    type: "inspection",
                    description: "Weekly safety inspection - all systems normal",
                    performedBy: "Staff Member"
                },
                {
                    date: formatDate(40),
                    type: "cleaning",
                    description: "Deep clean of entire unit, sanitized all surfaces",
                    performedBy: "Cleaning Crew"
                },
                {
                    date: formatDate(55),
                    type: "routine",
                    description: "Belt tension adjustment, console calibration",
                    performedBy: "Staff Member"
                },
                {
                    date: formatDate(75),
                    type: "repair",
                    description: "Replaced worn belt",
                    performedBy: "Technician"
                },
                {
                    date: formatDate(90),
                    type: "inspection",
                    description: "Monthly comprehensive inspection",
                    performedBy: "Staff Member"
                },
                {
                    date: formatDate(105),
                    type: "routine",
                    description: "Lubricated moving parts, checked electrical connections",
                    performedBy: "Maintenance Team"
                },
                {
                    date: formatDate(120),
                    type: "cleaning",
                    description: "Quarterly deep cleaning service",
                    performedBy: "Professional Service"
                },
                {
                    date: formatDate(140),
                    type: "repair",
                    description: "Fixed speed sensor malfunction",
                    performedBy: "Technician"
                },
                {
                    date: formatDate(160),
                    type: "inspection",
                    description: "Safety certification inspection - passed",
                    performedBy: "Certified Inspector"
                },
                {
                    date: formatDate(180),
                    type: "routine",
                    description: "Replaced motor brushes, cleaned fan",
                    performedBy: "Technician"
                },
                {
                    date: formatDate(200),
                    type: "routine",
                    description: "Annual service - full system check",
                    performedBy: "Service Team"
                }
            ]
        },
        {
            id: "TRDML-002",
            name: "Treadmill #2",
            category: "Cardio",
            status: "maintenance",
            location: "Main Floor - Zone A",
            purchaseDate: "2024-01-15",
            lastMaintenance: formatDate(45),
            notes: "Belt making squeaking noise, needs attention soon",
            maintenanceHistory: [
                {
                    date: formatDate(45),
                    type: "inspection",
                    description: "Inspected belt tension, noted minor wear",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "ELPTI-001",
            name: "Elliptical #1",
            category: "Cardio",
            status: "excellent",
            location: "Main Floor - Zone B",
            purchaseDate: "2024-02-20",
            lastMaintenance: formatDate(15),
            notes: "Smooth operation, popular with members",
            maintenanceHistory: [
                {
                    date: formatDate(15),
                    type: "routine",
                    description: "Cleaned and lubricated moving parts",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "BIKE-003",
            name: "Stationary Bike #3",
            category: "Cardio",
            status: "critical",
            location: "Main Floor - Zone B",
            purchaseDate: "2023-11-10",
            lastMaintenance: formatDate(60),
            notes: "Left pedal broken, immediate replacement needed",
            maintenanceHistory: [
                {
                    date: formatDate(60),
                    type: "routine",
                    description: "Standard maintenance check",
                    performedBy: "Staff Member"
                }
            ]
        },

        // Strength Machines
        {
            id: "LGPRS-001",
            name: "Leg Press Machine",
            category: "Strength",
            status: "excellent",
            location: "Strength Area - Section 1",
            purchaseDate: "2024-03-05",
            lastMaintenance: formatDate(20),
            notes: "Heavy-duty machine, performing well",
            maintenanceHistory: [
                {
                    date: formatDate(20),
                    type: "routine",
                    description: "Lubricated guide rails, checked plates",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "CHPRS-001",
            name: "Chest Press Machine",
            category: "Strength",
            status: "repair",
            location: "Strength Area - Section 1",
            purchaseDate: "2023-12-01",
            lastMaintenance: formatDate(5),
            notes: "Currently under maintenance - cable system being repaired",
            maintenanceHistory: [
                {
                    date: formatDate(5),
                    type: "repair",
                    description: "Started cable system repair, ordered replacement parts",
                    performedBy: "Technician"
                },
                {
                    date: formatDate(40),
                    type: "routine",
                    description: "Routine inspection and cleaning",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "LATPL-001",
            name: "Lat Pulldown",
            category: "Strength",
            status: "excellent",
            location: "Strength Area - Section 2",
            purchaseDate: "2024-01-20",
            lastMaintenance: formatDate(12),
            notes: "Well-maintained, popular equipment",
            maintenanceHistory: [
                {
                    date: formatDate(12),
                    type: "routine",
                    description: "Inspected cables, lubricated pulleys",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "CBLCR-001",
            name: "Cable Crossover",
            category: "Strength",
            status: "maintenance",
            location: "Strength Area - Section 2",
            purchaseDate: "2023-10-15",
            lastMaintenance: formatDate(50),
            notes: "Right cable showing signs of fraying, schedule replacement",
            maintenanceHistory: [
                {
                    date: formatDate(50),
                    type: "inspection",
                    description: "Noticed cable wear on right side",
                    performedBy: "Staff Member"
                }
            ]
        },

        // Free Weights
        {
            id: "BARBL-SET",
            name: "Barbell Set (Olympic)",
            category: "Free Weights",
            status: "excellent",
            location: "Free Weight Zone",
            purchaseDate: "2024-01-10",
            lastMaintenance: formatDate(30),
            notes: "Complete set, all bars in good condition",
            maintenanceHistory: [
                {
                    date: formatDate(30),
                    type: "cleaning",
                    description: "Deep cleaned all barbells, checked sleeves",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "DMBL-RACK",
            name: "Dumbbell Rack (5-50lbs)",
            category: "Free Weights",
            status: "excellent",
            location: "Free Weight Zone",
            purchaseDate: "2023-12-01",
            lastMaintenance: formatDate(25),
            notes: "Full set complete, no missing weights",
            maintenanceHistory: [
                {
                    date: formatDate(25),
                    type: "inspection",
                    description: "Inventory check - all dumbbells accounted for",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "WGTPL-SET",
            name: "Weight Plates (Olympic)",
            category: "Free Weights",
            status: "excellent",
            location: "Free Weight Zone",
            purchaseDate: "2024-01-10",
            lastMaintenance: formatDate(30),
            notes: "Rubber-coated plates, minimal wear",
            maintenanceHistory: [
                {
                    date: formatDate(30),
                    type: "cleaning",
                    description: "Cleaned all plates, organized by weight",
                    performedBy: "Staff Member"
                }
            ]
        },
        {
            id: "SQTRCK-001",
            name: "Squat Rack",
            category: "Machines",
            status: "maintenance",
            location: "Free Weight Zone",
            purchaseDate: "2023-11-20",
            lastMaintenance: formatDate(55),
            notes: "Safety pins need tightening, minor wobble detected",
            maintenanceHistory: [
                {
                    date: formatDate(55),
                    type: "inspection",
                    description: "Routine safety check",
                    performedBy: "Staff Member"
                }
            ]
        }
    ];
}

// ======================
// RENDERING FUNCTIONS
// ======================

function renderEquipment() {
    const tbody = document.getElementById('equipmentTableBody');

    // Filter equipment based on current filter and search
    let filtered = equipment.filter(item => {
        // Status filter
        if (currentFilter === 'excellent' && item.status !== 'excellent') return false;
        if (currentFilter === 'issues' && !['maintenance', 'repair'].includes(item.status)) return false;
        if (currentFilter === 'critical' && item.status !== 'critical') return false;

        // Search filter
        if (searchTerm) {
            const search = searchTerm.toLowerCase();
            return (
                item.id.toLowerCase().includes(search) ||
                item.name.toLowerCase().includes(search) ||
                item.category.toLowerCase().includes(search) ||
                item.location.toLowerCase().includes(search)
            );
        }

        return true;
    });

    if (filtered.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No equipment found</h3>
                    <p>Try adjusting your filters or search terms</p>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = filtered.map((item, index) => {
        const originalIndex = equipment.indexOf(item);
        const statusConfig = STATUS_TYPES[item.status];
        const categoryClass = CATEGORY_CLASSES[item.category] || '';

        return `
            <tr onclick="toggleRowDetails(${originalIndex})" id="row-${originalIndex}">
                <td><span class="equipment-id">${item.id}</span></td>
                <td>
                    <span class="equipment-name">${item.name}</span>
                    <i class="fas fa-chevron-down expand-indicator"></i>
                </td>
                <td><span class="category-badge ${categoryClass}">${item.category}</span></td>
                <td>
                    <span class="status-badge ${statusConfig.class}">
                        <i class="fas ${statusConfig.icon}"></i>
                        ${statusConfig.label}
                    </span>
                </td>
                <td>${item.location || 'Not specified'}</td>
                <td class="maintenance-date">${item.lastMaintenance ? formatDateDisplay(item.lastMaintenance) : 'Never'}</td>
                <td onclick="event.stopPropagation()">
                    <div class="actions-menu">
                        <button class="menu-btn" onclick="toggleMenu(event, ${originalIndex})">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="menu-dropdown" id="menu-${originalIndex}">
                            <div class="menu-item" onclick="openEditModal(${originalIndex})">
                                <i class="fas fa-edit"></i> Edit Details
                            </div>
                            <div class="menu-item" onclick="openStatusModal(${originalIndex})">
                                <i class="fas fa-sync-alt"></i> Update Status
                            </div>
                            <div class="menu-item" onclick="openMaintenanceModal(${originalIndex})">
                                <i class="fas fa-history"></i> Maintenance Log
                            </div>
                            <div class="menu-item danger" onclick="openDeleteModal(${originalIndex})">
                                <i class="fas fa-trash"></i> Delete
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="equipment-details-row" id="details-${originalIndex}">
                <td colspan="7">
                    <div class="equipment-details-content">
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Equipment ID</span>
                                <span class="detail-value">${item.id}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Purchase Date</span>
                                <span class="detail-value ${!item.purchaseDate ? 'empty' : ''}">${item.purchaseDate ? formatDateDisplay(item.purchaseDate) : 'Not specified'}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Last Maintenance</span>
                                <span class="detail-value ${!item.lastMaintenance ? 'empty' : ''}">${item.lastMaintenance ? formatDateDisplay(item.lastMaintenance) : 'Never'}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Location</span>
                                <span class="detail-value">${item.location || 'Not specified'}</span>
                            </div>
                        </div>
                        ${item.notes ? `
                            <div class="equipment-notes">
                                <div class="detail-item">
                                    <span class="detail-label">Notes</span>
                                    <span class="detail-value">${item.notes}</span>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function updateStatistics() {
    const total = equipment.length;
    const excellent = equipment.filter(e => e.status === 'excellent').length;
    const needsAttention = equipment.filter(e => ['maintenance', 'repair'].includes(e.status)).length;
    const critical = equipment.filter(e => e.status === 'critical').length;

    document.getElementById('totalEquipment').textContent = total;
    document.getElementById('excellentCount').textContent = excellent;
    document.getElementById('needsAttentionCount').textContent = needsAttention;
    document.getElementById('criticalCount').textContent = critical;
}

// ======================
// UTILITY FUNCTIONS
// ======================

function formatDateDisplay(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function setTodayDate() {
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('#maintenanceDate');
    dateInputs.forEach(input => {
        if (!input.value) input.value = today;
    });
}

// ======================
// SEARCH & FILTER
// ======================

function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', (e) => {
        searchTerm = e.target.value;
        renderEquipment();
    });
}

function filterByStatus(status) {
    currentFilter = status;

    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');

    renderEquipment();
}

// ======================
// MODAL FUNCTIONS
// ======================

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';

    // Reset forms
    const form = modal.querySelector('form');
    if (form) form.reset();
}

// Close modal when clicking overlay
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
});

// ======================
// CRUD OPERATIONS
// ======================

// ADD EQUIPMENT
function openAddModal() {
    openModal('addModal');
}

function addEquipment(event) {
    event.preventDefault();

    const newEquipment = {
        id: document.getElementById('addEquipId').value.trim(),
        name: document.getElementById('addEquipName').value.trim(),
        category: document.getElementById('addEquipCategory').value,
        status: document.getElementById('addEquipStatus').value,
        location: document.getElementById('addEquipLocation').value.trim(),
        purchaseDate: document.getElementById('addEquipPurchaseDate').value,
        lastMaintenance: document.getElementById('addEquipLastMaintenance').value,
        notes: document.getElementById('addEquipNotes').value.trim(),
        maintenanceHistory: []
    };

    // Check for duplicate ID
    if (equipment.some(e => e.id === newEquipment.id)) {
        alert('Equipment ID already exists! Please use a unique ID.');
        return;
    }

    equipment.push(newEquipment);
    saveEquipment();
    renderEquipment();
    updateStatistics();
    closeModal('addModal');
}

// EDIT EQUIPMENT
function openEditModal(index) {
    const item = equipment[index];

    document.getElementById('editEquipIndex').value = index;
    document.getElementById('editEquipId').value = item.id;
    document.getElementById('editEquipName').value = item.name;
    document.getElementById('editEquipCategory').value = item.category;
    document.getElementById('editEquipStatus').value = item.status;
    document.getElementById('editEquipLocation').value = item.location || '';
    document.getElementById('editEquipPurchaseDate').value = item.purchaseDate || '';
    document.getElementById('editEquipLastMaintenance').value = item.lastMaintenance || '';
    document.getElementById('editEquipNotes').value = item.notes || '';

    closeDropdown();
    openModal('editModal');
}

function saveEditEquipment(event) {
    event.preventDefault();

    const index = parseInt(document.getElementById('editEquipIndex').value);
    const newId = document.getElementById('editEquipId').value.trim();

    // Check for duplicate ID (excluding current item)
    if (equipment.some((e, i) => e.id === newId && i !== index)) {
        alert('Equipment ID already exists! Please use a unique ID.');
        return;
    }

    equipment[index] = {
        ...equipment[index],
        id: newId,
        name: document.getElementById('editEquipName').value.trim(),
        category: document.getElementById('editEquipCategory').value,
        status: document.getElementById('editEquipStatus').value,
        location: document.getElementById('editEquipLocation').value.trim(),
        purchaseDate: document.getElementById('editEquipPurchaseDate').value,
        lastMaintenance: document.getElementById('editEquipLastMaintenance').value,
        notes: document.getElementById('editEquipNotes').value.trim()
    };

    saveEquipment();
    renderEquipment();
    updateStatistics();
    closeModal('editModal');
}

// UPDATE STATUS
function openStatusModal(index) {
    const item = equipment[index];

    document.getElementById('statusEquipIndex').value = index;
    document.getElementById('statusEquipName').textContent = item.name;
    document.getElementById('statusNewStatus').value = item.status;
    document.getElementById('statusNotes').value = '';

    closeDropdown();
    openModal('statusModal');
}

function saveStatusUpdate(event) {
    event.preventDefault();

    const index = parseInt(document.getElementById('statusEquipIndex').value);
    const newStatus = document.getElementById('statusNewStatus').value;
    const notes = document.getElementById('statusNotes').value.trim();

    equipment[index].status = newStatus;

    // Add to maintenance history if notes provided
    if (notes) {
        if (!equipment[index].maintenanceHistory) {
            equipment[index].maintenanceHistory = [];
        }
        equipment[index].maintenanceHistory.unshift({
            date: new Date().toISOString().split('T')[0],
            type: 'status_change',
            description: `Status updated to ${STATUS_TYPES[newStatus].label}. ${notes}`,
            performedBy: 'Staff Member'
        });
    }

    saveEquipment();
    renderEquipment();
    updateStatistics();
    closeModal('statusModal');
}

// MAINTENANCE HISTORY
function openMaintenanceModal(index) {
    const item = equipment[index];

    document.getElementById('maintenanceEquipIndex').value = index;
    document.getElementById('maintenanceEquipName').textContent = item.name;

    renderMaintenanceHistory(item.maintenanceHistory || []);

    closeDropdown();
    openModal('maintenanceModal');
}

function renderMaintenanceHistory(history) {
    const container = document.getElementById('maintenanceHistory');

    if (history.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <h3>No maintenance records</h3>
                <p>Add a maintenance record using the form below</p>
            </div>
        `;
        return;
    }

    container.innerHTML = history.map(record => `
        <div class="history-item">
            <div class="history-header">
                <span class="history-date">${formatDateDisplay(record.date)}</span>
                <span class="history-type">${record.type}</span>
            </div>
            <div class="history-notes">${record.description}</div>
            <div class="history-performer">By: ${record.performedBy}</div>
        </div>
    `).join('');
}

function addMaintenanceRecord(event) {
    event.preventDefault();

    const index = parseInt(document.getElementById('maintenanceEquipIndex').value);
    const record = {
        date: document.getElementById('maintenanceDate').value,
        type: document.getElementById('maintenanceType').value,
        description: document.getElementById('maintenanceDescription').value.trim(),
        performedBy: document.getElementById('maintenancePerformer').value.trim()
    };

    if (!equipment[index].maintenanceHistory) {
        equipment[index].maintenanceHistory = [];
    }

    equipment[index].maintenanceHistory.unshift(record);
    equipment[index].lastMaintenance = record.date;

    saveEquipment();
    renderEquipment();
    renderMaintenanceHistory(equipment[index].maintenanceHistory);

    // Reset form
    document.getElementById('addMaintenanceForm').reset();
    setTodayDate();
}

// DELETE EQUIPMENT
function openDeleteModal(index) {
    const item = equipment[index];

    document.getElementById('deleteEquipIndex').value = index;
    document.getElementById('deleteEquipName').textContent = item.name;

    closeDropdown();
    openModal('deleteModal');
}

function confirmDelete() {
    const index = parseInt(document.getElementById('deleteEquipIndex').value);

    equipment.splice(index, 1);
    saveEquipment();
    renderEquipment();
    updateStatistics();
    closeModal('deleteModal');
}

// ======================
// DROPDOWN MENU
// ======================

function toggleMenu(event, index) {
    event.stopPropagation();

    const dropdown = document.getElementById(`menu-${index}`);

    // Close other dropdowns
    if (activeDropdown && activeDropdown !== dropdown) {
        activeDropdown.classList.remove('active');
    }

    dropdown.classList.toggle('active');
    activeDropdown = dropdown.classList.contains('active') ? dropdown : null;
}

function closeDropdown() {
    if (activeDropdown) {
        activeDropdown.classList.remove('active');
        activeDropdown = null;
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.actions-menu')) {
        closeDropdown();
    }
});

// ======================
// EXPANDABLE ROW DETAILS
// ======================

function toggleRowDetails(index) {
    const mainRow = document.getElementById(`row-${index}`);
    const detailsRow = document.getElementById(`details-${index}`);

    // Toggle classes for animation
    mainRow.classList.toggle('expanded');
    detailsRow.classList.toggle('expanded');
}
