// ===========================
// INVENTORY MANAGEMENT SYSTEM (ENHANCED)
// Multi-Tab System with Expenses, Restocking, Sales
// ===========================

// Data Storage
let inventoryItems = []; // All items (shop + supply)
let shopCategories = ['Supplements', 'Merchandise', 'Apparel', 'Accessories'];
let supplyCategories = ['Cleaning Supplies', 'Office Supplies', 'Equipment Parts', 'Maintenance'];
let expenses = [];
let restockLogs = [];
let salesHistory = [];
let currentFilter = 'all';
let itemToDelete = null;
let currentTab = 'shop-products';

// Low Stock Threshold
const LOW_STOCK_THRESHOLD = 10;
const CRITICAL_STOCK_THRESHOLD = 5;

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadData();
    renderShopProducts(); // Default tab
    updateDateDisplay();
    populateCategorySelects();
    renderCategoryFilter();
    renderExpenses();
    renderRestocking();
    renderSales();

    // Check if we need to auto-open Shop POS
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('openShop') === 'true') {
        setTimeout(() => {
            openShopInterface();
            // Remove the parameter from URL
            history.replaceState(null, '', window.location.pathname);
        }, 500);
    }
});

// ============
// TOAST NOTIFICATION SYSTEM
// ============

function showToast(message, type = 'info', title = '') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;

    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };

    const titles = {
        success: title || 'Success',
        error: title || 'Error',
        warning: title || 'Warning',
        info: title || 'Info'
    };

    toast.innerHTML = `
        <div class="toast-icon">
            <i class="fas ${icons[type] || icons.info}"></i>
        </div>
        <div class="toast-content">
            <div class="toast-title">${titles[type]}</div>
            <div class="toast-message">${escapeHtml(message)}</div>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(toast);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('removing');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// ============
// DATA MANAGEMENT
// ============

function loadData() {
    const savedItems = localStorage.getItem('inventoryItems');
    const savedShopCats = localStorage.getItem('shopCategories');
    const savedSupplyCats = localStorage.getItem('supplyCategories');
    const savedExpenses = localStorage.getItem('gymExpenses');
    const savedRestocking = localStorage.getItem('restockingLogs');
    const savedSales = localStorage.getItem('salesHistory');

    if (savedItems) inventoryItems = JSON.parse(savedItems);
    if (savedShopCats) shopCategories = JSON.parse(savedShopCats);
    if (savedSupplyCats) supplyCategories = JSON.parse(savedSupplyCats);
    if (savedExpenses) expenses = JSON.parse(savedExpenses);
    if (savedRestocking) restockLogs = JSON.parse(savedRestocking);
    if (savedSales) salesHistory = JSON.parse(savedSales);
}

function saveData() {
    localStorage.setItem('inventoryItems', JSON.stringify(inventoryItems));
    localStorage.setItem('shopCategories', JSON.stringify(shopCategories));
    localStorage.setItem('supplyCategories', JSON.stringify(supplyCategories));
    localStorage.setItem('gymExpenses', JSON.stringify(expenses));
    localStorage.setItem('restockingLogs', JSON.stringify(restockLogs));
    localStorage.setItem('salesHistory', JSON.stringify(salesHistory));
}

// ============
// SHOP INTERFACE (Phase 2)
// ============

function updateDateDisplay() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('dateDisplay').textContent = now.toLocaleDateString('en-US', options);
}

// ============
// SHOP POS FUNCTIONS
// ============

let currentCart = [];
let selectedPaymentMethod = 'cash';
let receiptCounter = 1;

function openShopInterface() {
    document.getElementById('shopModal').classList.add('show');
    renderShopPOS();
    clearCart();
}

function closeShopInterface() {
    document.getElementById('shopModal').classList.remove('show');
    clearCart();
}

function renderShopPOS() {
    const grid = document.getElementById('posProductsGrid');
    const emptyState = document.getElementById('posEmptyState');
    const searchTerm = document.getElementById('posProductSearch').value.toLowerCase();

    // Get visible shop products only
    let products = inventoryItems.filter(item =>
        item.type === 'shop' && item.isVisible !== false
    );

    if (searchTerm) {
        products = products.filter(item =>
            item.name.toLowerCase().includes(searchTerm) ||
            item.category.toLowerCase().includes(searchTerm)
        );
    }

    // Update count
    document.querySelector('#posProductCount span').textContent =
        `${products.length} product${products.length !== 1 ? 's' : ''}`;

    if (products.length === 0) {
        grid.innerHTML = '';
        emptyState.classList.add('show');
        return;
    }

    emptyState.classList.remove('show');

    grid.innerHTML = products.map(product => {
        const isOutOfStock = product.quantity <= 0;
        const isLowStock = product.quantity <= LOW_STOCK_THRESHOLD && product.quantity > CRITICAL_STOCK_THRESHOLD;
        const isCritical = product.quantity <= CRITICAL_STOCK_THRESHOLD && product.quantity > 0;

        let stockBadge = '';
        if (isCritical) {
            stockBadge = '<span class="stock-badge-pos critical">Low!</span>';
        } else if (isLowStock) {
            stockBadge = '<span class="stock-badge-pos low">Low</span>';
        }

        return `
            <div class="product-card ${isOutOfStock ? 'out-of-stock' : ''}" 
                 onclick="${isOutOfStock ? '' : `addToCart('${product.id}')`}">
                ${stockBadge}
                <div class="product-image">
                    <i class="fas fa-box"></i>
                </div>
                <div class="product-info">
                    <h4>${escapeHtml(product.name)}</h4>
                    <div class="product-price">${formatCurrency(product.price)}</div>
                    <div class="product-stock ${isCritical ? 'critical' : isLowStock ? 'low' : ''}">
                        <i class="fas fa-cubes"></i>
                        ${product.quantity} ${isOutOfStock ? '(Out of Stock)' : 'in stock'}
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

