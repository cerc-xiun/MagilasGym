// ===== INVENTORY MANAGEMENT JS =====
const ITEMS_PER_PAGE = 8;
let currentTab = 'equipment';
let currentExpenseType = 'products';
let equipPage = 1;

// Demo Data
let equipmentData = [
    { id: 1, name: 'Treadmill #1', category: 'Cardio', location: 'Cardio Zone', status: 'operational' },
    { id: 2, name: 'Treadmill #2', category: 'Cardio', location: 'Cardio Zone', status: 'maintenance' },
    { id: 3, name: 'Treadmill #3', category: 'Cardio', location: 'Cardio Zone', status: 'operational' },
    { id: 4, name: 'Bench Press', category: 'Strength', location: 'Free Weights', status: 'operational' },
    { id: 5, name: 'Incline Bench', category: 'Strength', location: 'Free Weights', status: 'operational' },
    { id: 6, name: 'Cable Machine', category: 'Machines', location: 'Machine Area', status: 'maintenance' },
    { id: 7, name: 'Leg Press', category: 'Machines', location: 'Machine Area', status: 'operational' },
    { id: 8, name: 'Rowing Machine', category: 'Cardio', location: 'Cardio Zone', status: 'operational' },
    { id: 9, name: 'Squat Rack', category: 'Strength', location: 'Free Weights', status: 'operational' },
    { id: 10, name: 'Dumbbell Set', category: 'Free Weights', location: 'Free Weights', status: 'missing' },
    { id: 11, name: 'Smith Machine', category: 'Machines', location: 'Machine Area', status: 'operational' },
    { id: 12, name: 'Lat Pulldown', category: 'Machines', location: 'Machine Area', status: 'operational' }
];

let stockData = [
    { id: 1, name: 'Whey Protein 2kg', type: 'Supplements', price: 2500, qty: 15 },
    { id: 2, name: 'BCAA Powder', type: 'Supplements', price: 1200, qty: 20 },
    { id: 3, name: 'Energy Drink', type: 'Drinks', price: 85, qty: 48 },
    { id: 4, name: 'Protein Bar', type: 'Snacks', price: 120, qty: 36 },
    { id: 5, name: 'Gym Gloves', type: 'Accessories', price: 450, qty: 12 },
    { id: 6, name: 'Shaker Bottle', type: 'Accessories', price: 350, qty: 25 },
    { id: 7, name: 'Gym Towel', type: 'Apparel', price: 250, qty: 30 }
];

let expenseProducts = [
    { id: 1, name: 'Protein Bars Restock', category: 'Restock', price: 80, qty: 50, updated: new Date('2026-01-19T08:00:00') },
    { id: 2, name: 'Cleaning Supplies', category: 'Supplies', price: 150, qty: 5, updated: new Date('2026-01-19T06:30:00') },
    { id: 3, name: 'Energy Drinks', category: 'Restock', price: 60, qty: 48, updated: new Date('2026-01-18T14:00:00') }
];

let expenseBills = [
    { id: 1, name: 'January Electricity', amount: 4500, datetime: new Date('2026-01-18T10:00:00') },
    { id: 2, name: 'January Water', amount: 1200, datetime: new Date('2026-01-18T10:05:00') },
    { id: 3, name: 'Internet Bill', amount: 1899, datetime: new Date('2026-01-15T09:00:00') }
];

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    setupTabs();
    setupExpenseTypeTabs();
    setupModals();
    setupForms();
    setupFilters();
    renderAll();
    document.getElementById('menuBtn').addEventListener('click', () => document.getElementById('sidebar').classList.toggle('open'));
});

function setupTabs() {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            currentTab = btn.dataset.tab;
            document.getElementById(`${currentTab}-tab`).classList.add('active');
            updateAddButton();
        });
    });
}

function setupExpenseTypeTabs() {
    document.querySelectorAll('.expense-type-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.expense-type-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentExpenseType = btn.dataset.type;
            document.getElementById('expenseProductTable').style.display = currentExpenseType === 'products' ? '' : 'none';
            document.getElementById('expenseBillTable').style.display = currentExpenseType === 'bills' ? '' : 'none';
        });
    });
}

function updateAddButton() {
    const text = { equipment: 'Add Equipment', stock: 'Add Product', expenses: 'Add Expense' };
    document.getElementById('addBtnText').textContent = text[currentTab];
}

function setupModals() {
    document.getElementById('addNewBtn').addEventListener('click', () => {
        if (currentTab === 'equipment') { resetForm('equipmentForm'); document.getElementById('equipModalTitle').textContent = 'Add Equipment'; openModal('equipmentModal'); }
        else if (currentTab === 'stock') { resetForm('stockForm'); document.getElementById('stockModalTitle').textContent = 'Add Product'; openModal('stockModal'); }
        else {
            resetForm('expenseForm');
            document.getElementById('expenseModalTitle').textContent = 'Add Expense';
            document.getElementById('expenseType').value = currentExpenseType === 'products' ? 'product' : 'bill';
            document.getElementById('productExpenseFields').style.display = currentExpenseType === 'products' ? '' : 'none';
            document.getElementById('billExpenseFields').style.display = currentExpenseType === 'bills' ? '' : 'none';
            openModal('expenseModal');
        }
    });
    document.querySelectorAll('.modal-backdrop').forEach(m => m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); }));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') document.querySelectorAll('.modal-backdrop.show').forEach(m => closeModal(m.id)); });
}

