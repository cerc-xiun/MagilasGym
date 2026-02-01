// ===========================
// INVENTORY MANAGEMENT SYSTEM
// ===========================

// Data Storage
let inventoryItems = [];
let categories = ['Supplements', 'Merchandise', 'Cleaning Supplies', 'Office Supplies'];
let currentFilter = 'all';
let itemToDelete = null;

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadData();
    renderInventory();
    updateDateDisplay();
    populateCategorySelects();
    renderCategoryFilter();
});

// ============
// DATA MANAGEMENT
// ============

function loadData() {
    // Load from localStorage
    const savedItems = localStorage.getItem('inventoryItems');
    const savedCategories = localStorage.getItem('inventory Categories');

    if (savedItems) {
        inventoryItems = JSON.parse(savedItems);
    }

    if (savedCategories) {
        categories = JSON.parse(savedCategories);
    }
}

function saveData() {
    localStorage.setItem('inventoryItems', JSON.stringify(inventoryItems));
    localStorage.setItem('inventoryCategories', JSON.stringify(categories));
}

// ============
// DISPLAY FUNCTIONS
// ============

function updateDateDisplay() {
    const dateElement = document.getElementById('dateDisplay');
    if (dateElement) {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateElement.textContent = now.toLocaleDateString('en-US', options);
    }
}

function renderInventory() {
    const tbody = document.getElementById('inventoryTableBody');
    const emptyState = document.getElementById('emptyState');
    const searchTerm = document.getElementById('inventorySearch').value.toLowerCase();

    // Filter items
    let filteredItems = inventoryItems;

    // Apply category filter
    if (currentFilter !== 'all') {
        filteredItems = filteredItems.filter(item => item.category === currentFilter);
    }

    // Apply search filter
    if (searchTerm) {
        filteredItems = filteredItems.filter(item =>
            item.name.toLowerCase().includes(searchTerm) ||
            item.category.toLowerCase().includes(searchTerm)
        );
    }

    // Show/hide empty state
    if (filteredItems.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.add('show');
        return;
    }

    emptyState.classList.remove('show');

    // Render items
    tbody.innerHTML = filteredItems.map(item => `
        <tr>
            <td>${escapeHtml(item.name)}</td>
            <td><span class="category-badge">${escapeHtml(item.category)}</span></td>
            <td class="quantity">${item.quantity}</td>
            <td class="price">${formatCurrency(item.price)}</td>
            <td class="total-value">${formatCurrency(item.totalValue)}</td>
            <td class="actions-col">
                <div class="actions-menu">
                    <button class="menu-trigger" onclick="toggleMenu(event, '${item.id}')">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="menu-dropdown" id="menu-${item.id}">
                        <div class="menu-item" onclick="openEditModal('${item.id}')">
                            <i class="fas fa-edit"></i> Edit
                        </div>
                        <div class="menu-item delete" onclick="openDeleteModal('${item.id}')">
                            <i class="fas fa-trash"></i> Delete
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    `).join('');
}

function populateCategorySelects() {
    const select = document.getElementById('itemCategory');
    if (select) {
        // Keep the placeholder option
        const options = categories.map(cat =>
            `<option value="${escapeHtml(cat)}">${escapeHtml(cat)}</option>`
        ).join('');
        select.innerHTML = '<option value="">Select category</option>' + options;
    }
}

function renderCategoryFilter() {
    const filterDropdown = document.getElementById('filterDropdown');
    const categoriesHtml = categories.map(cat => `
        <div class="filter-option" onclick="selectFilter('${escapeHtml(cat)}')">
            <i class="fas fa-tag"></i> ${escapeHtml(cat)}
        </div>
    `).join('');

    // Keep the "All Items" option at the top
    const allOption = filterDropdown.querySelector('.filter-option');
    filterDropdown.innerHTML = '';
    filterDropdown.appendChild(allOption);
    filterDropdown.innerHTML += categoriesHtml;
}

// ============
// FILTER FUNCTIONS
// ============

function filterInventory() {
    renderInventory();
}

function toggleFilterDropdown() {
    const dropdown = document.getElementById('filterDropdown');
    const btn = document.querySelector('.btn-filter');
    dropdown.classList.toggle('show');
    btn.classList.toggle('active');
}

function selectFilter(category) {
    currentFilter = category;

    // Update active state
    document.querySelectorAll('.filter-option').forEach(opt => {
        opt.classList.remove('active');
    });
    event.target.closest('.filter-option').classList.add('active');

    // Close dropdown
    toggleFilterDropdown();

    // Re-render
    renderInventory();
}

// Close dropdowns when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.btn-filter') && !e.target.closest('.filter-dropdown')) {
        const dropdown = document.getElementById('filterDropdown');
        const btn = document.querySelector('.btn-filter');
        if (dropdown && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
            btn.classList.remove('active');
        }
    }

    // Close all 3-dot menus
    if (!e.target.closest('.actions-menu')) {
        document.querySelectorAll('.menu-dropdown.show').forEach(menu => {
            menu.classList.remove('show');
        });
    }
});