function filterShopPOS() {
    renderShopPOS();
}

function addToCart(productId) {
    const product = inventoryItems.find(p => p.id === productId);
    if (!product || product.quantity <= 0) return;

    const existingItem = currentCart.find(item => item.productId === productId);

    if (existingItem) {
        if (existingItem.quantity < product.quantity) {
            existingItem.quantity++;
            existingItem.subtotal = existingItem.quantity * existingItem.price;
        } else {
            showToast(`Only ${product.quantity} units available in stock`, 'warning', 'Stock Limit');
            return;
        }
    } else {
        currentCart.push({
            productId: product.id,
            name: product.name,
            price: product.price,
            quantity: 1,
            subtotal: product.price
        });
    }

    updateCartDisplay();
}

function removeFromCart(productId) {
    currentCart = currentCart.filter(item => item.productId !== productId);
    updateCartDisplay();
}

function updateCartQuantity(productId, newQty) {
    const product = inventoryItems.find(p => p.id === productId);
    const cartItem = currentCart.find(item => item.productId === productId);

    if (!cartItem || !product) return;

    if (newQty <= 0) {
        removeFromCart(productId);
        return;
    }

    if (newQty > product.quantity) {
        showToast(`Only ${product.quantity} units available`, 'warning', 'Stock Limit');
        return;
    }

    cartItem.quantity = newQty;
    cartItem.subtotal = cartItem.quantity * cartItem.price;
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartItemsDiv = document.getElementById('cartItems');
    const checkoutBtn = document.getElementById('checkoutBtn');

    if (currentCart.length === 0) {
        cartItemsDiv.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-cart-plus"></i>
                <p>Add products to start</p>
            </div>
        `;
        checkoutBtn.disabled = true;
        calculateCartTotals();
        return;
    }

    checkoutBtn.disabled = false;

    cartItemsDiv.innerHTML = currentCart.map(item => `
        <div class="cart-item">
            <div class="cart-item-header">
                <span class="cart-item-name">${escapeHtml(item.name)}</span>
                <button class="cart-item-remove" onclick="removeFromCart('${item.productId}')" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cart-item-footer">
                <div class="qty-controls">
                    <button class="qty-btn" onclick="updateCartQuantity('${item.productId}', ${item.quantity - 1})">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="qty-display">${item.quantity}</span>
                    <button class="qty-btn" onclick="updateCartQuantity('${item.productId}', ${item.quantity + 1})">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <span class="cart-item-price">${formatCurrency(item.subtotal)}</span>
            </div>
        </div>
    `).join('');

    calculateCartTotals();
}

function calculateCartTotals() {
    const subtotal = currentCart.reduce((sum, item) => sum + item.subtotal, 0);
    const tax = 0; // No tax for now
    const total = subtotal + tax;

    document.getElementById('cartSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('cartTax').textContent = formatCurrency(tax);
    document.getElementById('cartTotal').textContent = formatCurrency(total);
}

function clearCart() {
    currentCart = [];
    document.getElementById('customerName').value = '';
    selectedPaymentMethod = 'cash';
    document.querySelectorAll('.payment-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.method === 'cash');
    });
    updateCartDisplay();
}

function selectPaymentMethod(method) {
    selectedPaymentMethod = method;
    document.querySelectorAll('.payment-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.method === method);
    });
}

function processCheckout() {
    if (currentCart.length === 0) {
        showToast('Please add items to cart before checkout', 'warning', 'Empty Cart');
        return;
    }

    // Validate stock availability
    for (const cartItem of currentCart) {
        const product = inventoryItems.find(p => p.id === cartItem.productId);
        if (!product || product.quantity < cartItem.quantity) {
            showToast(`Insufficient stock for ${cartItem.name}`, 'error', 'Stock Unavailable');
            return;
        }
    }

    const customerName = document.getElementById('customerName').value.trim() || 'Walk-in Customer';
    const now = new Date();
    const subtotal = currentCart.reduce((sum, item) => sum + item.subtotal, 0);
    const tax = 0;
    const total = subtotal + tax;

    // Generate receipt number
    const receiptNumber = `MG-${now.getFullYear()}-${String(receiptCounter).padStart(4, '0')}`;
    receiptCounter++;

    // Create sale record (backend-ready structure)
    const saleRecord = {
        id: Date.now().toString(),
        receiptNumber,
        date: now.toISOString(),
        items: currentCart.map(item => ({
            productId: item.productId,
            productName: item.name,
            quantity: item.quantity,
            unitPrice: item.price,
            subtotal: item.subtotal
        })),
        subtotal,
        tax,
        total,
        paymentMethod: selectedPaymentMethod,
        customerName,
        staff: 'Current User', // TODO: Get from session
        status: 'completed'
    };

    // Update inventory quantities
    currentCart.forEach(cartItem => {
        const product = inventoryItems.find(p => p.id === cartItem.productId);
        if (product) {
            product.quantity -= cartItem.quantity;
            product.totalValue = product.quantity * product.price;
            product.lastModified = now.toISOString();
        }
    });

    // Save sale to history
    salesHistory.push(saleRecord);

    // Save all data
    saveData();

    // Render updated shop products
    renderShopProducts();
    renderShopPOS();

    // Show receipt
    generateReceipt(saleRecord);

    // Clear cart
    clearCart();
}

function generateReceipt(saleData) {
    const receiptContent = document.getElementById('receiptContent');
    const saleDate = new Date(saleData.date);

    receiptContent.innerHTML = `
        <div class="receipt-paper">
            <div class="receipt-header-content">
                <h1>MAGILAS GYM</h1>
                <p>Shop Receipt</p>
                <p>${saleDate.toLocaleString('en-US')}</p>
            </div>
            
            <div class="receipt-number">
                Receipt #: ${saleData.receiptNumber}
            </div>
            
            <div class="receipt-customer">
                <p><strong>Customer:</strong> ${escapeHtml(saleData.customerName)}</p>
                <p><strong>Payment:</strong> ${saleData.paymentMethod.toUpperCase()}</p>
            </div>
            
            <div class="receipt-items">
                ${saleData.items.map(item => `
                    <div class="receipt-item">
                        <span class="receipt-item-name">${escapeHtml(item.productName)}</span>
                        <span class="receipt-item-qty">x${item.quantity}</span>
                        <span>${formatCurrency(item.subtotal)}</span>
                    </div>
                `).join('')}
            </div>
            
            <div class="receipt-totals">
                <div class="receipt-total-row">
                    <span>Subtotal:</span>
                    <span>${formatCurrency(saleData.subtotal)}</span>
                </div>
                <div class="receipt-total-row">
                    <span>Tax:</span>
                    <span>${formatCurrency(saleData.tax)}</span>
                </div>
                <div class="receipt-total-row grand-total">
                    <span>TOTAL:</span>
                    <span>${formatCurrency(saleData.total)}</span>
                </div>
            </div>
            
            <div class="receipt-footer">
                <p>Thank you for your purchase!</p>
                <p>Stay strong!</p>
            </div>
        </div>
    `;

    document.getElementById('receiptModal').classList.add('show');
}

function printReceipt() {
    window.print();
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.remove('show');
}


// ============
// TAB SWITCHING
// ============

function switchTab(tabName) {
    currentTab = tabName;

    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.tab === tabName);
    });

    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById(`${tabName}-tab`).classList.add('active');

    // Render appropriate content
    switch (tabName) {
        case 'shop-products':
            renderShopProducts();
            break;
        case 'gym-inventory':
            renderGymInventory();
            break;
        case 'restocking':
            renderRestocking();
            break;
        case 'expenses':
            renderExpenses();
            break;
        case 'sales':
            renderSales();
            break;
    }
}

// ============
// UNIFIED ADD MODAL
// ============

function openUnifiedAddModal() {
    // Open unified modal for shop-products and gym-inventory tabs
    if (currentTab === 'shop-products' || currentTab === 'gym-inventory') {
        document.getElementById('unifiedAddModal').classList.add('show');
    } else if (currentTab === 'expenses') {
        openExpenseModal();
    } else if (currentTab === 'restocking') {
        openRestockModal();
    }
}

function closeUnifiedAddModal() {
    document.getElementById('unifiedAddModal').classList.remove('show');
}

function selectAddType(type) {
    closeUnifiedAddModal();
    if (type === 'shop-product') {
        openAddModal('shop');
    } else if (type === 'gym-supply') {
        openAddModal('supply');
    } else if (type === 'expense') {
        openExpenseModal();
    } else if (type === 'restock') {
        openRestockModal();
    }
}

// ============
// PRODUCTS TAB FUNCTIONS
// ============

// ============
// SHOP PRODUCTS TAB FUNCTIONS
// ============

function renderShopProducts() {
    const tbody = document.getElementById('shopProductsTableBody');
    const emptyState = document.getElementById('shopProductsEmptyState');
    const searchTerm = document.getElementById('shopProductsSearch').value.toLowerCase();

    // Filter for shop items only
    let filteredItems = inventoryItems.filter(item => item.type === 'shop');

    if (currentFilter !== 'all') {
        filteredItems = filteredItems.filter(item => item.category === currentFilter);
    }

    if (searchTerm) {
        filteredItems = filteredItems.filter(item =>
            item.name.toLowerCase().includes(searchTerm) ||
            item.category.toLowerCase().includes(searchTerm)
        );
    }

    if (filteredItems.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.add('show');
        return;
    }

    emptyState.classList.remove('show');

    tbody.innerHTML = filteredItems.map(item => {
        const stockAlert = getStockAlert(item.quantity);
        const isVisible = item.isVisible !== false; // Default to visible

        return `
            <tr>
                <td>${escapeHtml(item.name)} ${stockAlert}</td>
                <td><span class="category-badge">${escapeHtml(item.category)}</span></td>
                <td class="quantity">${item.quantity}</td>
                <td class="price">${formatCurrency(item.price)}</td>
                <td class="total-value">${formatCurrency(item.totalValue)}</td>
                <td style="text-align: center;">
                    <span class="shop-badge ${isVisible ? '' : 'inactive'}" onclick="toggleVisibility('${item.id}')">
                        <i class="fas fa-${isVisible ? 'check' : 'times'}"></i>
                    </span>
                </td>
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
        `;
    }).join('');
}

function filterShopProducts() {
    renderShopProducts();
}

// ============
// GYM INVENTORY TAB FUNCTIONS
// ============

function renderGymInventory() {
    const tbody = document.getElementById('gymInventoryTableBody');
    const emptyState = document.getElementById('gymInventoryEmptyState');
    const searchTerm = document.getElementById('gymInventorySearch').value.toLowerCase();

    // Filter for supply items only
    let filteredItems = inventoryItems.filter(item => item.type === 'supply');

    if (searchTerm) {
        filteredItems = filteredItems.filter(item =>
            item.name.toLowerCase().includes(searchTerm) ||
            item.category.toLowerCase().includes(searchTerm)
        );
    }

    if (filteredItems.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.add('show');
        return;
    }

    emptyState.classList.remove('show');

    tbody.innerHTML = filteredItems.map(item => {
        return `
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
        `;
    }).join('');
}

function filterGymInventory() {
    renderGymInventory();
}

function getStockAlert(quantity) {
    if (quantity <= CRITICAL_STOCK_THRESHOLD) {
        return '<span class="stock-badge critical"><i class="fas fa-exclamation-triangle"></i> Critical</span>';
    } else if (quantity <= LOW_STOCK_THRESHOLD) {
        return '<span class="stock-badge low"><i class="fas fa-exclamation-circle"></i> Low Stock</span>';
    }
    return '';
}

function toggleVisibility(itemId) {
    const item = inventoryItems.find(i => i.id === itemId);
    if (item && item.type === 'shop') {
        item.isVisible = !item.isVisible;
        saveData();
        renderShopProducts();
    }
}

function populateCategorySelects() {
    const select = document.getElementById('itemCategory');
    const typeSelect = document.getElementById('itemType');

    if (!select || !typeSelect) return;

    const itemType = typeSelect.value;
    const categories = itemType === 'shop' ? shopCategories : supplyCategories;

    const options = categories.map(cat =>
        `<option value="${escapeHtml(cat)}">${escapeHtml(cat)}</option>`
    ).join('');
    select.innerHTML = '<option value="">Select category</option>' + options;
}

// Listen for item type changes to update categories
document.addEventListener('DOMContentLoaded', () => {
    const typeSelect = document.getElementById('itemType');
    if (typeSelect) {
        typeSelect.addEventListener('change', populateCategorySelects);
    }
});

function renderCategoryFilter() {
    const filterDropdown = document.getElementById('filterDropdown');
    const allCategories = [...new Set([...shopCategories, ...supplyCategories])];
    const categoriesHtml = allCategories.map(cat => `
        <div class="filter-option" onclick="selectFilter('${escapeHtml(cat)}')">
            <i class="fas fa-tag"></i> ${escapeHtml(cat)}
        </div>
    `).join('');

    const allOption = filterDropdown.querySelector('.filter-option');
    filterDropdown.innerHTML = '';
    filterDropdown.appendChild(allOption);
    filterDropdown.innerHTML += categoriesHtml;
}

function toggleFilterDropdown() {
    const dropdown = document.getElementById('filterDropdown');
    const btn = document.querySelector('.btn-filter');
    dropdown.classList.toggle('show');
    btn.classList.toggle('active');
}

function selectFilter(category) {
    currentFilter = category;

    document.querySelectorAll('.filter-option').forEach(opt => {
        opt.classList.remove('active');
    });
    event.target.closest('.filter-option').classList.add('active');

    toggleFilterDropdown();

    // Render appropriate tab
    if (currentTab === 'shop-products') {
        renderShopProducts();
    }
}

// ============
// PRODUCT MODAL FUNCTIONS
// ============

function openAddModal(itemType = 'shop') {
    document.getElementById('modalTitle').textContent = 'Add New Item';
    document.getElementById('itemForm').reset();
    document.getElementById('editItemId').value = '';
    document.getElementById('totalValue').textContent = '0.00';
    document.getElementById('nameError').textContent = '';

    // Set item type
    document.getElementById('itemType').value = itemType;

    // Populate categories based on type
    populateCategorySelects();

    document.getElementById('itemModal').classList.add('show');
}

function openEditModal(itemId) {
    const item = inventoryItems.find(i => i.id === itemId);
    if (!item) return;

    document.getElementById('modalTitle').textContent = 'Edit Item';
    document.getElementById('itemName').value = item.name;
    document.getElementById('itemType').value = item.type || 'shop';

    // Populate categories first, then set category
    populateCategorySelects();
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

function saveItem(event) {
    event.preventDefault();

    const name = document.getElementById('itemName').value.trim();
    const itemType = document.getElementById('itemType').value;
    const category = document.getElementById('itemCategory').value;
    const quantity = parseInt(document.getElementById('itemQuantity').value);
    const price = parseFloat(document.getElementById('itemPrice').value);
    const editId = document.getElementById('editItemId').value;

    if (!name || !itemType || !category || isNaN(quantity) || isNaN(price)) {
        return;
    }

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
        const index = inventoryItems.findIndex(i => i.id === editId);
        if (index !== -1) {
            inventoryItems[index] = {
                ...inventoryItems[index],
                name,
                type: itemType,
                category,
                quantity,
                price,
                totalValue,
                lastModified: now
            };
        }
    } else {
        const newItem = {
            id: Date.now().toString(),
            name,
            type: itemType,
            category,
            quantity,
            price,
            totalValue,
            isVisible: true, // Default shop products to visible
            dateAdded: now,
            lastModified: now
        };
        inventoryItems.push(newItem);
    }

    saveData();

    // Render appropriate tab
    if (itemType === 'shop') {
        renderShopProducts();
    } else {
        renderGymInventory();
    }

    populateRestockProductSelect();
    closeItemModal();
}

function calculateTotal() {
    const quantity = parseFloat(document.getElementById('itemQuantity').value) || 0;
    const price = parseFloat(document.getElementById('itemPrice').value) || 0;
    const total = quantity * price;
    document.getElementById('totalValue').textContent = total.toFixed(2);
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

function confirmDelete() {
    if (!itemToDelete) return;

    const item = inventoryItems.find(i => i.id === itemToDelete);
    const itemType = item?.type;

    inventoryItems = inventoryItems.filter(i => i.id !== itemToDelete);
    saveData();

    //  Render appropriate tab
    if (itemType === 'shop') {
        renderShopProducts();
    } else if (itemType === 'supply') {
        renderGymInventory();
    }

    closeDeleteModal();
}

// ============
// EXPENSES TAB FUNCTIONS
// ============

function renderExpenses() {
    const tbody = document.getElementById('expensesTableBody');
    const emptyState = document.getElementById('expensesEmptyState');
    const searchTerm = document.getElementById('expensesSearch').value.toLowerCase();

    let filtered = expenses;
    if (searchTerm) {
        filtered = filtered.filter(exp =>
            exp.category.toLowerCase().includes(searchTerm) ||
            exp.description.toLowerCase().includes(searchTerm) ||
            exp.vendor.toLowerCase().includes(searchTerm)
        );
    }

    if (filtered.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.add('show');
        return;
    }

    emptyState.classList.remove('show');

    tbody.innerHTML = filtered.map(exp => `
        <tr>
            <td>${formatDate(exp.date)}</td>
            <td><span class="category-badge">${escapeHtml(exp.category)}</span></td>
            <td>${escapeHtml(exp.description)}</td>
            <td>${escapeHtml(exp.vendor || '--')}</td>
            <td class="price">${formatCurrency(exp.amount)}</td>
            <td class="actions-col">
                <div class="actions-menu">
                    <button class="menu-trigger" onclick="toggleMenu(event, 'exp-${exp.id}')">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="menu-dropdown" id="menu-exp-${exp.id}">
                        <div class="menu-item" onclick="openEditExpenseModal('${exp.id}')">
                            <i class="fas fa-edit"></i> Edit
                        </div>
                        <div class="menu-item delete" onclick="deleteExpense('${exp.id}')">
                            <i class="fas fa-trash"></i> Delete
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    `).join('');
}

function filterExpenses() {
    renderExpenses();
}

function openExpenseModal() {
    document.getElementById('expenseModalTitle').textContent = 'Add Expense';
    document.getElementById('expenseForm').reset();
    document.getElementById('editExpenseId').value = '';
    document.getElementById('expenseModal').classList.add('show');
}

function openEditExpenseModal(expId) {
    const expense = expenses.find(e => e.id === expId);
    if (!expense) return;

    document.getElementById('expenseModalTitle').textContent = 'Edit Expense';
    document.getElementById('expenseCategory').value = expense.category;
    document.getElementById('expenseDescription').value = expense.description;
    document.getElementById('expenseAmount').value = expense.amount;
    document.getElementById('expenseVendor').value = expense.vendor || '';
    document.getElementById('editExpenseId').value = expense.id;
    document.getElementById('expenseModal').classList.add('show');
}

function closeExpenseModal() {
    document.getElementById('expenseModal').classList.remove('show');
}

function saveExpense(event) {
    event.preventDefault();

    const category = document.getElementById('expenseCategory').value;
    const description = document.getElementById('expenseDescription').value.trim();
    const amount = parseFloat(document.getElementById('expenseAmount').value);
    const vendor = document.getElementById('expenseVendor').value.trim();
    const editId = document.getElementById('editExpenseId').value;

    if (!category || !description || isNaN(amount)) return;

    const now = new Date().toISOString();

    if (editId) {
        const index = expenses.findIndex(e => e.id === editId);
        if (index !== -1) {
            expenses[index] = { ...expenses[index], category, description, amount, vendor, lastModified: now };
        }
    } else {
        expenses.push({
            id: Date.now().toString(),
            date: now,
            category,
            description,
            amount,
            vendor,
            dateAdded: now
        });
    }

    saveData();
    renderExpenses();
    closeExpenseModal();
}

function deleteExpense(expId) {
    if (confirm('Delete this expense?')) {
        expenses = expenses.filter(e => e.id !== expId);
        saveData();
        renderExpenses();
    }
}

// ============
// RESTOCKING TAB FUNCTIONS
// ============

function renderRestocking() {
    const tbody = document.getElementById('restockingTableBody');
    const emptyState = document.getElementById('restockingEmptyState');
    const searchTerm = document.getElementById('restockingSearch').value.toLowerCase();

    let filtered = restockLogs;
    if (searchTerm) {
        filtered = filtered.filter(log =>
            log.productName.toLowerCase().includes(searchTerm) ||
            log.supplier.toLowerCase().includes(searchTerm)
        );
    }

    if (filtered.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.add('show');
        return;
    }

    emptyState.classList.remove('show');

    tbody.innerHTML = filtered.map(log => `
        <tr>
            <td>${formatDate(log.date)}</td>
            <td>${escapeHtml(log.productName)}</td>
            <td class="quantity">+${log.quantityAdded}</td>
            <td class="price">${formatCurrency(log.cost)}</td>
            <td>${escapeHtml(log.supplier || '--')}</td>
            <td class="actions-col">
                <div class="actions-menu">
                    <button class="menu-trigger" onclick="toggleMenu(event, 'rst-${log.id}')">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="menu-dropdown" id="menu-rst-${log.id}">
                        <div class="menu-item delete" onclick="deleteRestock('${log.id}')">
                            <i class="fas fa-trash"></i> Delete
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    `).join('');
}

function filterRestocking() {
    renderRestocking();
}

function openRestockModal() {
    document.getElementById('restockModalTitle').textContent = 'Add Restock';
    document.getElementById('restockForm').reset();
    document.getElementById('editRestockId').value = '';
    populateRestockProductSelect();
    document.getElementById('restockModal').classList.add('show');
}

function populateRestockProductSelect() {
    const select = document.getElementById('restockProduct');
    if (!select) return;

    const options = inventoryItems.map(item =>
        `<option value="${item.id}">${escapeHtml(item.name)}</option>`
    ).join('');
    select.innerHTML = '<option value="">Select product from inventory</option>' + options;
}

function closeRestockModal() {
    document.getElementById('restockModal').classList.remove('show');
}

function saveRestock(event) {
    event.preventDefault();

    const productId = document.getElementById('restockProduct').value;
    const quantityAdded = parseInt(document.getElementById('restockQuantity').value);
    const cost = parseFloat(document.getElementById('restockCost').value);
    const supplier = document.getElementById('restockSupplier').value.trim();

    if (!productId || isNaN(quantityAdded) || isNaN(cost)) return;

    const product = inventoryItems.find(i => i.id === productId);
    if (!product) return;

    // Update product quantity
    product.quantity += quantityAdded;
    product.totalValue = product.quantity * product.price;
    product.lastModified = new Date().toISOString();

    // Add restock log
    restockLogs.push({
        id: Date.now().toString(),
        date: new Date().toISOString(),
        productId,
        productName: product.name,
        quantityAdded,
        cost,
        supplier
    });

    saveData();
    renderInventory();
    renderRestocking();
    closeRestockModal();
}

function deleteRestock(rstId) {
    if (confirm('Delete this restocking log?')) {
        restockLogs = restockLogs.filter(r => r.id !== rstId);
        saveData();
        renderRestocking();
    }
}

// ============
// SALES TAB FUNCTIONS
// ============

function renderSales() {
    const tbody = document.getElementById('salesTableBody');
    const emptyState = document.getElementById('salesEmptyState');
    const searchTerm = document.getElementById('salesSearch').value.toLowerCase();

    let filtered = salesHistory;
    if (searchTerm) {
        filtered = filtered.filter(sale =>
            sale.id.toLowerCase().includes(searchTerm) ||
            sale.customerName.toLowerCase().includes(searchTerm)
        );
    }

    if (filtered.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.add('show');
        return;
    }

    emptyState.classList.remove('show');

    tbody.innerHTML = filtered.map(sale => `
        <tr>
            <td><code>${escapeHtml(sale.id)}</code></td>
            <td>${formatDateTime(sale.date)}</td>
            <td>${escapeHtml(sale.customerName || 'Walk-in')}</td>
            <td>${sale.items.length} item(s)</td>
            <td class="price">${formatCurrency(sale.total)}</td>
            <td><span class="category-badge">${formatPaymentMethod(sale.paymentMethod)}</span></td>
            <td class="actions-col">
                <button class="btn-action" onclick="viewSaleDetails('${sale.id}')" style="padding: 8px 16px; font-size: 12px;">
                    <i class="fas fa-eye"></i> View
                </button>
            </td>
        </tr>
    `).join('');
}

function filterSales() {
    renderSales();
}

function viewSaleDetails(saleId) {
    const sale = salesHistory.find(s => s.id === saleId);
    if (!sale) return;

    const itemsList = sale.items.map(item =>
        `${item.name} x${item.qty} - ${formatCurrency(item.price * item.qty)}`
    ).join('\n');

    alert(`Transaction: ${sale.id}\nDate: ${formatDateTime(sale.date)}\nCustomer: ${sale.customerName || 'Walk-in'}\n\nItems:\n${itemsList}\n\nTotal: ${formatCurrency(sale.total)}\nPayment: ${formatPaymentMethod(sale.paymentMethod)}`);
}

function exportSales() {
    alert('Export functionality coming soon!');
}

// ============
// CATEGORY MANAGEMENT
// ============

function openCategorySettings() {
    renderCategoryList();
    document.getElementById('categoryModal').classList.add('show');
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.remove('show');
}

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

function toggleMenu(event, itemId) {
    event.stopPropagation();
    const menu = document.getElementById(`menu-${itemId}`);

    document.querySelectorAll('.menu-dropdown.show').forEach(m => {
        if (m !== menu) m.classList.remove('show');
    });

    menu.classList.toggle('show');
}

function formatCurrency(amount) {
    return '₱' + parseFloat(amount).toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function formatDateTime(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' +
        d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}

function formatPaymentMethod(method) {
    const map = { 'cash': 'Cash', 'gcash': 'GCash', 'bank': 'Bank' };
    return map[method] || method;
}

function escapeHtml(text) {
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return text.toString().replace(/[&<>"']/g, m => map[m]);
}

// Close dropdowns/menus when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.btn-filter') && !e.target.closest('.filter-dropdown')) {
        const dropdown = document.getElementById('filterDropdown');
        const btn = document.querySelector('.btn-filter');
        if (dropdown && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
            btn.classList.remove('active');
        }
    }

    if (!e.target.closest('.actions-menu')) {
        document.querySelectorAll('.menu-dropdown.show').forEach(menu => {
            menu.classList.remove('show');
        });
    }
});

// Helper function for payment method formatting
function formatPaymentMethod(method) {
    return method.charAt(0).toUpperCase() + method.slice(1);
}