function setupForms() {
    document.getElementById('equipmentForm').addEventListener('submit', e => {
        e.preventDefault();
        const id = document.getElementById('equipEditId').value;
        const data = { name: document.getElementById('equipName').value, category: document.getElementById('equipCategory').value, location: document.getElementById('equipLocation').value || 'Main Floor', status: document.getElementById('equipStatus').value };
        if (id) { const item = equipmentData.find(x => x.id == id); Object.assign(item, data); }
        else { equipmentData.unshift({ id: Date.now(), ...data }); }
        closeModal('equipmentModal'); renderEquipment();
    });

    document.getElementById('stockForm').addEventListener('submit', e => {
        e.preventDefault();
        const id = document.getElementById('stockEditId').value;
        const data = { name: document.getElementById('stockName').value, type: document.getElementById('stockType').value, price: parseFloat(document.getElementById('stockPrice').value), qty: parseInt(document.getElementById('stockQty').value) };
        if (id) { const item = stockData.find(x => x.id == id); Object.assign(item, data); }
        else { stockData.unshift({ id: Date.now(), ...data }); }
        closeModal('stockModal'); renderStock();
    });

    document.getElementById('expenseForm').addEventListener('submit', e => {
        e.preventDefault();
        const id = document.getElementById('expenseEditId').value;
        const type = document.getElementById('expenseType').value;
        if (type === 'product') {
            const data = { name: document.getElementById('expenseName').value, category: document.getElementById('expenseCategory').value, price: parseFloat(document.getElementById('expensePrice').value), qty: parseInt(document.getElementById('expenseQty').value), updated: new Date() };
            if (id) { const item = expenseProducts.find(x => x.id == id); Object.assign(item, data); expenseProducts.sort((a, b) => b.updated - a.updated); }
            else { expenseProducts.unshift({ id: Date.now(), ...data }); }
        } else {
            const data = { name: document.getElementById('billName').value, amount: parseFloat(document.getElementById('billAmount').value), datetime: new Date() };
            if (id) { const item = expenseBills.find(x => x.id == id); Object.assign(item, data); expenseBills.sort((a, b) => b.datetime - a.datetime); }
            else { expenseBills.unshift({ id: Date.now(), ...data }); }
        }
        closeModal('expenseModal'); renderExpenses();
    });
}

function setupFilters() {
    ['equipSearch', 'equipCategoryFilter', 'equipStatusFilter'].forEach(id => document.getElementById(id).addEventListener('input', () => { equipPage = 1; renderEquipment(); }));
    ['stockSearch', 'stockTypeFilter'].forEach(id => document.getElementById(id).addEventListener('input', renderStock));
}

function renderAll() { renderEquipment(); renderStock(); renderExpenses(); }

function renderEquipment() {
    const search = document.getElementById('equipSearch').value.toLowerCase();
    const cat = document.getElementById('equipCategoryFilter').value;
    const status = document.getElementById('equipStatusFilter').value;
    let filtered = equipmentData.filter(e => (cat === 'all' || e.category === cat) && (status === 'all' || e.status === status) && e.name.toLowerCase().includes(search));
    const total = Math.ceil(filtered.length / ITEMS_PER_PAGE);
    const start = (equipPage - 1) * ITEMS_PER_PAGE;
    const paged = filtered.slice(start, start + ITEMS_PER_PAGE);

    document.getElementById('equipmentTableBody').innerHTML = paged.map(e => `
        <tr><td><strong>${e.name}</strong></td><td>${e.category}</td><td>${e.location}</td>
        <td><span class="status-pill ${e.status}">${e.status}</span></td>
        <td class="actions"><button class="btn-icon" onclick="editEquipment(${e.id})"><i class="fas fa-edit"></i></button><button class="btn-icon danger" onclick="deleteEquipment(${e.id})"><i class="fas fa-trash"></i></button></td></tr>
    `).join('') || '<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">No equipment found</td></tr>';

    let pag = `<button ${equipPage === 1 ? 'disabled' : ''} onclick="equipPage--;renderEquipment()"><i class="fas fa-chevron-left"></i></button>`;
    for (let i = 1; i <= total; i++) pag += `<button class="${i === equipPage ? 'active' : ''}" onclick="equipPage=${i};renderEquipment()">${i}</button>`;
    pag += `<button ${equipPage >= total ? 'disabled' : ''} onclick="equipPage++;renderEquipment()"><i class="fas fa-chevron-right"></i></button>`;
    document.getElementById('equipPagination').innerHTML = total > 1 ? pag : '';
}