function toggleMenu(event, itemId) {
    event.stopPropagation();
    const menu = document.getElementById(`menu-${itemId}`);

    // Close other menus
    document.querySelectorAll('.menu-dropdown.show').forEach(m => {
        if (m !== menu) m.classList.remove('show');
    });

    menu.classList.toggle('show');
}

// ============
// MODAL FUNCTIONS
// ============

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New Item';
    document.getElementById('itemForm').reset();
    document.getElementById('editItemId').value = '';
    document.getElementById('totalValue').textContent = '0.00';
    document.getElementById('nameError').textContent = '';
    document.getElementById('itemModal').classList.add('show');
}

function openEditModal(itemId) {
    const item = inventoryItems.find(i => i.id === itemId);
    if (!item) return;

    document.getElementById('modalTitle').textContent = 'Edit Item';
    document.getElementById('itemName').value = item.name;
    document.getElementById('itemCategory').value = item.category;
    document.getElementById('itemQuantity').value = item.quantity;
    document.getElementById('itemPrice').value = item.price;
    document.getElementById('editItemId').value = item.id;
    calculateTotal();
    document.getElementById('nameError').textContent = '';
    document.getElementById('itemModal').classList.add('show');
}

function closeItemModal() {
    document.getElementById('itemModal').classList.remove('show');
}

function openCategorySettings() {
    renderCategoryList();
    document.getElementById('categoryModal').classList.add('show');
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.remove('show');
}

function openDeleteModal(itemId) {
    const item = inventoryItems.find(i => i.id === itemId);
    if (!item) return;

    itemToDelete = itemId;
    document.getElementById('deleteItemName').textContent = item.name;
    document.getElementById('deleteModal').classList.add('show');
}

function closeDeleteModal() {
    itemToDelete = null;
    document.getElementById('deleteModal').classList.remove('show');
}

// ============
// CRUD OPERATIONS
// ============

function saveItem(event) {
    event.preventDefault();

    const name = document.getElementById('itemName').value.trim();
    const category = document.getElementById('itemCategory').value;
    const quantity = parseInt(document.getElementById('itemQuantity').value);
    const price = parseFloat(document.getElementById('itemPrice').value);
    const editId = document.getElementById('editItemId').value;

    // Validate
    if (!name || !category || isNaN(quantity) || isNaN(price)) {
        return;
    }

    // Check for duplicate name (excluding current item when editing)
    const isDuplicate = inventoryItems.some(item =>
        item.name.toLowerCase() === name.toLowerCase() && item.id !== editId
    );

    if (isDuplicate) {
        document.getElementById('nameError').textContent = 'An item with this name already exists';
        return;
    }

    const totalValue = quantity * price;
    const now = new Date().toISOString();

    if (editId) {
        // Update existing item
        const index = inventoryItems.findIndex(i => i.id === editId);
        if (index !== -1) {
            inventoryItems[index] = {
                ...inventoryItems[index],
                name,
                category,
                quantity,
                price,
                totalValue,
                lastModified: now
            };
        }
    } else {
        // Add new item
        const newItem = {
            id: Date.now().toString(),
            name,
            category,
            quantity,
            price,
            totalValue,
            dateAdded: now,
            lastModified: now
        };
        inventoryItems.push(newItem);
    }

    saveData();
    renderInventory();
    closeItemModal();
}

function confirmDelete() {
    if (!itemToDelete) return;

    inventoryItems = inventoryItems.filter(i => i.id !== itemToDelete);
    saveData();
    renderInventory();
    closeDeleteModal();
}

function calculateTotal() {
    const quantity = parseFloat(document.getElementById('itemQuantity').value) || 0;
    const price = parseFloat(document.getElementById('itemPrice').value) || 0;
    const total = quantity * price;
    document.getElementById('totalValue').textContent = total.toFixed(2);
}

// ============
// CATEGORY MANAGEMENT
// ============

function renderCategoryList() {
    const listContainer = document.getElementById('categoryList');
    listContainer.innerHTML = categories.map(cat => `
        <div class="category-item">
            <span class="category-name">${escapeHtml(cat)}</span>
            <button class="category-remove" onclick="removeCategory('${escapeHtml(cat)}')" title="Remove category">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');
}

function addCategory() {
    const input = document.getElementById('newCategory');
    const categoryName = input.value.trim();

    if (!categoryName) return;

    // Check for duplicates
    if (categories.some(cat => cat.toLowerCase() === categoryName.toLowerCase())) {
        alert('This category already exists');
        return;
    }

    categories.push(categoryName);
    saveData();
    populateCategorySelects();
    renderCategoryFilter();
    renderCategoryList();
    input.value = '';
}

function removeCategory(categoryName) {
    // Check if any items use this category
    const hasItems = inventoryItems.some(item => item.category === categoryName);

    if (hasItems) {
        alert(`Cannot remove "${categoryName}" because some items are using this category`);
        return;
    }

    categories = categories.filter(cat => cat !== categoryName);
    saveData();
    populateCategorySelects();
    renderCategoryFilter();
    renderCategoryList();
}

// ============
// UTILITY FUNCTIONS
// ============

function formatCurrency(amount) {
    return '₱' + parseFloat(amount).toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.toString().replace(/[&<>"']/g, m => map[m]);
}