function renderStock() {
    const search = document.getElementById('stockSearch').value.toLowerCase();
    const type = document.getElementById('stockTypeFilter').value;
    let filtered = stockData.filter(s => (type === 'all' || s.type === type) && s.name.toLowerCase().includes(search));
    const totalWorth = stockData.reduce((sum, s) => sum + s.price * s.qty, 0);
    document.getElementById('totalInventoryWorth').textContent = '₱' + totalWorth.toLocaleString();

    document.getElementById('stockTableBody').innerHTML = filtered.map(s => `
        <tr><td><strong>${s.name}</strong></td><td>${s.type}</td><td>₱${s.price.toLocaleString()}</td><td>${s.qty}</td>
        <td><strong>₱${(s.price * s.qty).toLocaleString()}</strong></td>
        <td class="actions"><button class="btn-icon" onclick="editStock(${s.id})"><i class="fas fa-edit"></i></button><button class="btn-icon danger" onclick="deleteStock(${s.id})"><i class="fas fa-trash"></i></button></td></tr>
    `).join('') || '<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">No products found</td></tr>';
}

function renderExpenses() {
    document.getElementById('expenseProductBody').innerHTML = expenseProducts.map(e => `
        <tr><td><strong>${e.name}</strong></td><td>${e.category}</td><td>₱${e.price.toLocaleString()}</td><td>${e.qty}</td>
        <td><strong>₱${(e.price * e.qty).toLocaleString()}</strong></td><td style="font-size:12px;color:var(--text-muted)">${formatDate(e.updated)}</td>
        <td class="actions"><button class="btn-icon" onclick="editExpenseProduct(${e.id})"><i class="fas fa-edit"></i></button><button class="btn-icon danger" onclick="deleteExpenseProduct(${e.id})"><i class="fas fa-trash"></i></button></td></tr>
    `).join('') || '<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">No expenses</td></tr>';

    document.getElementById('expenseBillBody').innerHTML = expenseBills.map(b => `
        <tr><td><strong>${b.name}</strong></td><td><strong>₱${b.amount.toLocaleString()}</strong></td><td style="font-size:12px;color:var(--text-muted)">${formatDate(b.datetime)}</td>
        <td class="actions"><button class="btn-icon" onclick="editBill(${b.id})"><i class="fas fa-edit"></i></button><button class="btn-icon danger" onclick="deleteBill(${b.id})"><i class="fas fa-trash"></i></button></td></tr>
    `).join('') || '<tr><td colspan="4" style="text-align:center;padding:40px;color:var(--text-muted);">No bills</td></tr>';
}

function formatDate(d) { return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' + d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }); }

// CRUD Functions
function editEquipment(id) { const e = equipmentData.find(x => x.id === id); document.getElementById('equipEditId').value = id; document.getElementById('equipName').value = e.name; document.getElementById('equipCategory').value = e.category; document.getElementById('equipLocation').value = e.location; document.getElementById('equipStatus').value = e.status; document.getElementById('equipModalTitle').textContent = 'Edit Equipment'; openModal('equipmentModal'); }
function deleteEquipment(id) { if (confirm('Delete this equipment?')) { equipmentData = equipmentData.filter(x => x.id !== id); renderEquipment(); } }
function editStock(id) { const s = stockData.find(x => x.id === id); document.getElementById('stockEditId').value = id; document.getElementById('stockName').value = s.name; document.getElementById('stockType').value = s.type; document.getElementById('stockPrice').value = s.price; document.getElementById('stockQty').value = s.qty; document.getElementById('stockModalTitle').textContent = 'Edit Product'; openModal('stockModal'); }
function deleteStock(id) { if (confirm('Delete this product?')) { stockData = stockData.filter(x => x.id !== id); renderStock(); } }
function editExpenseProduct(id) { const e = expenseProducts.find(x => x.id === id); document.getElementById('expenseEditId').value = id; document.getElementById('expenseType').value = 'product'; document.getElementById('expenseName').value = e.name; document.getElementById('expenseCategory').value = e.category; document.getElementById('expensePrice').value = e.price; document.getElementById('expenseQty').value = e.qty; document.getElementById('productExpenseFields').style.display = ''; document.getElementById('billExpenseFields').style.display = 'none'; document.getElementById('expenseModalTitle').textContent = 'Edit Expense'; openModal('expenseModal'); }
function deleteExpenseProduct(id) { if (confirm('Delete?')) { expenseProducts = expenseProducts.filter(x => x.id !== id); renderExpenses(); } }
function editBill(id) { const b = expenseBills.find(x => x.id === id); document.getElementById('expenseEditId').value = id; document.getElementById('expenseType').value = 'bill'; document.getElementById('billName').value = b.name; document.getElementById('billAmount').value = b.amount; document.getElementById('productExpenseFields').style.display = 'none'; document.getElementById('billExpenseFields').style.display = ''; document.getElementById('expenseModalTitle').textContent = 'Edit Bill'; openModal('expenseModal'); }
function deleteBill(id) { if (confirm('Delete?')) { expenseBills = expenseBills.filter(x => x.id !== id); renderExpenses(); } }

// Modal helpers
function openModal(id) { document.getElementById(id).classList.add('show'); document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); document.body.style.overflow = ''; }
function resetForm(id) { document.getElementById(id).reset(); document.querySelectorAll(`#${id} input[type="hidden"]`).forEach(i => i.value = ''); }
